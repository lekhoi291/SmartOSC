<?php

namespace SmartOSC\Blog\Model;

use Magento\Framework\File\UploaderFactory;
use Magento\Framework\Filesystem;
use Magento\MediaStorage\Helper\File\Storage\Database;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;

class ImageUploader
{
    /**
     * @var Database
     */
    protected $coreFileStorageDatabase;

    /**
     * @var Filesystem\Directory\WriteInterface
     */
    protected $mediaDirectory;

    /**
     * @var UploaderFactory
     */
    protected $uploaderFactory;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var string
     */
    protected $baseTmpPath = 'blog/tmp/image';

    /**
     * @var string
     */
    protected $basePath = 'blog/image';

    /**
     * @var string[]
     */
    protected $allowedExtensions;

    /**
     * List of allowed image mime types
     *
     * @var array
     */
    private $allowedMimeTypes = [
        'image/jpg',
        'image/jpeg',
        'image/gif',
        'image/png'
    ];

    /**
     * ImageUploader constructor.
     * @param Database $coreFileStorageDatabase
     * @param Filesystem $filesystem
     * @param UploaderFactory $uploaderFactory
     * @param StoreManagerInterface $storeManager
     * @param LoggerInterface $logger
     * @param string $baseTmpPath
     * @param string $basePath
     * @param string[] $allowedExtensions
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function __construct(
        Database $coreFileStorageDatabase,
        Filesystem $filesystem,
        UploaderFactory $uploaderFactory,
        StoreManagerInterface $storeManager,
        LoggerInterface $logger,
        $baseTmpPath,
        $basePath,
        $allowedExtensions
    )
    {
        $this->coreFileStorageDatabase = $coreFileStorageDatabase;
        $this->mediaDirectory = $filesystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
        $this->uploaderFactory = $uploaderFactory;
        $this->storeManager = $storeManager;
        $this->logger = $logger;
        $this->baseTmpPath = $baseTmpPath;
        $this->basePath = $basePath;
        $this->allowedExtensions = $allowedExtensions;
    }

    /**
     * Set base tmp path
     *
     * @param string $baseTmpPath
     *
     * @return void
     */
    public function setBaseTmpPath($baseTmpPath)
    {
        $this->baseTmpPath = $baseTmpPath;
    }

    /**
     * Set base path
     *
     * @param string $basePath
     *
     * @return void
     */
    public function setBasePath($basePath)
    {
        $this->basePath = $basePath;
    }

    /**
     * Set allowed extensions
     *
     * @param string[] $allowedExtensions
     *
     * @return void
     */
    public function setAllowedExtensions($allowedExtensions)
    {
        $this->allowedExtensions = $allowedExtensions;
    }

    /**
     * Retrieve base tmp path
     *
     * @return string
     */
    public function getBaseTmpPath()
    {
        return $this->baseTmpPath;
    }

    /**
     * Retrieve base path
     *
     * @return string
     */
    public function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * Retrieve base path
     *
     * @return string[]
     */
    public function getAllowedExtensions()
    {
        return $this->allowedExtensions;
    }

    /**
     * Retrieve path
     *
     * @param string $path
     * @param string $imageName
     *
     * @return string
     */
    public function getFilePath($path, $imageName)
    {
        return rtrim($path, '/') . '/' . ltrim($imageName, '/');
    }

    /**
     * Checking file for moving and move it
     *
     * @param string $imageName
     *
     * @return string
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function moveFileFromTmp($imageName)
    {
        $baseTmpPath = $this->getBaseTmpPath();
        $basePath = $this->getBasePath();

        $baseImagePath = $this->getFilePath($basePath, $imageName);
        $baseTmpImagePath = $this->getFilePath($baseTmpPath, $imageName);

        $this->coreFileStorageDatabase->copyFile(
            $baseTmpImagePath,
            $baseImagePath
        );
        $this->mediaDirectory->renameFile(
            $baseTmpImagePath,
            $baseImagePath
        );

        return $imageName;
    }

    /**
     * Checking file for save and save it to tmp dir
     *
     * @param string $fileId
     *
     * @return string[]
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Exception
     */
    public function saveFileToTmpDir($fileId)
    {
        $baseTmpPath = $this->getBaseTmpPath();

        /** @var \Magento\MediaStorage\Model\File\Uploader $uploader */
        $uploader = $this->uploaderFactory->create(['fileId' => $fileId]);
        $uploader->setAllowedExtensions($this->getAllowedExtensions());
        $uploader->setAllowRenameFiles(true);
        if (!$uploader->checkMimeType($this->allowedMimeTypes)) {
            throw new \Magento\Framework\Exception\LocalizedException(__('File validation failed.'));
        }
        $result = $uploader->save($this->mediaDirectory->getAbsolutePath($baseTmpPath));
        unset($result['path']);

        if (!$result) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('File can not be saved to the destination folder.')
            );
        }

        /**
         * Workaround for prototype 1.7 methods "isJSON", "evalJSON" on Windows OS
         */
        $result['tmp_name'] = str_replace('\\', '/', $result['tmp_name']);
        $result['url'] = $this->storeManager
                ->getStore()
                ->getBaseUrl(
                    \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                ) . $this->getFilePath($baseTmpPath, $result['file']);
        $result['name'] = $result['file'];

        if (isset($result['file'])) {
            try {
                $relativePath = rtrim($baseTmpPath, '/') . '/' . ltrim($result['file'], '/');
                $this->coreFileStorageDatabase->saveFile($relativePath);
            } catch (\Exception $e) {
                $this->logger->critical($e);
                throw new \Magento\Framework\Exception\LocalizedException(
                    __('Something went wrong while saving the file(s).')
                );
            }
        }

        return $result;
    }

}