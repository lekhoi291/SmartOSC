<?php

namespace SmartOSC\Blog\Model;

use Magento\Framework\DataObject\IdentityInterface;
use SmartOSC\Blog\Api\Data\TagInterface;

class Tag extends AbstractBlogModel implements TagInterface, IdentityInterface
{
    /**
     * BLOG TAG cache tag
     */
    const CACHE_TAG = 'blog_tag';

    /**
     * @var string
     */
    protected $_cacheTag = 'blog_tag';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'blog_tag';

    /**
     * Initialize resource model
     */
    protected function _construct()
    {
        $this->_init('SmartOSC\Blog\Model\ResourceModel\Tag');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG.'_'.$this->getId()];
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getData(self::TAG_ID);
    }

    /**
     * @inheritdoc
     */
    public function getTagId()
    {
        return $this->getData(self::TAG_ID);
    }

    /**
     * @inheritdoc
     */
    public function setTagId($id)
    {
        $this->setData(self::TAG_ID, $id);
    }

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
    public function getDescription()
    {
        return $this->getData(self::DESCRIPTION);
    }

    /**
     * @inheritdoc
     */
    public function setDescription($description)
    {
        $this->setData(self::DESCRIPTION, $description);
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