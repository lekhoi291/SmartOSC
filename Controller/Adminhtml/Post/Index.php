<?php

namespace SmartOSC\Blog\Controller\Adminhtml\Post;

use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    public function __construct(
        Action\Context $context,
        PageFactory $pageFactory
    )
    {
        $this->resultPageFactory = $pageFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Page|
     * \Magento\Framework\App\ResponseInterface|
     * \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();

        $resultPage->setActiveMenu('SmartOSC_Blog::post');
        $resultPage->addBreadcrumb('Blog Posts', 'Blog Posts');
        $resultPage->addBreadcrumb('Manage Blog Posts', 'Manage Blog Posts');
        $resultPage->getConfig()->getTitle()->prepend('Blog Posts');

        return $resultPage;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('SmartOSC_Blog::post');

    }

}