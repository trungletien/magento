<?php

namespace Store\MobilePhone\Model\ResourceModel;

class MobilePhone extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('mobile_phone', 'mobile_phone_id');
    }

    public function _afterSave(\Magento\Framework\Model\AbstractModel $object)
    {
        $image = $object->getData('image');
        if ($image != null) {
            $imageUploader = \Magento\Framework\App\ObjectManager::getInstance()->get('Store\MobilePhone\MobilePhoneImageUpload');
            $imageUploader->moveFileFromTmp($image);
        }
        return $this; // TODO: Change the autogenerated stub
    }
}
