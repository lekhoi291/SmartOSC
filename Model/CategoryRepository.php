<?php

namespace SmartOSC\Blog\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessor;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use SmartOSC\Blog\Api\Data\CategoryInterface;
use SmartOSC\Blog\Api\Data\CategorySearchInterfaceFactory;
use SmartOSC\Blog\Api\CategoryRepositoryInterface;
use SmartOSC\Blog\Model\ResourceModel\Category as CategoryResource;
use SmartOSC\Blog\Model\ResourceModel\Category\CollectionFactory as CategoryCollectionFactory;

class CategoryRepository implements CategoryRepositoryInterface
{
    /**
     * @var \SmartOSC\Blog\Model\ResourceModel\Category
     */
    protected $categoryResource;

    /**
     * @var CategoryFactory
     */
    protected $categoryFactory;

    /**
     * @var CategoryCollectionFactory
     */
    protected $collection;

    /**
     * @var CategorySearchInterfaceFactory
     */
    protected $categorySearchFactory;

    /**
     * @var CollectionProcessor
     */
    private $collectionProcessor;

    public function __construct(
        CategoryResource $categoryResource,
        CategoryFactory $categoryFactory,
        CategoryCollectionFactory $collection,
        CategorySearchInterfaceFactory $categorySearchFactory,
        CollectionProcessor $collectionProcessor
    )
    {
        $this->categoryResource = $categoryResource;
        $this->categoryFactory = $categoryFactory;
        $this->collection = $collection;
        $this->categorySearchFactory = $categorySearchFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @param CategoryInterface $category
     * @param bool $saveOptions
     * @return CategoryInterface
     * @throws CouldNotSaveException
     */
    public function save(CategoryInterface $category, $saveOptions = false)
    {
        try {
            $this->categoryResource->save($category);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save category: %1', $exception->getMessage()),
                $exception
            );
        }
        return $category;
    }

    /**
     * @param int $category_id
     * @return CategoryInterface|Category
     */
    public function get($category_id)
    {
        $category = $this->categoryFactory->create();
        $this->categoryResource->load($category, $category_id);

        return $category;
    }

    /**
     * @param string $url_key
     * @return CategoryInterface|Category
     */
    public function getByUrlKey($url_key)
    {
        $category = $this->categoryFactory->create();
        $this->categoryResource->load($category, $url_key, 'url_key');

        return $category;
    }

    /**
     * @param CategoryInterface $category
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(CategoryInterface $category)
    {
        try {
            $this->categoryResource->delete($category);

        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the category: %1',
                $exception->getMessage()
            ));
        }

        return true;

    }

    /**
     * @param int $category_id
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($category_id)
    {
        return $this->delete($this->get($category_id));
    }

    /**
     * @inheritdoc
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->collection->create();
        $collection->addIsActiveFilter();
        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResult = $this->categorySearchFactory->create();

        $searchResult->setSearchCriteria($searchCriteria);
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());

        return $searchResult;

    }


}