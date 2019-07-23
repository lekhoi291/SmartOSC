<?php

namespace SmartOSC\Blog\Controller\Adminhtml\Category;

use Magento\Backend\App\Action;
use SmartOSC\Blog\Api\CategoryRepositoryInterface;
use SmartOSC\Blog\Model\Category;
use SmartOSC\Blog\Model\CategoryFactory;

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
     * @var CategoryFactory
     */
    protected $categoryFactory;

    protected $categoryRepository;

    /**
     * Edit constructor.
     * @param Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Registry $registry
     * @param CategoryFactory $categoryFactory
     */
    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry,
        CategoryFactory $categoryFactory,
        CategoryRepositoryInterface $categoryRepository
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        $this->categoryFactory = $categoryFactory;
        $this->categoryRepository = $categoryRepository;
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
            ->setActiveMenu('SmartOSC_Blog::category')
            ->addBreadcrumb('Blog', 'Blog')
            ->addBreadcrumb('Manage Blog Categories', 'Manage Blog Categories');

        return $resultPage;
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute()
    {
        $category_id = $this->getRequest()->getParam('category_id');
        $model = $this->categoryRepository->get($category_id);

        if($category_id) {
            if (!$model->getCategoryId()) {
                $this->messageManager->addErrorMessage('This category no longer exists.');
                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath('*/*/');
            }
        }

        $data = $this->_session->getFormData(true);
        if(!empty($data)) {
            $model->setData($data);
        }

        $this->_coreRegistry->register('blog_category', $model);

        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $category_id ? 'Edit Category' : 'New Category',
            $category_id ? 'Edit Category' : 'New Category'
        );

        $resultPage->getConfig()->getTitle()->prepend(__('Categories'));
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getCategoryId() ? $model->getTitle() : __('New Category'));

        return $resultPage;
    }

}