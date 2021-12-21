<?php

namespace Dev\Banner\Model;

use Dev\Banner\Api\Data\BannerInterface;
use Dev\Banner\Model\ResourceModel\Banner\Collection;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class CustomManagement
 * @package ViMagento\CustomApi\Model
 */
class BannerRepository implements \Dev\Banner\Api\BannerRepositoryInterface
{
    /**
     * @var \Dev\Banner\Model\BannerFactory
     */
    protected $bannerFactory;

    /**
     * @var ResourceModel\Banner
     */
    protected $bannerResource;

    /**
     * @var ResourceModel\Banner\CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var \Dev\Banner\Api\Data\BannerSearchResultInterfaceFactory
     */
    protected $searchResultInterfaceFactory;

    /**
     * BannerRepository constructor.
     * @param \Dev\Banner\Model\BannerFactory $bannerFactory
     * @param ResourceModel\Banner $customResource
     * @param ResourceModel\Banner\CollectionFactory $collectionFactory
     * @param \Dev\Banner\Api\Data\BannerSearchResultInterfaceFactory $searchResultInterfaceFactory
     */
    public function __construct(
        \Dev\Banner\Model\BannerFactory $bannerFactory,
        \Dev\Banner\Model\ResourceModel\Banner $bannerResource,
        \Dev\Banner\Model\ResourceModel\Banner\CollectionFactory $collectionFactory,
        \Dev\Banner\Api\Data\BannerSearchResultInterfaceFactory $searchResultInterfaceFactory
    ) {
        $this->bannerFactory = $bannerFactory;
        $this->bannerResource = $bannerResource;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultInterfaceFactory = $searchResultInterfaceFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function getById($id)
    {
        $bannerModel = $this->bannerFactory->create();
        $this->bannerResource->load($bannerModel, $id);
        if (!$bannerModel->getBannerId()) {
            throw new NoSuchEntityException(__('Unable to find banner data with ID "%1"', $id));
        }
        return $bannerModel;
    }

    /**
     * {@inheritdoc}
     */
    public function save(BannerInterface $banner)
    {
        $this->bannerResource->save($banner);
        return $banner;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($id)
    {
        try {
            $bannerModel = $this->bannerFactory->create();
            $this->bannerResource->load($bannerModel, $id);
            $this->bannerResource->delete($bannerModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the entry: %1', $exception->getMessage())
            );
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->collectionFactory->create();

        $this->addFiltersToCollection($searchCriteria, $collection);
        $this->addSortOrdersToCollection($searchCriteria, $collection);
        $this->addPagingToCollection($searchCriteria, $collection);

        $collection->load();

        return $this->buildSearchResult($searchCriteria, $collection);
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @param Collection $collection
     */
    private function addFiltersToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            $fields = $conditions = [];
            foreach ($filterGroup->getFilters() as $filter) {
                $fields[] = $filter->getField();
                $conditions[] = [$filter->getConditionType() => $filter->getValue()];
            }
            $collection->addFieldToFilter($fields, $conditions);
        }
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @param Collection $collection
     */
    private function addSortOrdersToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        foreach ((array)$searchCriteria->getSortOrders() as $sortOrder) {
            $direction = $sortOrder->getDirection() == SortOrder::SORT_ASC ? 'asc' : 'desc';
            $collection->addOrder($sortOrder->getField(), $direction);
        }
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @param Collection $collection
     */
    private function addPagingToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        $collection->setPageSize($searchCriteria->getPageSize());
        $collection->setCurPage($searchCriteria->getCurrentPage());
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @param Collection
     * @return mixed
     */
    private function buildSearchResult(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        $searchResults = $this->searchResultInterfaceFactory->create();

        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }
}
