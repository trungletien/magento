<?php

namespace Dev\Banner\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Banner extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('banner', 'banner_id');
    }

    public function _afterSave(\Magento\Framework\Model\AbstractModel $object)
    {
        $image = $object->getData('image');
        if ($image != null) {
            $imageUploader = \Magento\Framework\App\ObjectManager::getInstance()->get('Dev\Banner\BannerImageUpload');
            $imageUploader->moveFileFromTmp($image);
        }
        return $this; // TODO: Change the autogenerated stub
    }
}
