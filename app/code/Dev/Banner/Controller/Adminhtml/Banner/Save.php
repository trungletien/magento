<?php

namespace Dev\Banner\Controller\Adminhtml\Banner;

use Dev\Banner\Model\BannerFactory;
use Magento\Backend\App\Action;

/**
 * Class Save
 * @package Dev\Banner\Controller\Adminhtml\Banner
 */
class Save extends Action
{
    /**
     * @var BannerFactory
     */
    private $bannerFactory;

    /**
     * Save constructor.
     * @param Action\Context $context
     * @param BannerFactory $bannerFactory
     */
    public function __construct(
        Action\Context $context,
        BannerFactory $bannerFactory
    ) {
        parent::__construct($context);
        $this->bannerFactory = $bannerFactory;
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $id = !empty($data['banner_id']) ? $data['banner_id'] : null;

        $newData = [
            'name' => $data['name'],
            'description' => $data['description'],
            'status' => $data['status'],
            'image' => $data['image'],
        ];

        $banner = $this->bannerFactory->create();

        if ($id) {
            $banner->load($id);
        }
        try {
            $banner->addData($newData);
            $banner->save();
            $this->messageManager->addSuccessMessage(__('You saved the banner.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__($e->getMessage()));
        }

        return $this->resultRedirectFactory->create()->setPath('admindevbanner/banner/index');
    }
}
