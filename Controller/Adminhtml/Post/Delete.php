<?php


namespace SmartOSC\Blog\Controller\Adminhtml\Post;


use Magento\Backend\App\Action;
use SmartOSC\Blog\Api\Data\PostInterface;
use SmartOSC\Blog\Api\PostRepositoryInterface;
use SmartOSC\Blog\Model\Post;

class Delete extends Action
{

    protected $postRepository;

    public function __construct(
        Action\Context $context,
        PostRepositoryInterface $postRepository
    )
    {
        $this->postRepository = $postRepository;
        parent::__construct($context);
    }

    public function execute()
    {
        // check if we know what should be deleted
        $post_id = $this->getRequest()->getParam('post_id');

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        if($post_id) {
            try {
                $this->postRepository->deleteById($post_id);

                // display success message
                $this->messageManager->addSuccessMessage(__('The post has been deleted.'));

                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['post_id' => $post_id]);
            }
        }

        $this->messageManager->addErrorMessage('We can\'t find the post to delete');

        return $resultRedirect->setPath('*/*/');

    }

    /**
     * @inheritdoc
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('SmartOSC_Blog::delete');
    }

}