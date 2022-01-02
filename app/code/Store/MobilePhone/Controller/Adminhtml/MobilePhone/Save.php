<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Store\MobilePhone\Controller\Adminhtml\MobilePhone;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Backend\App\Action\Context;
use Magento\Cms\Api\BlockRepositoryInterface;
use Store\MobilePhone\Model\MobilePhoneFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;

/**
 * Save CMS block action.
 */
class Save extends \Magento\Backend\App\Action
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var MobilePhoneFactory
     */
    private $mobilePhoneFactory;


    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param DataPersistorInterface $dataPersistor
     * @param MobilePhoneFactory|null $mobilePhoneFactory
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        DataPersistorInterface $dataPersistor,
        MobilePhoneFactory $mobilePhoneFactory = null,
        BlockRepositoryInterface $blockRepository = null
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->mobilePhoneFactory = $mobilePhoneFactory
            ?: \Magento\Framework\App\ObjectManager::getInstance()->get(MobilePhoneFactory::class);
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            if (empty($data['mobile_phone_id'])) {
                $data['mobile_phone_id'] = null;
            }

            /** @var \Magento\Cms\Model\Block $model */
            $modelMobilePhone = $this->mobilePhoneFactory->create();

            $id = $this->getRequest()->getParam('mobile_phone_id');
            if ($id) {
                try {
                    $modelMobilePhone = $modelMobilePhone->load($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This block no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }

            $data['image'] =  $data['images'][0]['name'];

            $modelMobilePhone->setData($data);

            try {
                $modelMobilePhone->save();
                $this->messageManager->addSuccessMessage(__('You saved the MobilePhone.'));
                return $resultRedirect->setPath('store/mobilephone/index');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the block.'));
            }

            return $resultRedirect->setPath('store/mobilephone/edit', ['mobile_phone_id' => $id]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
