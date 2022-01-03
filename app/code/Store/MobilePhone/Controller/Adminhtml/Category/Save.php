<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Store\MobilePhone\Controller\Adminhtml\Category;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Backend\App\Action\Context;
use Magento\Cms\Api\BlockRepositoryInterface;
use Store\MobilePhone\Model\CategoryFactory;
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
     * @var CategoryFactory
     */
    private $categoryFactory;


    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param DataPersistorInterface $dataPersistor
     * @param CategoryFactory|null $categoryFactory
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        DataPersistorInterface $dataPersistor,
        CategoryFactory $categoryFactory = null,
        BlockRepositoryInterface $blockRepository = null
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->categoryFactory = $categoryFactory
            ?: \Magento\Framework\App\ObjectManager::getInstance()->get(CategoryFactory::class);
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
            if (empty($data['category_id'])) {
                $data['category_id'] = null;
            }

            /** @var \Magento\Cms\Model\Block $model */
            $categoryFactory = $this->categoryFactory->create();

            $id = $this->getRequest()->getParam('category_id');
            if ($id) {
                try {
                    $categoryFactory = $categoryFactory->load($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This block no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }

            $data['image'] =  $data['images'][0]['name'];

            $categoryFactory->setData($data);

            try {
                $categoryFactory->save();
                $this->messageManager->addSuccessMessage(__('You saved the Category.'));
                return $resultRedirect->setPath('store/category/index');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the block.'));
            }

            return $resultRedirect->setPath('store/category/edit', ['category_id' => $id]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
