<?php

namespace SmartOSC\Blog\Model;

use Magento\Framework\DataObject\IdentityInterface;
use SmartOSC\Blog\Api\Data\CategoryInterface;

class Category extends AbstractBlogModel implements CategoryInterface, IdentityInterface
{
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    /**
     * BLOG CATEGORY cache tag
     */
    const CACHE_TAG = 'blog_category';

    /**
     * @var string
     */
    protected $_cacheTag = 'blog_category';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'blog_category';

    /**
     * Initialize resource model
     */
    protected function _construct()
    {
        $this->_init('SmartOSC\Blog\Model\ResourceModel\Category');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG.'_'.$this->getId()];
    }

    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getData(self::CATEGORY_ID);
    }

    /**
     * @inheritdoc
     */
    public function getCategoryId()
    {
        return $this->getData(self::CATEGORY_ID);
    }

    /**
     * @inheritdoc
     */
    public function setCategoryId($category_id)
    {
        $this->setData(self::CATEGORY_ID, $category_id);
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * @inheritdoc
     */
    public function setName($name)
    {
        $this->setData(self::NAME, $name);
    }

    /**
     * @inheritdoc
     */
    public function getMetaTitle()
    {
        return $this->getData(self::META_TITLE);
    }

    /**
     * @inheritdoc
     */
    public function setMetaTitle($metaTitle)
    {
        $this->setData(self::META_TITLE, $metaTitle);
    }

    /**
     * @inheritdoc
     */
    public function getMetaDescription()
    {
        return $this->getData(self::META_DESCRIPTION);
    }

    /**
     * @inheritdoc
     */
    public function setMetaDescription($metaDescription)
    {
        $this->setData(self::META_DESCRIPTION, $metaDescription);
    }

    /**
     * @inheritdoc
     */
    public function getIsActive()
    {
        return (bool)$this->getData(self::IS_ACTIVE);
    }

    /**
     * @inheritdoc
     */
    public function setIsActive($isActive)
    {
        $this->setData(self::IS_ACTIVE, $isActive);
    }

    /**
     * @inheritdoc
     */
    public function getUrlKey()
    {
        return $this->getData(self::URL_KEY);
    }

    /**
     * @inheritdoc
     */
    public function setUrlKey($url_key)
    {
        $this->setData(self::URL_KEY, $url_key);
    }


    /**
     * @inheritdoc
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * @inheritdoc
     */
    public function setCreatedAt($created_at)
    {
        $this->setData(self::CREATED_AT, $created_at);
    }

    /**
     * @inheritdoc
     */
    public function getUpdatedAt()
    {
        return $this->getData(self::UPDATED_AT);
    }

    /**
     * @inheritdoc
     */
    public function setUpdatedAt($updated_at)
    {
        $this->setData(self::UPDATED_AT, $updated_at);
    }

}