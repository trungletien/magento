<?php

namespace Store\MobilePhone\Controller\Adminhtml\Category;

use Store\MobilePhone\Model\MobilePhone;

/**
 * Controller for mobilephone listing
 */
class Index extends \Magento\Backend\App\Action
{

    protected $_pageFactory;


    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $_pageFactory
    ) {
        parent::__construct($context);
        $this->_pageFactory = $_pageFactory;
    }


    public function execute()
    {
        $resultPage = $this->_pageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Loại điện thoại'));

        return $resultPage;
    }
}
