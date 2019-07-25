<?php
/**
 * Copyright 2018 aheadWorks. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace SmartOSC\Blog\Model\Category\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class Categories
 * @package Aheadworks\Blog\Model\Source
 */
class Products implements OptionSourceInterface
{
    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var array
     */
    private $options;

    /**
     * Products constructor.
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     */
    public function __construct(
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
    )
    {
        $this->productRepository = $productRepository->create();
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
