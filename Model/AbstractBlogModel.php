<?php

namespace SmartOSC\Blog\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Store\Model\StoreManagerInterface;

class AbstractBlogModel extends AbstractModel
{
    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;

    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        StoreManagerInterface $storeManager,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    )
    {
        $this->_storeManager = $storeManager;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

}