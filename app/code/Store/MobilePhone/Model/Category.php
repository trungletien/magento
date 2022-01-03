<?php

namespace Store\MobilePhone\Model;

/**
 * Mobile Phone
 */
class Category extends \Magento\FrameWork\Model\AbstractModel

{
    protected function _construct()
    {
        $this->_init('Store\MobilePhone\Model\ResourceModel\Category');
    }
}
