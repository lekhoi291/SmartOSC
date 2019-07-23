<?php

namespace SmartOSC\Blog\Api;

use SmartOSC\Blog\Api\Data\CategoryInterface;

interface CategoryRepositoryInterface
{
    /**
     * Save blog
     *
     * @param \SmartOSC\Blog\Api\Data\CategoryInterface $category
     * @param bool $saveOptions
     * @return \SmartOSC\Blog\Api\Data\CategoryInterface
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\StateException
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(\SmartOSC\Blog\Api\Data\CategoryInterface $category, $saveOptions = false);

    /**
     * Get Blog by ID
     * @param int $category_id
     * @return \SmartOSC\Blog\Api\Data\CategoryInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function get($category_id);

    /**
     * Get category by URL key
     *
     * @param string $url_key
     * @return \SmartOSC\Blog\Api\Data\CategoryInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getByUrlKey($url_key);

    /**
     * Delete blog object
     *
     * @param CategoryInterface $category
     * @return bool
     */
    public function delete(CategoryInterface $category);

    /**
     * Delete Blog by ID
     *
     * @param int $category_id
     * @return bool
     */
    public function deleteById($category_id);

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \SmartOSC\Blog\Api\Data\CategorySearchInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

}