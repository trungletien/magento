<?php
namespace Dev\Banner\Controller\Banner;


use Dev\Banner\Model\BannerRepository;

class BannerController extends \Magento\Framework\App\Action\Action
{
    protected $_pageFactory;
    protected $bannerFactory;
    protected $bannerRepository;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Dev\Banner\Model\BannerFactory $bannerFactory,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Dev\Banner\Model\BannerRepositoryFactory $bannerRepository)
    {
        $this->_pageFactory = $pageFactory;
        $this->bannerFactory = $bannerFactory;
        $this->bannerRepository = $bannerRepository;
        return parent::__construct($context);
    }

    public function execute()
    {
        echo $this->getRequest()->getParam('id');
        $bannerRepo = $this->bannerRepository->create();
        $banner = $bannerRepo->getById(1);
        print_r($banner->getDescription());

        $data = $this->bannerFactory->create()->getCollection();
        foreach ($data as $value) {
            echo "<pre>";
            print_r($value->getData());
            echo "</pre>";
        }
//        return $this->_pageFactory->create();
    }
}
