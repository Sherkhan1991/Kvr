<?php

namespace Kvr\Blog\Controller\Post;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Controller\Result\JsonFactory;
use Kvr\Blog\Api\PostRepositoryInterface;

class Delete extends Action
{
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
     * @param JsonFactory $resultJsonFactory
     * @param \Psr\Log\LoggerInterface $logger
     * @param PostRepositoryInterface $postRepository
     *
     * @codeCoverageIgnore
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        \Psr\Log\LoggerInterface $logger,
        PostRepositoryInterface $postRepository
    ) {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->logger = $logger;
        $this->postRepository = $postRepository;
        parent::__construct($context);
    }

    /**
     * Remove the Blog Post
     * @return postId
     * @throws LocalizedException
     */
    public function execute()
    {
        try {
            $postId = (isset($_POST['postid']) ? $_POST['postid']: 0);
            $this->logger->info('Delete Loaded ' . $postId);
            if(isset($_POST['postid'])){
                $post = $this->postRepository;
                $post->deleteById($postId);
                $this->messageManager->addSuccessMessage("Post Removed: ". $postId);
                $resultJson = $this->resultJsonFactory->create();
                return $resultJson->setData(['delete' => 'Post Deleted','postid' => $postId,'view' => $_POST["view"]]);
            }
        }catch (\Exception $e) {
            $this->logger->info('Delete Post Failed', ['exception' => $e]);
            $this->messageManager->addErrorMessage("Post Removed Failed: ". $postId);
        }
    }
}