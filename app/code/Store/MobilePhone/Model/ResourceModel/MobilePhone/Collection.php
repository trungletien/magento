<?php

namespace Store\MobilePhone\Model\ResourceModel\MobilePhone;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Store\MobilePhone\Model\MobilePhone', 'Store\MobilePhone\Model\ResourceModel\MobilePhone');
    }
}
