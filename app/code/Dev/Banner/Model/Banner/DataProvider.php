<?php

namespace Dev\Banner\Model\Banner;

use Dev\Banner\Model\BannerFactory;
use Dev\Banner\Model\ResourceModel\Banner\CollectionFactory;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected $_loadedData;
    protected $collection;
    protected $storeManager;
    protected $logger;


    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        StoreManagerInterface $storeManager,
        LoggerInterface $logger,
        array $meta = [],
        array $data = []
    )
    {
        $this->collection = $collectionFactory->create();
        $this->storeManager = $storeManager;
        $this->logger = $logger;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (isset($this->_loadedData)) {
            return $this->_loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $item) {
            $data = $item->getData();
            $image = $data['image'];
            $data['images'][0]['url'] = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . 'banner/images/' . $image;
            $data['images'][0]['name'] = $image;
            $this->_loadedData[$item->getId()] = $data;
        }

        return $this->_loadedData;
    }
}
