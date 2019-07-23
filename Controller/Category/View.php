<?php

namespace SmartOSC\Blog\Controller\Category;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\ForwardFactory;
use Magento\Framework\View\Result\PageFactory;
use SmartOSC\Blog\Api\CategoryRepositoryInterface;

class View extends Action
{
    /**
     * @var PageFactory
     */
    protected $pageFactory;

    /**
     * @var CategoryRepositoryInterface
     */
    protected $categoryRepository;

    /**
     * @var ForwardFactory
     */
    protected $forwardFactory;

    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        CategoryRepositoryInterface $categoryRepository,
        ForwardFactory $forwardFactory
    )
    {
        $this->pageFactory = $pageFactory;
        $this->categoryRepository = $categoryRepository;
        $this->forwardFactory = $forwardFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultPage = $this->pageFactory->create();
        return $resultPage;

        $category_id = $this->getRequest()->getParam('category_id', $this->getRequest()->getParam('id', false));

        if ($category_id !== null) {
            $delimiterPosition = strrpos($category_id, '|');
            if ($delimiterPosition) {
                $category_id = substr($category_id, 0, $delimiterPosition);
            }
        }

        $category = $this->categoryRepository->get($category_id);

        if (!$category) {
           // return false;
        }



        //$resultPage->addHandle('blog_category_view');
        //$resultPage->addPageLayoutHandles(['id' => $category->getCategoryId()]);

        $this->_eventManager->dispatch(
            'blog_category_render',
            ['post' => $category, 'controller_action' => $this]
        );


        if(!$resultPage) {
            $resultForward = $this->forwardFactory->create();
            return $resultForward->forward('noroute');
        }

        return $resultPage;
    }

}