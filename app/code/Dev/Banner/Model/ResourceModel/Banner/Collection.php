<?php

namespace Dev\Banner\Model\ResourceModel\Banner;

use Dev\Banner\Model\Banner;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    public function _construct()
    {
        $this->_init(Banner::class, \Dev\Banner\Model\ResourceModel\Banner::class);
        parent::_construct(); // TODO: Change the autogenerated stub
    }
}
