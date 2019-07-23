<?php


namespace SmartOSC\Blog\Model\Post\Source;


use Magento\Framework\Data\OptionSourceInterface;
use SmartOSC\Blog\Model\Post;

class IsActive implements OptionSourceInterface
{

    /**
     * @var Post
     */
    protected $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function toOptionArray()
    {
        $options = [
            'label' => '',
            'value' => ''
        ];

        $availableOptions = $this->post->getAvailableStatuses();

        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key
            ];
        }

        return $options;
    }


}