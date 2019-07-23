<?php

namespace SmartOSC\Blog\Controller\Post;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\ForwardFactory;
use Magento\Framework\View\Result\PageFactory;
use SmartOSC\Blog\Api\PostRepositoryInterface;

class View extends Action
{
    /**
     * @var PageFactory
     */
    protected $pageFactory;

    /**
     * @var PostRepositoryInterface
     */
    protected $postRepository;

    /**
     * @var ForwardFactory
     */
    protected $forwardFactory;

    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        PostRepositoryInterface $postRepository,
        ForwardFactory $forwardFactory
    )
    {
        $this->pageFactory = $pageFactory;
        $this->postRepository = $postRepository;
        $this->forwardFactory = $forwardFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $post_id = $this->getRequest()->getParam('post');

        if ($post_id !== null) {
            $delimiterPosition = strrpos($post_id, '|');
            if ($delimiterPosition) {
                $post_id = substr($post_id, 0, $delimiterPosition);
            }
        }

        $post = $this->postRepository->getById($post_id);

        if (!$post) {
            return false;
        }

        $resultPage = $this->pageFactory->create();

        $resultPage->addHandle('blog_post_view');
        $resultPage->addPageLayoutHandles(['id' => $post->getPostId()]);

        $this->_eventManager->dispatch(
            'blog_post_render',
            ['post' => $post, 'controller_action' => $this]
        );
        

        if(!$resultPage) {
            $resultForward = $this->forwardFactory->create();
            return $resultForward->forward('noroute');
        }

        return $resultPage;
    }

}