<?php

namespace SmartOSC\Blog\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessor;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\NotFoundException;
use SmartOSC\Blog\Api\Data\PostInterface;
use SmartOSC\Blog\Api\Data\PostSearchInterfaceFactory;
use SmartOSC\Blog\Api\PostRepositoryInterface;
use SmartOSC\Blog\Model\ResourceModel\Post as PostResource;
use SmartOSC\Blog\Model\ResourceModel\Post\CollectionFactory as PostCollectionFactory;

class PostRepository implements PostRepositoryInterface
{
    /**
     * @var \SmartOSC\Blog\Model\ResourceModel\Post
     */
    protected $postResource;

    /**
     * @var PostFactory
     */
    protected $postFactory;

    /**
     * @var PostCollectionFactory
     */
    protected $collection;

    /**
     * @var PostSearchInterfaceFactory
     */
    protected $postSearchFactory;

    /**
     * @var CollectionProcessor
     */
    private $collectionProcessor;

    public function __construct(
        PostResource $postResource,
        PostFactory $postFactory,
        PostCollectionFactory $collection,
        PostSearchInterfaceFactory $postSearchFactory,
        CollectionProcessor $collectionProcessor
    )
    {
        $this->postResource = $postResource;
        $this->postFactory = $postFactory;
        $this->collection = $collection;
        $this->postSearchFactory = $postSearchFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @param PostInterface $post
     * @param bool $saveOptions
     * @return PostInterface
     * @throws CouldNotSaveException
     */
    public function save(PostInterface $post, $saveOptions = false)
    {
        try {
            $this->postResource->save($post);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save post: %1', $exception->getMessage()),
                $exception
            );
        }
        return $post;
    }

    /**
     * @param int $post_id
     * @return PostInterface|Post
     * @throws NoSuchEntityException
     */
    public function getById($post_id)
    {
        $post = $this->postFactory->create();
        $this->postResource->load($post, $post_id);

        if(!$post->getId()) {
            throw new NoSuchEntityException(__('Unable to find Post with ID "%1"', $post_id));
        }

        return $post;
    }

    /**
     * @param string $url_key
     * @return PostInterface|Post
     * @throws NotFoundException
     */
    public function getByUrlKey($url_key)
    {
        $post = $this->postFactory->create();
        $this->postResource->load($post, $url_key, 'url_key');

        if(!$post->getId()) {
            throw new NotFoundException(__('Unable to find Post with url_key "%1"', $url_key));
        }

        return $post;
    }

    /**
     * @param PostInterface $post
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(PostInterface $post)
    {
        try {
            $this->postResource->delete($post);

        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the post: %1',
                $exception->getMessage()
            ));
        }

        return true;

    }

    /**
     * @param int $post_id
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($post_id)
    {
        return $this->delete($this->getById($post_id));
    }

    /**
     * @inheritdoc
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->collection->create();
        $collection->addIsActiveFilter();
        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResult = $this->postSearchFactory->create();

        $searchResult->setSearchCriteria($searchCriteria);
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());

        return $searchResult;

    }


}