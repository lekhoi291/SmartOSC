<?php

namespace SmartOSC\Blog\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Category extends AbstractDb
{

    /**
     * Initialize resource model
     */
    protected function _construct()
    {
        $this->_init('SmartOSC_blog_category', 'category_id');
    }
}