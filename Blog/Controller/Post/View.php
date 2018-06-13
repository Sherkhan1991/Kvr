<?php

namespace Kvr\Blog\Controller\Post;

use Magento\Framework\App\Action\Action;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\View\Result\Page;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Magento\Framework\Controller\Result\JsonFactory;
use \Kvr\Blog\Api\PostRepositoryInterface;

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
     * @var JsonFactory
     */
    private $resultJsonFactory;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * PostRepositoryInterface
     * @var PostRepositoryInterface
     */
    protected $postRepository;

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param PageFactory $resultPageFactory
     * @param JsonFactory $resultJsonFactory
     * @param \Psr\Log\LoggerInterface $logger
     * @param PostRepositoryInterface $postRepository
     *
     * @codeCoverageIgnore
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        PageFactory $resultPageFactory,
        JsonFactory $resultJsonFactory,
        \Psr\Log\LoggerInterface $logger,
        PostRepositoryInterface $postRepository
    ) {
        $this->coreRegistry = $coreRegistry;
        $this->resultPageFactory = $resultPageFactory;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->logger = $logger;
        $this->postRepository = $postRepository;
        parent::__construct($context);
    }

    /**
     * Saves the blog id to the register and renders the page
     * @return Page
     * @throws LocalizedException
     */
    public function execute()
    {
        $doEdit = (isset($_POST['edit']) ? $_POST['edit']: 0);
        $this->logger->info('Edit Loaded ' . $doEdit);

        if ($doEdit){
            $postid = $_POST['postid'];
            $title = $_POST['title'];
            $content = $_POST['content'];

            $this->logger->info('Post Id ' . $postid);
            $this->logger->info('$title ' . $title);
            $this->logger->info('$content' . $content);
            try {
                //Updating the Post
                /** @var PostRepositoryInterfaceFactory $postRepositoryInterfaceFactory */
                $post = $this->postRepository;
                $postId = $post->getById($postid);
                $postId->setTitle($title);
                $postId->setContent($content);
                $this->postRepository->save($postId);

                $resultJson = $this->resultJsonFactory->create();
                return $resultJson->setData(['edit' => 'Success Updated','postid' => $postid]);
            }catch (\Exception $e) {
                $this->logger->info('Edit Option '. $_POST['edit'] .'Post Update error', ['exception' => $e]);
            }
        }
        else {
            //Used to register the global variable
            $this->coreRegistry->register(self::REGISTRY_KEY_POST_ID, (int) $this->getRequest()->getParam('id'));
            $resultPage = $this->resultPageFactory->create();
            return $resultPage;
        }
    }
}
