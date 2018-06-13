<?php

namespace Kvr\Blog\Block;

use \Magento\Framework\Exception\LocalizedException;
use \Magento\Framework\View\Element\Template;
use \Magento\Framework\View\Element\Template\Context;
use \Magento\Framework\Registry;
use \Kvr\Blog\Api\PostRepositoryInterface;
use \Kvr\Blog\Controller\Post\View as ViewAction;

class View extends Template
{
    /**
     * Core registry
     * @var Registry
     */
    protected $coreRegistry;

    /**
     * PostRepositoryInterface
     * @var PostRepositoryInterface
     */
    protected $postRepositoryInterface;

    /**
     * Constructor
     * @param Context $context
     * @param Registry $coreRegistry
     * @param PostRepositoryInterface $postRepositoryInterface
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        PostRepositoryInterface $postRepositoryInterface,
        array $data = []
    ) {
        $this->coreRegistry = $coreRegistry;
        $this->postRepositoryInterface = $postRepositoryInterface;
        parent::__construct($context, $data);
    }

    /**
     * @return PostRepositoryInterface[]
     * @throws LocalizedException
     */
    public function getPos()
    {
        /** @var PostRepositoryInterfaceFactory $postRepositoryInterfaceFactory */
            if ($this->getPostId())
                return $this->postRepositoryInterface->getById($this->getPostId());
            else
                throw new LocalizedException(__('Post not found'));
    }
    /**
     * Retrieves the post id from the registry
     * @return int
     */
    protected function getPostId()
    {
        //Registry used to fetch global variable
        //ViewAction|Controller where REGISTRY_KEY_POST_ID|Const is saved
        return (int) $this->coreRegistry->registry(
            ViewAction::REGISTRY_KEY_POST_ID
        );
    }
}