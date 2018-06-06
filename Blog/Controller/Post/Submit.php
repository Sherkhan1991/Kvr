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
use Kvr\Blog\Model\PostFactory;
use Magento\Framework\Exception\LocalizedException;

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
     * @var Kvr\Blog\Model\PostFactory
     */
     protected $postFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        ResultFactory $resultFactory,
        PostFactory $postFactory
    )
    {

        $this->resultPageFactory = $resultPageFactory;
        $this->resultFactory = $resultFactory;
        $this->postFactory = $postFactory;
        return parent::__construct($context);
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();

        //Save Data using setData Method using post resource model
        $postData = $this->getRequest()->getPost();
            //Probably best do some form of validation here but for tutorial purposes, we wont for now
            $title = $postData['title'];
            $issue = $postData['content'];

            $data = array('title'=>$title,'content'=>$issue);
            $postResource = $this->postFactory->create();

            try {
                $postResource->setData($data);
                $postResource->save();
                $this->messageManager->addSuccess("New Post: $title Created");
                $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
                $redirect->setUrl('/blog/index/index');
                return $redirect;
            } catch (\Exception $e) {
                //Add a error message if we cant save the new note from some reason
                $this->messageManager->addError("Unable to save this Post: $title ");
            }
    }
}