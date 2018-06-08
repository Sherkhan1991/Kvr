<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 05-Jun-18
 * Time: 2:59 PM
 */

namespace Kvr\Blog\Controller\Post;

use Kvr\Blog\Model\PostFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Exception\LocalizedException;
use Kvr\Blog\Api\PostRepositoryInterface;
use Kvr\Blog\Api\Data\PostInterfaceFactory;

class Submit extends Action
{
    /**
     * @var Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

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
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        ResultFactory $resultFactory,
        PostInterfaceFactory $postFactory,
        PostRepositoryInterface $postRepository,
        \Psr\Log\LoggerInterface $logger

    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->resultFactory = $resultFactory;
        $this->postFactory = $postFactory;
        $this->postRepository = $postRepository;
        $this->logger = $logger;

        return parent::__construct($context);
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();

        //Save Data using setData Method using post resource model
        $postData = $this->getRequest()->getPost();
        $post = $this->postFactory->create();
        $title = $postData['title'];
        try {
            $post->setTitle($title);
            $post->setContent($postData['content']);
            $this->postRepository->save($post);
            $this->messageManager->addSuccessMessage("New Post: ". $title ."Created");
            $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $redirect->setUrl('/blog/index/index');
            return $redirect;
        } catch (\Exception $e) {
            //Add a error message if we cant save the new note from some reason
            $this->messageManager->addErrorMessage("Unable to save this Post:" . $title);
            $this->logger->critical('Blog Post save Error', ['exception' => $e]);
            throw new LocalizedException(__('Blog Post Save Failed'));
        }
    }
}