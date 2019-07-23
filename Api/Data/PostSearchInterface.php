<?php


namespace SmartOSC\Blog\Api\Data;


interface PostSearchInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get blog list
     * @return \SmartOSC\Blog\Api\Data\PostInterface[]
     */
    public function getItems();

    /**
     * @param \SmartOSC\Blog\Api\Data\PostInterface[] $items
     * @return $this
     */
    public function setItems(array $items);

}