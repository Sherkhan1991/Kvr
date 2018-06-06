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
use Magento\Framework\View\Result\PageFactory;
//use Magento\Framework\Controller\Result\JsonFactory;
use Kvr\Blog\Model\Post;

class Submit extends Action
{
    /**
     * @var Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var Magento\Framework\Controller\Result\JsonFactory;
     */
    //protected $resultJsonFactory;

    /**
     * @var Kvr\Blog\Model\Post;
     */
    protected $post;

    /**
     * @var Magento\Framework\Controller\ResultFactory
     */
    protected $resultFactory;

    /**
     * @param Context     $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        //JsonFactory $resultJsonFactory,
        ResultFactory $resultFactory,
        Post $post
    )
    {

        $this->resultPageFactory = $resultPageFactory;
        //$this->resultJsonFactory = $resultJsonFactory;
        $this->post = $post;
        $this->ResultFactory = $resultFactory;
        return parent::__construct($context);
    }

    public function execute()
    {
       $resultPage = $this->resultPageFactory->create();
        $title = $this->getRequest()->getPostValue("title");
        $content = $this->getRequest()->getPostValue("content");
        echo $title;
        echo "<br />";
        echo $content;
        echo "<br />";
        //exit;
        //$post = $this->getRequest()->getPostValue();
        //$data=array('title'=>$post['title'],'content'=>$post['content']);
        //$data=array('title'=>'title123','content'=>'content123');
        $post = $this->post;

        $post->setTitle($title);
        $post->setContent($content);
        $post->save();
        $this->messageManager->addSuccess(__('Your values has beeen submitted successfully.'));

        $redirect = $this->ResultFactory->create(ResultFactory::TYPE_REDIRECT);
        $redirect->setUrl('/blog/index/index');
        return $redirect;
    }
}