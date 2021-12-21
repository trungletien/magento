<?php

namespace Dev\Banner\ViewModel;


use Dev\Banner\Model\BannerRepositoryFactory;

class BannerBreadCrumbs  implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    private $bannerRepoFactory;

    public function __construct(BannerRepositoryFactory $bannerRepoFactory)
    {
        $this->bannerRepoFactory = $bannerRepoFactory;
    }

    public function getBanner()
    {
        $bannerInstance = $this->bannerRepoFactory->create();
        $banner = $bannerInstance->getById(1);

        return $banner->getName();
    }
}
