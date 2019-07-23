<?php

namespace SmartOSC\Blog\Controller\Adminhtml\Category;

use Magento\Backend\App\Action;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\StateException;
use SmartOSC\Blog\Api\CategoryRepositoryInterface;
use SmartOSC\Blog\Model\Category;
use SmartOSC\Blog\Model\CategoryFactory;

class Save extends Action
{
    /**
     * @var CategoryRepositoryInterface
     */
    protected $categoryRepository;

    /**
     * @var CategoryFactory
     */
    protected $categoryFactory;

    public function __construct(
        Action\Context $context,
        CategoryRepositoryInterface $categoryRepository,
        CategoryFactory $categoryFactory
    )
    {
        $this->categoryRepository = $categoryRepository;
        $this->categoryFactory = $categoryFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();

        $resultRedirect = $this->resultRedirectFactory->create();

        if($data) {
            if (isset($data['is_active']) && $data['is_active'] === 'true') {
                $data['is_active'] = Category::STATUS_ENABLED;
            }

            $model = $this->categoryFactory->create();

            $id = $this->getRequest()->getParam('category_id');

            if($id) {
                $model = $this->categoryRepository->get($id);
            }

            $model->setData($data);

            try {
                $this->categoryRepository->save($model);
                $this->messageManager->addSuccessMessage('Blog category has been saved');
            } catch (CouldNotSaveException $couldNotSaveException) {
                $this->messageManager->addExceptionMessage($couldNotSaveException);
            } catch (InputException $inputException) {
                $this->messageManager->addExceptionMessage($inputException);
            } catch (StateException $stateException) {
                $this->messageManager->addExceptionMessage($stateException);
            }

            return $resultRedirect->setPath('*/*/edit', ['category_id' => $this->getRequest()->getParam('category_id')]);
        }

        return $resultRedirect->setPath('*/*/');
    }


}