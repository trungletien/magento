<?php

namespace Store\MobilePhone\Controller\Adminhtml\MobilePhone;

use Magento\Backend\App\Action;
use Magento\Framework\Exception\LocalizedException;
use Store\MobilePhone\Model\ResourceModel\MobilePhone\CollectionFactory;
use Store\MobilePhone\Model\MobilePhoneFactory;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Backend\Model\View\Result\RedirectFactory;

class Delete extends Action
{
    private $mobileFactory;
    private $filter;
    private $collectionFactory;
    private $resultRedirect;

    public function __construct(
        Action\Context $context,
        MobilePhoneFactory $mobileFactory,
        Filter $filter,
        CollectionFactory $collectionFactory,
        RedirectFactory $redirectFactory
    )
    {
        parent::__construct($context);
        $this->mobileFactory = $mobileFactory;
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->resultRedirect = $redirectFactory;
    }

    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $total = 0;
        $err = 0;
        foreach ($collection->getItems() as $item) {
            $deleteBanner = $this->mobileFactory->create()->load($item->getData('mobile_phone_id'));
            try {
                $deleteBanner->delete();
                $total++;
            } catch (LocalizedException $exception) {
                $err++;
            }
        }

        if ($total) {
            $this->messageManager->addSuccessMessage(
                __('A total of %1 record(s) have been deleted.', $total)
            );
        }

        if ($err) {
            $this->messageManager->addErrorMessage(
                __(
                    'A total of %1 record(s) haven\'t been deleted. Please see server logs for more details.',
                    $err
                )
            );
        }
        return $this->resultRedirect->create()->setPath('store/mobilephone/index');
    }
}
