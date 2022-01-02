<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Store\Mobilephone\Controller\Adminhtml\MobilePhone;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Backend\App\Action;
use Store\MobilePhone\Model\MobilePhoneFactory;

/**
 * Edit CMS page action.
 */
class InlineEdit extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Dev_Banner::save';

    protected $resultJsonFactory;
    protected $bannerFactory;

    public function __construct(
        Action\Context $context,
        JsonFactory $resultJsonFactory,
        MobilePhoneFactory $mobilePhoneFactory
    ) {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->mobilePhoneFactory = $mobilePhoneFactory;
        parent::__construct($context);
    }

    /**
     * Edit CMS page
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $resultJson = $this->resultJsonFactory->create();
        $messages = [];
        $error = false;

        //Get data
        $postItems = $this->getRequest()->getParam('items', []);
        foreach (array_keys($postItems) as $mobilePhoneID) {
            try {
                $mobilephone = $this->mobilePhoneFactory->create();
                $mobilephone->load($mobilePhoneID);
                $mobilephone->setData($postItems[(string)$mobilePhoneID]);
                $mobilephone->save();
            } catch (\Exception $e) {
                $messages[] = __('Something went wrong');
                $error = true;
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }
}
