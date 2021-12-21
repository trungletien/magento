<?php

namespace Dev\Banner\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

/**
 * Interface BannerInterface
 * @package Dev\Banner\Api\Data
 */
interface BannerInterface extends ExtensibleDataInterface
{
    /**
     * @return int
     */
    public function getBannerId();

    /**
     * @param int $entityId
     * @return $this
     */
    public function setBannerId($entityId);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getDescription();

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription($description);

    /**
     * @return string
     */
    public function getImage();

    /**
     * @param string $image
     * @return $this
     */
    public function setImage($image);

    /**
     * @return string
     */
    public function getStatus();

    /**
     * @param string $status
     * @return $this
     */
    public function setStatus($status);
}
