<?php

namespace Store\MobilePhone\Controller\Adminhtml\MobilePhone;

use Store\MobilePhone\Model\MobilePhone;

/**
 * Controller for mobilephone listing
 */
class Index extends \Magento\Backend\App\Action
{

    protected $_pageFactory;

    protected $mobilePhoneFactory;


    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $_pageFactory,
        \Store\MobilePhone\Model\MobilePhoneFactory $mobilePhoneFactory
    ) {
        parent::__construct($context);
        $this->_pageFactory = $_pageFactory;
        $this->mobilePhoneFactory = $mobilePhoneFactory;
    }


    public function execute()
    {
        $resultPage = $this->_pageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Thiên điểu và ve sầu'));

        return $resultPage;
    }
}
