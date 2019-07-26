<?php

namespace SmartOSC\Blog\Block\Post;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\View\Element\Template;
use SmartOSC\Blog\Api\Data\PostInterface;
use SmartOSC\Blog\Api\PostRepositoryInterface;
use \Magento\Framework\Registry;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Helper\Image;

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

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var Image
     */
    protected $imageHelper;

    /**
     * View constructor.
     * @param Template\Context $context
     * @param PostRepositoryInterface $postRepository
     * @param ProductRepositoryInterface $productRepository
     * @param Image $imageHelper
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        PostRepositoryInterface $postRepository,
        ProductRepositoryInterface $productRepository,
        Image $imageHelper,
        array $data = []
    )
    {
        $this->postRepository = $postRepository;
        $this->productRepository = $productRepository;
        $this->imageHelper = $imageHelper;
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
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function  getProductIds()
    {
        $currentPost = $this->getPost();

        $productRlatedIds = $currentPost->getProductIds();

        return explode(',', $productRlatedIds);
    }


    /**
     * @param $productId
     * @return \Magento\Catalog\Api\Data\ProductInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function  getProductById($productId)
    {
        return $this->productRepository->getById($productId);
    }

    /**
     * @param $productId
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getItemImage($productId)
    {
        try {
            $_product = $this->productRepository->getById($productId);
        } catch (NoSuchEntityException $e) {
            return 'product not found';
        }
        $image_url = $this->imageHelper->init($_product, 'product_base_image')->getUrl();
        return $image_url;
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