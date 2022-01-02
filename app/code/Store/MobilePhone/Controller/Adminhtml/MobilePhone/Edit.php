<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Store\MobilePhone\Controller\Adminhtml\MobilePhone;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Store\MobilePhone\Model\MobilePhone;

/**
 * Edit CMS block action.
 */
class Edit extends \Magento\Cms\Controller\Adminhtml\Block implements HttpGetActionInterface
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Edit CMS block
     *
     * @return \Magento\Framework\Controller\ResultInterface
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('mobile_phone_id');
        $model = $this->_objectManager->create(MobilePhone::class);

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This MobilePhone no longer exists.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('store/mobilephone/index');
            }
        }

        $this->_coreRegistry->register('mobilePhone', $model);

        // 5. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $this->initPage($resultPage)->addBreadcrumb(
            $id ? __('Edit Mobile Phone') : __('New Mobile Phone'),
            $id ? __('Edit Mobile Phone') : __('New Mobile Phone')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Mobile Phone'));
        $resultPage->getConfig()->getTitle()->prepend($model->getId() ? $model->getName() : __('New Mobile Phone'));
        return $resultPage;
    }
}
