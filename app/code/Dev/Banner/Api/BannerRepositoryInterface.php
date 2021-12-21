<?php

namespace Dev\Banner\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Dev\Banner\Api\Data\BannerInterface;

/**
 * Interface CustomManagementInterface
 * @package ViMagento\CustomApi\Api
 */
interface BannerRepositoryInterface
{
    /**
     * @param int $id
     * @return \Dev\Banner\Api\Data\BannerInterface
     */
    public function getById($id);

    /**
     * @param \Dev\Banner\Api\Data\BannerInterface $banner
     * @return \Dev\Banner\Api\Data\BannerInterface
     */
    public function save(BannerInterface $banner);

    /**
     * @param int $id
     * @return bool
     */
    public function deleteById($id);

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Dev\Banner\Api\Data\BannerSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);
}
