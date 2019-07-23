<?php

namespace SmartOSC\Blog\Api\Data;

interface TagInterface
{
    const TAG_ID = 'tag_id';
    const NAME = 'name';
    const URL_KEY = 'url_key';
    const DESCRIPTION = 'description';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    /**
     * @return int
     */
    public function getTagId();

    /**
     * @param int $id
     * @return $this
     */
    public function setTagId($id);

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
    public function getUrlKey();

    /**
     * @param string $url_key
     * @return $this
     */
    public function setUrlKey($url_key);

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