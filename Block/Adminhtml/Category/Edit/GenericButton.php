<?php

namespace SmartOSC\Blog\Block\Adminhtml\Category\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use SmartOSC\Blog\Api\CategoryRepositoryInterface;

class GenericButton
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var CategoryRepositoryInterface
     */
    protected $categoryRepository;

    /**
     * GenericButton constructor.
     * @param Context $context
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(
        Context $context,
        CategoryRepositoryInterface $categoryRepository
    ) {
        $this->context = $context;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @return null
     */
    public function getCategoryId()
    {
        try {
            return $this->categoryRepository->get(
                $this->context->getRequest()->getParam('category_id')
            )->getId();
        } catch (NoSuchEntityException $e) {
        }
        return null;
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }

}