<?php

namespace SmartOSC\Blog\Block\Category;

use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Template;
use Magento\Store\Model\StoreManagerInterface;
use SmartOSC\Blog\Api\CategoryRepositoryInterface;

class CategoryList extends Template
{
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var UrlInterface
     */
    protected $urlInterface;

    /**
     * @var CategoryRepositoryInterface
     */
    protected $categoryRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    public function __construct(
        Template\Context $context,
        CategoryRepositoryInterface $categoryRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        StoreManagerInterface $storeManager,
        UrlInterface $urlInterface,
        array $data = [])
    {
        $this->categoryRepository = $categoryRepository;
        $this->urlInterface = $urlInterface;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->storeManager= $storeManager;
        parent::__construct($context, $data);
    }

    public function getCategories()
    {
        if (!$this->hasData('categories')) {
            $categories = $this->categoryRepository->getList(
                $this->searchCriteriaBuilder->create()
            )->getItems();

            $this->setData('categories', $categories);
        }

        return $this->getData('categories');
    }


    /**
     * @param $categoryId
     * @return string
     */
    public function getCategoryUrl($categoryId)
    {
        return $this->getUrl('*/', ['category' => $categoryId]);
    }
    
}