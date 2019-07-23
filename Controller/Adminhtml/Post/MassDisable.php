<?php


namespace SmartOSC\Blog\Controller\Adminhtml\Post;


use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;
use SmartOSC\Blog\Api\PostRepositoryInterface;
use SmartOSC\Blog\Model\ResourceModel\Post\CollectionFactory;

class MassDisable extends Action
{

    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var PostRepositoryInterface
     */
    protected $postRepository;

    public function __construct(
        Action\Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        PostRepositoryInterface $postRepository
    )
    {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->postRepository = $postRepository;
        parent::__construct($context);
    }

    /**
     * Execute action based on request and return result
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {

        $collection = $this->filter->getCollection($this->collectionFactory->create());

        foreach ($collection as $item) {
            $item->setIsActive(false);
            $this->postRepository->save($item);
        }

        $this->messageManager->addSuccessMessage('A total of %1 record(s) have been deleted', $collection->getSize());

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $resultRedirect->setPath('*/*/');
    }

}