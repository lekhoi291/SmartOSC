<?php

namespace SmartOSC\Blog\Controller\Adminhtml\Post;

use Magento\Backend\App\Action;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\StateException;
use Psr\Log\LoggerInterface;
use SmartOSC\Blog\Api\PostRepositoryInterface;
use SmartOSC\Blog\Model\ImageUploader;
use SmartOSC\Blog\Model\Post;
use SmartOSC\Blog\Model\PostFactory;

class Save extends Action
{
    /**
     * @var PostRepositoryInterface
     */
    protected $postRepository;

    /**
     * @var PostFactory
     */
    protected $postFactory;

    /**
     * @var \Magento\Catalog\Model\ImageUploader
     */
    protected $imageUploader;

    /**
     * @var LoggerInterface
     */
    protected $_logger;

    public function __construct(
        Action\Context $context,
        PostRepositoryInterface $postRepository,
        PostFactory $postFactory,
        ImageUploader $imageUploader,
        LoggerInterface $logger
    )
    {
        $this->postRepository = $postRepository;
        $this->postFactory = $postFactory;
        $this->imageUploader = $imageUploader;
        $this->_logger = $logger;
        parent::__construct($context);
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultRedirectFactory->create();

        if($data) {
            if (isset($data['is_active']) && $data['is_active'] === 'true') {
                $data['is_active'] = Post::STATUS_ENABLED;
            }

            if (isset($data['category_ids']) && !empty($data['category_ids']) ) {
                $data['category_ids'] = implode(',', $data['category_ids']);
            }

            $model = $this->postFactory->create();

            $id = $this->getRequest()->getParam('post_id');

            if($id) {
                $model = $this->postRepository->getById($id);
            }

            $data = $this->_processImage($data);
            $model->setData($data);

            try {
                $this->postRepository->save($model);
                $this->messageManager->addSuccessMessage('Blog post has been saved');
            } catch (CouldNotSaveException $couldNotSaveException) {
                $this->messageManager->addExceptionMessage($couldNotSaveException);
            } catch (InputException $inputException) {
                $this->messageManager->addExceptionMessage($inputException);
            } catch (StateException $stateException) {
                $this->messageManager->addExceptionMessage($stateException);
            }

            return $resultRedirect->setPath('*/*/edit', ['post_id' => $this->getRequest()->getParam('post_id')]);
        }

        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Gets image name from $value array.
     * Will return empty string in a case when $value is not an array
     *
     * @param array $value
     * @return string
     */
    private function getUploadedImageName($value)
    {
        if (is_array($value['image']) && isset($value['image'][0]['name'])) {
            return $value['image'][0]['name'];
        }

        return '';
    }

    /**
     * Check if temporary file is available for new image upload.
     *
     * @param array $value
     * @return bool
     */
    private function isTmpFileAvailable($value)
    {
        return isset($value['image']) && isset($value['image'][0]['tmp_name']);
    }

    public function _processImage(array $data)
    {
        if ($this->isTmpFileAvailable($data) && $imageName = $this->getUploadedImageName($data)) {
            $data['image'] = $imageName;
            try {
                 $this->imageUploader->moveFileFromTmp($imageName);
            } catch (\Exception $e) {
                $this->_logger->critical($e);
            }
        } else {
            $data['image'] = null;
        }

        return $data;
    }


}