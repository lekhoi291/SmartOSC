<?php

namespace SmartOSC\Blog\Model\Category\Source;

use Magento\Framework\Data\OptionSourceInterface;
use SmartOSC\Blog\Model\ResourceModel\Category\CollectionFactory as CategoryCollectionFactory;

/**
 * Class Categories
 * @package Aheadworks\Blog\Model\Source
 */
class Categories implements OptionSourceInterface
{
    /**
     * @var \SmartOSC\Blog\Model\ResourceModel\Category\CollectionFactory
     */
    private $categoryCollection;

    /**
     * @var array
     */
    private $options;

    /**
     * @param CategoryCollectionFactory $categoryCollectionFactory
     */
    public function __construct(CategoryCollectionFactory $categoryCollectionFactory)
    {
        $this->categoryCollection = $categoryCollectionFactory->create();
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        if (!$this->options) {
            $this->categoryCollection->setOrder('category_id', 'ASC');
            $this->options = $this->categoryCollection->toOptionArray();
        }
        return $this->options;
    }
}
