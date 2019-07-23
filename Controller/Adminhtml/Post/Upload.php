<?php


namespace SmartOSC\Blog\Controller\Adminhtml\Post;


use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;
use SmartOSC\Blog\Model\ImageUploader;

class Upload extends Action
{

    protected $imageUploader;

    public function __construct(
        Action\Context $context,
        ImageUploader $imageUploader
    )
    {
        parent::__construct($context);
        $this->imageUploader = $imageUploader;

    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('SmartOSC_Blog::post');
    }

    public function execute()
    {
        try {
            $imageId = $this->_request->getParam('param_name', 'image');

            $result = $this->imageUploader->saveFileToTmpDir($imageId);

        } catch (\Exception $exception) {
            $result = ['error' => $exception->getMessage(), 'errorcode' => $exception->getCode()];
        }

        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);


    }

}