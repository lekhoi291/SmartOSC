<?php

namespace SmartOSC\Blog\Block\Post;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\View\Element\Template;
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
     * @return \SmartOSC\Blog\Model\ResourceModel\Post\Collection
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
        }else{
            return true;
        }
    }

    public function getNews()
    {
        //get values of current page
        $page=($this->getRequest()->getParam('p'))? $this->getRequest()->getParam('p') : 1;
        //get values of current limit
        $pageSize=($this->getRequest()->getParam('limit'))? $this->getRequest()->getParam('limit') : 5;

        $collection = $this->collection->create();
        $collection->setPageSize($pageSize);
        $collection->setCurPage($page);
        return $collection;
    }



    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $this->pageConfig->getTitle()->set(__('Blog'));

        if ($this->getNews()) {
            $pager = $this->getLayout()->createBlock(
                'Magento\Theme\Block\Html\Pager'
            )->setAvailableLimit(array(5=>5,10=>10,15=>15))->setShowPerPage(true)->setCollection(
                $this->getNews()
            );
            $this->setChild('pager', $pager);
            $this->getNews()->load();
        }
        return $this;
    }

    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }

    /**
     * @param $categoryIds
     * @return bool
     */


    /**
     * get post url
     * @return \SmartOSC\Blog\Model\ResourceModel\Post\Collection
     */
    public function getPostUrl($postId){
        return $this->getUrl('blog/post/view', ['post' => $postId]);
    }
}