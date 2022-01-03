<?php

namespace Store\MobilePhone\Model\ResourceModel\Category;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Store\MobilePhone\Model\Category', 'Store\MobilePhone\Model\ResourceModel\Category');
    }
}
