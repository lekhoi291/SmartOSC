<?php

namespace SmartOSC\Blog\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Post extends AbstractDb
{

    /**
     * Initialize resource model
     */
    protected function _construct()
    {
        $this->_init('SmartOSC_blog_post', 'post_id');
    }

    /*protected function _getLoadSelect($field, $value, $object)
    {
        $select = parent::_getLoadSelect($field, $value, $object);

        $select->where(
            'is_active = ?',
            1
        );

        return $select;
    }*/

}