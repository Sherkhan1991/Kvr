<?php

namespace Kvr\Blog\Controller\Post;

use \Magento\Framework\App\Action\Action;
use \Magento\Framework\View\Result\PageFactory;
use \Magento\Framework\View\Result\Page;
use \Magento\Framework\App\Action\Context;
use \Magento\Framework\Exception\LocalizedException;
use \Magento\Framework\Registry;

class View extends Action
{
    const REGISTRY_KEY_POST_ID = 'kvr_blog_post_id';

    /**
     * Core registry
     * @var Registry
     */
    protected $coreRegistry;

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param PageFactory $resultPageFactory
     *
     * @codeCoverageIgnore
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        PageFactory $resultPageFactory
    ) {
        parent::__construct(
            $context
        );
        $this->coreRegistry = $coreRegistry;
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Saves the blog id to the register and renders the page
     * @return Page
     * @throws LocalizedException
     */
    public function execute()
    {   //Used to register the global variable
        $this->coreRegistry->register(self::REGISTRY_KEY_POST_ID, (int) $this->getRequest()->getParam('id'));
        $resultPage = $this->resultPageFactory->create();
        return $resultPage;
    }
}
