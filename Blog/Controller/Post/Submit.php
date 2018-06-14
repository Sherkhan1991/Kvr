<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 05-Jun-18
 * Time: 2:59 PM
 */

namespace Kvr\Blog\Controller\Post;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Kvr\Blog\Api\PostRepositoryInterface;
use Kvr\Blog\Api\Data\PostInterfaceFactory;
use Magento\Framework\Controller\Result\JsonFactory;

class Submit extends Action
{
    /**
     * @var Magento\Framework\Controller\ResultFactory
     */
    protected $resultFactory;

    /**
     * @var PostInterfaceFactory
     */
    protected $postFactory;

    /**
     * @var PostRepositoryInterface
     */
    protected $postRepository;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    private $resultJsonFactory;

    /**
     * @param Context $context
     * @param ResultFactory $resultFactory
     * @param PostInterfaceFactory $postFactory
     * @param PostRepositoryInterface $postRepository
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     */
    public function __construct(
        Context $context,
        ResultFactory $resultFactory,
        PostInterfaceFactory $postFactory,
        PostRepositoryInterface $postRepository,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory

    )
    {
        $this->resultFactory = $resultFactory;
        $this->postFactory = $postFactory;
        $this->postRepository = $postRepository;
        $this->logger = $logger;
        $this->resultJsonFactory = $resultJsonFactory;
        return parent::__construct($context);
    }

    /**
     * @return $this|\Magento\Framework\Controller\Result\Json
     * @throws LocalizedException
     */
    public function execute()
    {
        $this->logger->debug('Submit Call run');
        //Save Data using Ajax
        $post = $this->postFactory->create();
        $title = $_POST['title'];
        $content = $_POST['content'];
        try {
            $post->setTitle($title);
            $post->setContent($content);
            $this->postRepository->save($post);
            $this->messageManager->addSuccessMessage("New Post: ". $title ." Created");
            //Get latest Row
            $id = $post->getId();
            //$this->logger->info('$id '. $id);
            //return Json
            $resultJson = $this->resultJsonFactory->create();
            return $resultJson->setData(['postid' => $id]);

        } catch (\Exception $e) {
            //Add a error message if we cant save the new note from some reason
            //$this->messageManager->addErrorMessage("Unable to save this Post: " . $title);
            $this->logger->info('Blog Post Submit Error', ['exception' => $e]);
            throw new LocalizedException(__('Blog Post Save Failed'));
        }

    }

}