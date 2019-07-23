<?php

namespace SmartOSC\Blog\Api\Data;

interface CategorySearchInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get blog list
     * @return \SmartOSC\Blog\Api\Data\CategoryInterface[]
     */
    public function getItems();

    /**
     * @param \SmartOSC\Blog\Api\Data\CategoryInterface[] $items
     * @return $this
     */
    public function setItems(array $items);

}