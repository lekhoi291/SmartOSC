<?php

namespace SmartOSC\Blog\Block\Adminhtml\Category;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Registry;

class Edit extends \Magento\Backend\Block\Widget\Grid\Container
{
    protected $coreRegistry;

    public function __construct(
        Context $context,
        Registry $registry,
        array $data = []
    )
    {
        $this->coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * Initialize blog category edit block
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_objectId = 'category_id';
        $this->_blockGroup = 'SmartOSC_Blog';
        $this->_controller = 'adminhtml_category';

        parent::_construct();

        if ($this->_isAllowedAction('SmartOSC_Blog::save')) {
            $this->buttonList->update('save', 'label', __('Save Blog Category'));
            $this->buttonList->add(
                'saveandcontinue',
                [
                    'label' => __('Save and Continue Edit'),
                    'class' => 'save',
                    'data_attribute' => [
                        'mage-init' => [
                            'button' => ['event' => 'saveAndContinueEdit', 'target' => '#edit_form'],
                        ],
                    ]
                ],
                -100
            );
        } else {
            $this->buttonList->remove('save');
        }

        if ($this->_isAllowedAction('SmartOSC_Blog::category_delete')) {
            $this->buttonList->update('delete', 'label', __('Delete Category'));
        } else {
            $this->buttonList->remove('delete');
        }
    }

    /**
     * Retrieve text for header element depending on loaded category
     *
     * @return \Magento\Framework\Phrase
     */
    public function getHeaderText()
    {
        if ($this->coreRegistry->registry('blog_category')->getCategoryId()) {
            return __("Edit Category '%1'", $this->escapeHtml($this->coreRegistry->registry('blog_category')->getTitle()));
        } else {
            return __('New Category');
        }
    }

    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }

    /**
     * Getter of url for "Save and Continue" button
     * tab_id will be replaced by desired by JS later
     *
     * @return string
     */
    protected function _getSaveAndContinueUrl()
    {
        return $this->getUrl('blog/*/save', ['_current' => true, 'back' => 'edit', 'active_tab' => '']);
    }

}