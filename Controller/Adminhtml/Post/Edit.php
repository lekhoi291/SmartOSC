<?php


namespace SmartOSC\Blog\Controller\Adminhtml\Post;


use Magento\Backend\App\Action;
use SmartOSC\Blog\Api\PostRepositoryInterface;
use SmartOSC\Blog\Model\Post;
use SmartOSC\Blog\Model\PostFactory;

class Edit extends Action
{

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var PostRepositoryInterface
     */
    protected $postRepository;

    /**
     * @var PostFactory
     */
    protected $postFactory;

    /**
     * Edit constructor.
     * @param Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Registry $registry
     * @param PostRepositoryInterface $postRepository
     * @param PostFactory $postFactory
     */
    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry,
        PostRepositoryInterface $postRepository,
        PostFactory $postFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        $this->postRepository = $postRepository;
        $this->postFactory = $postFactory;
        parent::__construct($context);
    }

    /**
     * Init actions
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function _initAction()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage
            ->setActiveMenu('SmartOSC_Blog::post')
            ->addBreadcrumb('Blog', 'Blog')
            ->addBreadcrumb('Manage Blog Posts', 'Manage Blog Posts');

        return $resultPage;
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $post_id = $this->getRequest()->getParam('post_id');
        $model = $this->_objectManager->create(Post::class);

        if($post_id) {
            $model->load($post_id);
            if (!$model->getPostId()) {
                $this->messageManager->addErrorMessage('This post no longer exists.');
                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath('*/*/');
            }
        }

        $data = $this->_session->getFormData(true);
        if(!empty($data)) {
            $model->setData($data);
        }

        $this->_coreRegistry->register('blog_post', $model);

        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $post_id ? 'Edit Post' : 'New Post',
            $post_id ? 'Edit Post' : 'New Post'
        );

        $resultPage->getConfig()->getTitle()->prepend(__('Pages'));
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getPostId() ? $model->getTitle() : __('New Post'));

        return $resultPage;
    }

}