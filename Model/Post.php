<?php

namespace SmartOSC\Blog\Model;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\Framework\DataObject\IdentityInterface;
use SmartOSC\Blog\Api\Data\PostInterface;

class Post extends AbstractBlogModel implements PostInterface, IdentityInterface
{
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    /**
     * BLOG POST cache tag
     */
    const CACHE_TAG = 'blog_post';

    /**
     * @var string`
     */
    protected $_cacheTag = 'blog_post';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'blog_post';

    /**
     * Initialize resource model
     */
    protected function _construct()
    {
        $this->_init('SmartOSC\Blog\Model\ResourceModel\Post');
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
        return $this->getData(self::POST_ID);
    }

    /**
     * @inheritdoc
     */
    public function getPostId()
    {
        return $this->getData(self::POST_ID);
    }

    /**
     * @inheritdoc
     */
    public function setPostId($post_id)
    {
        $this->setData(self::POST_ID, $post_id);
    }

    /**
     * @inheritdoc
     */
    public function getStoreId()
    {
        return $this->getData(self::STORE_ID);
    }

    /**
     * @inheritdoc
     */
    public function setStoreId($store_id)
    {
        $this->setData(self::STORE_ID, $store_id);
    }

    /**
     * @inheritdoc
     */
    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

    /**
     * @inheritdoc
     */
    public function setTitle($title)
    {
        $this->setData(self::TITLE, $title);
    }

    /**
     * @inheritdoc
     */
    public function getContent()
    {
        return $this->getData(self::CONTENT);
    }

    /**
     * @inheritdoc
     */
    public function setContent($content)
    {
        $this->setData(self::CONTENT, $content);
    }

    /**
     * @inheritdoc
     */
    public function getCategoryIds()
    {
        return $this->getData(self::CATEGORY_IDS);
    }

    public function setCategoryIds($category_ids)
    {
        $this->setData(self::CATEGORY_IDS, $category_ids);
    }

    /**
     * @inheritdoc
     */
    public function getProductIds()
    {
        return $this->getData(self::PRODUCT_IDS);
    }

    public function setProductIds($product_ids)
    {
        $this->setData(self::PRODUCT_IDS, $product_ids);
    }

    /**
     * @inheritdoc
     */
    public function getTagIds()
    {
        return $this->getData(self::TAG_IDS);
    }

    public function setTagIds($tag_ids)
    {
        $this->setData(self::TAG_IDS, $tag_ids);
    }

    /**
     * @inheritdoc
     */
    public function getAuthorId()
    {
        return $this->getData(self::AUTHOR_ID);
    }

    /**
     * @inheritdoc
     */
    public function setAuthorId($author_id)
    {
        $this->setData(self::AUTHOR_ID, $author_id);
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
    public function getIsFeatured()
    {
        return (bool)$this->getData(self::IS_FEATURED);
    }

    /**
     * @inheritdoc
     */
    public function setIsFeatured($isFeatured)
    {
        $this->setData(self::IS_FEATURED, $isFeatured);
    }

    /**
     * @inheritdoc
     */
    public function getAllowComment()
    {
        return $this->getData(self::ALLOW_COMMENT);
    }

    /**
     * @inheritdoc
     */
    public function setAllowComment($allow_comment)
    {
        $this->setData(self::ALLOW_COMMENT, $allow_comment);
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
    public function getViews()
    {
        return $this->getData(self::VIEWS);
    }

    /**
     * @inheritdoc
     */
    public function setViews($views)
    {
        $this->setData(self::VIEWS, $views);
    }

    /**
     * @inheritdoc
     */
    public function getImage()
    {
        return $this->getData(self::IMAGE);
    }

    /**
     * @inheritdoc
     */
    public function setImage($image)
    {
        $this->setData(self::IMAGE, $image);
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