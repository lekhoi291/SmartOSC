<?php

namespace SmartOSC\Blog\Api\Data;

interface CategoryInterface
{
    const CATEGORY_ID = 'category_id';
    const NAME = 'name';
    const URL_KEY = 'url_key';
    const META_TITLE = 'meta_title';
    const META_DESCRIPTION = 'meta_description';
    const IS_ACTIVE = 'is_active';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    /**
     * @return mixed
     */
    public function getCategoryId();

    /**
     * @param $category_id
     * @return mixed
     */
    public function setCategoryId($category_id);

    /**
     * @return mixed
     */
    public function getName();

    /**
     * @param $name
     * @return mixed
     */
    public function setName($name);

    /**
     * @return mixed
     */
    public function getUrlKey();

    /**
     * @param $urlKey
     * @return mixed
     */
    public function setUrlKey($urlKey);

    /**
     * @return mixed
     */
    public function getMetaTitle();

    /**
     * @param $metaTitle
     * @return mixed
     */
    public function setMetaTitle($metaTitle);

    /**
     * @return mixed
     */
    public function getMetaDescription();

    /**
     * @param $metaDescription
     * @return mixed
     */
    public function setMetaDescription($metaDescription);

    /**
     * @return mixed
     */
    public function getIsActive();

    /**
     * @param $isActive
     * @return mixed
     */
    public function setIsActive($isActive);
    public function getCreatedAt();
    public function setCreatedAt($created_at);
    public function getUpdatedAt();
    public function setUpdatedAt($updated_at);

}