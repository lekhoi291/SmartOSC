<?php


namespace SmartOSC\Blog\Model\Category\Source;


use Magento\Framework\Data\OptionSourceInterface;
use SmartOSC\Blog\Model\Category;

class IsActive implements OptionSourceInterface
{

    /**
     * @var Category
     */
    protected $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function toOptionArray()
    {
        $options = [
            'label' => '',
            'value' => ''
        ];

        $availableOptions = $this->category->getAvailableStatuses();

        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key
            ];
        }

        return $options;
    }


}