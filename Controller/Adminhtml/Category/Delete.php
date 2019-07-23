<?php

namespace SmartOSC\Blog\Controller\Adminhtml\Category;

use Magento\Backend\App\Action;
use SmartOSC\Blog\Api\CategoryRepositoryInterface;

class Delete extends Action
{
    protected $categoryRepository;

    public function __construct(
        Action\Context $context,
        CategoryRepositoryInterface $categoryRepository
    )
    {
        $this->categoryRepository = $categoryRepository;
        parent::__construct($context);
    }

    public function execute()
    {
        // check if we know what should be deleted
        $category_id = $this->getRequest()->getParam('category_id');

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        if($category_id) {
            try {
                $this->categoryRepository->deleteById($category_id);

                // display success message
                $this->messageManager->addSuccessMessage(__('The category has been deleted.'));

                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['category_id' => $category_id]);
            }
        }

        $this->messageManager->addErrorMessage('We can\'t find the category to delete');

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