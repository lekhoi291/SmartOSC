<?php

namespace SmartOSC\Blog\Block\Post;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\View\Element\Template;
use Magento\Tests\NamingConvention\true\false;
use SmartOSC\Blog\Api\PostRepositoryInterface;
use SmartOSC\Blog\Helper\Data as BlogHelperData;
use SmartOSC\Blog\Model\Post;
use SmartOSC\Blog\Model\ResourceModel\Post\CollectionFactory as PostCollectionFactory;
use SmartOSC\Blog\Api\CategoryRepositoryInterface;

class PostList extends Template implements IdentityInterface
{
    /**
     * @var PostRepositoryInterface
     */
    protected $postRepository;

    /**
     * @var SortOrderBuilder
     */
    protected $sortOrderBuilder;

    /**
     * @var CategoryRepositoryInterface
     */
    protected $categoryRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @var BlogHelperData
     */
    protected $blogHelperData;

    /**
     * @var PostCollectionFactory
     */
    protected $collection;

    /**
     * PostList constructor.
     * @param PostRepositoryInterface $postRepository
     * @param SortOrderBuilder $sortOrderBuilder
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param BlogHelperData $blogHelperData
     * @param Template\Context $context
     * @param PostCollectionFactory $collection
     * @param array $data
     */
    public function __construct(
        PostRepositoryInterface $postRepository,
        SortOrderBuilder $sortOrderBuilder,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        BlogHelperData $blogHelperData,
        Template\Context $context,
        PostCollectionFactory $collection,
        array $data = [])
    {
        $this->postRepository = $postRepository;
        $this->sortOrderBuilder = $sortOrderBuilder;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->blogHelperData = $blogHelperData;
        $this->collection = $collection;
        parent::__construct($context, $data);
    }

    public function getIdentities()
    {
        return [Post::CACHE_TAG.'_'.'list'];
    }

    public function getPosts()
    {
        if (!$this->hasData('posts')) {
            $sortOrder = $this->sortOrderBuilder
                ->setField('created_at')
                ->setDirection(SortOrder::SORT_DESC)
                ->create();

            $searchCriteriaBuilder = $this->searchCriteriaBuilder
                ->addSortOrder($sortOrder)
                ->setPageSize(10)
                ->setCurrentPage(1)
                ->create();

            $posts = $this->postRepository
                ->getList($searchCriteriaBuilder)
                ->getItems();

            $this->setData('posts', $posts);
        }

        return $this->getData('posts');
    }

    public function getMediaUrl()
    {
        $mediaUrl = $this->_storeManager->getStore()
                ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA).'blog/image/';
        return $mediaUrl;
    }

    public function getHelperData()
    {
        return $this->blogHelperData;
    }

    /**
     * @return \SmartOSC\Blog\Model\ResourceModel\Post\Collection
     */
    public function getAllPostList()
    {
        $collection = $this->collection->create();

        return $collection;
    }

    /**
     * @param $categoryIds
     * @return bool
     */
    public function isAsigned($categoryIds){
        $paramCatId = $this->getRequest()->getParam('category');

        #case
        if($paramCatId != ''){
            $postCategoriesAsigned = explode(',',$categoryIds);
            foreach ($postCategoriesAsigned as $postCategoriesAsigned){
                if ($postCategoriesAsigned == $paramCatId){
                    return true;
                }
            }
        }

//        #case blog/index/index/
//        if(check module blog,index){
//            //check
//            return true;
//        }

        return false;
    }

    /**
     * get post url
     * @return \SmartOSC\Blog\Model\ResourceModel\Post\Collection
     */
    public function getPostUrl($postId){
        return $this->getUrl('blog/post/view', ['post' => $postId]);
    }
}