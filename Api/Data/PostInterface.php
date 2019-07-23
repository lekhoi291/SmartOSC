<?php

namespace SmartOSC\Blog\Api\Data;

interface PostInterface
{
    CONST POST_ID = 'post_id';
    CONST STORE_ID = 'store_id';
    CONST TITLE = 'title';
    CONST CONTENT = 'content';
    CONST CATEGORY_IDS = 'category_ids';
    CONST AUTHOR_ID = 'author_id';
    CONST IS_ACTIVE = 'is_active';
    CONST IS_FEATURED = 'is_featured';
    CONST ALLOW_COMMENT = 'allow_comment';
    CONST URL_KEY = 'url_key';
    CONST VIEWS = 'views';
    CONST IMAGE = 'image';
    CONST CREATED_AT = 'created_at';
    CONST UPDATED_AT = 'updated_at';

    /**
     * @return int
     */
    public function getPostId();

    /**
     * @param int $post_id
     * @return $this
     */
    public function setPostId($post_id);

    /**
     * @return int
     */
    public function getStoreId();

    /**
     * @param int $store_id
     * @return $this
     */
    public function setStoreId($store_id);

    /**
     * @return string
     *
     */
    public function getTitle();

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle($title);

    /**
     * @return string
     */
    public function getContent();

    /**
     * @param string $content
     * @return $this
     */
    public function setContent($content);

    /**
     * @return int[]|null
     */
    public function getCategoryIds();

    /**
     * @param int[] $category_ids
     * @return $this
     */
    public function setCategoryIds($category_ids);

    /**
     * @return int
     */
    public function getAuthorId();

    /**
     * @param int $author_id
     * @return $this
     */
    public function setAuthorId($author_id);

    /**
     * @return bool
     */
    public function getIsActive();

    /**
     * @param int|bool $isActive
     * @return $this
     */
    public function setIsActive($isActive);

    /**
     * @return bool
     */
    public function getIsFeatured();

    /**
     * @param int|bool $isFeatured
     * @return $this
     */
    public function setIsFeatured($isFeatured);

    /**
     * @return bool
     */
    public function getAllowComment();

    /**
     * @param bool $allow_comment
     * @return $this
     */
    public function setAllowComment($allow_comment);

    /**
     * @return string
     */
    public function getUrlKey();

    /**
     * @param string $url_key
     * @return $this
     */
    public function setUrlKey($url_key);

    /**
     * @return int
     */
    public function getViews();

    /**
     * @param int $views
     * @return $this
     */
    public function setViews($views);

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
    public function getCreatedAt();

    /**
     * @param string $created_at
     * @return $this
     */
    public function setCreatedAt($created_at);

    /**
     * @return string
     */
    public function getUpdatedAt();

    /**
     * @param string $updated_at
     * @return $this
     */
    public function setUpdatedAt($updated_at);

}