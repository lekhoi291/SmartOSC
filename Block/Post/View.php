<?php

namespace SmartOSC\Blog\Block\Post;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\View\Element\Template;
use SmartOSC\Blog\Api\Data\PostInterface;
use SmartOSC\Blog\Api\PostRepositoryInterface;
use \Magento\Framework\Registry;

/**
 * @method View setPost(PostInterface $post)
 *
 * @package SmartOSC\Blog\Block\Post
 */
class View extends Template implements IdentityInterface
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @var PostRepositoryInterface
     */
    protected $postRepository;

    /**
     * @var PostInterface
     */
    protected $post;

    public function __construct(
        Template\Context $context,
        PostRepositoryInterface $postRepository,
        array $data = []
    )
    {
        $this->postRepository = $postRepository;
        parent::__construct($context, $data);
    }

    protected function _construct()
    {
        parent::_construct();

        $post_id = $this->getRequest()->getParam('post');
        if($post_id) {
            $this->setPost($this->postRepository->getById($post_id));

        }
    }

    /**
     * @return array|string[]
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getIdentities()
    {
        return [\SmartOSC\Blog\Model\Post::CACHE_TAG . '_' . $this->getPost()->getPostId()];
    }

    public function getMediaUrl()
    {
        $mediaUrl = $this->_storeManager->getStore()
                ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA).'blog/image/';

        return $mediaUrl;
    }

    /**
     * @return PostInterface|null
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getPost()
    {
        $postId = $this->getRequest()->getParam('post');

        $post = null;
        if ($postId != '') {
            $post = $this->postRepository->getById($postId);
        }

        return $post;
    }

}