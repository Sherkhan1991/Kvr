<?php

namespace Kvr\Blog\Block;

use \Magento\Framework\View\Element\Template;
use \Magento\Framework\View\Element\Template\Context;
use \Kvr\Blog\Model\ResourceModel\Post\CollectionFactory;
use \Kvr\Blog\Model\Post;

class Posts extends Template
{
    /**
     * CollectionFactory
     * @var null|CollectionFactory
     */
    protected $postCollection = null;

    /**
     * Constructor
     *
     * @param Context $context
     * @param CollectionFactory $postCollection
     * @param array $data
     */
    public function __construct(
        Context $context,
        CollectionFactory $postCollection,
        array $data = []
    ) {
        $this->postCollection = $postCollection;
        parent::__construct($context, $data);
    }

    /**
     * @return Post[]
     */
    public function getPosts()
    {
        /** @var PostCollection $postCollection */
        $postCollection = $this->postCollection->create();
        $postCollection->addFieldToSelect('*')->load();
        return $postCollection->getItems();
    }

    /**
     * For a given post, returns it's url
     * @param Post $post
     * @return string
     */
    public function getPostUrl(
        Post $post
    ) {
        return '/blog/post/view/id/' . $post->getId();
    }
}