<?php


namespace SmartOSC\Blog\Model\Category;


use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Store\Model\StoreManagerInterface;
use SmartOSC\Blog\Model\ResourceModel\Category\CollectionFactory as CategoryCollectionFactory;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{

    /**
     * @var CollectionFactory
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    public function __construct(
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        CategoryCollectionFactory $collection,
        DataPersistorInterface $dataPersistor,
        StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = []
    )
    {
        $this->collection = $collection->create();
        $this->dataPersistor = $dataPersistor;
        $this->storeManager = $storeManager;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Prepares Meta
     *
     * @param array $meta
     * @return array
     */
    public function prepareMeta(array $meta)
    {
        return $meta;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {

        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        /** @var $post \SmartOSC\Blog\Model\Category */
        foreach ($items as $category) {
            $this->loadedData[$category->getCategoryId()] = $category->getData();
        }

        $data = $this->dataPersistor->get('blog_category');

        if (!empty($data)) {
            $category = $this->collection->getNewEmptyItem();
            $category->setData($data);
            $this->loadedData[$category->getCategoryId()] = $category->getData();
            $this->dataPersistor->clear('blog_category');
        }

        return $this->loadedData;
    }



}