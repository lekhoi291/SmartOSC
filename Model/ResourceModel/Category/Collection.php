<?php


namespace SmartOSC\Blog\Model\ResourceModel\Category;


use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'category_id';

    protected function _construct()
    {
        $this->_init(
            'SmartOSC\Blog\Model\Category',
            'SmartOSC\Blog\Model\ResourceModel\Category'
        );
    }

    /**
     * @return $this
     */
    public function addIsActiveFilter()
    {
        $this->addFieldToFilter('is_active', 1);
        $this->_eventManager->dispatch(
            $this->_eventPrefix . '_add_is_active_filter',
            [$this->_eventObject => $this]
        );
        return $this;
    }

}