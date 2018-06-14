<?php

namespace Kvr\Blog\Block;

use \Magento\Framework\View\Element\Template;
use \Magento\Framework\View\Element\Template\Context;
use \Kvr\Blog\Model\Post;
use Kvr\Blog\Api\PostRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;

class Posts extends Template
{

    /**
     * @var PostRepositoryInterface
     */
    protected $postRepository;

    /**
     * SearchCriteriaBuilder
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * Constructor
     *
     * @param Context $context
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param array $data
     */
    public function __construct(
        Context $context,
        PostRepositoryInterface $postRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        array $data = []
    ) {
        $this->postRepository = $postRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        parent::__construct($context, $data);
    }

    /**
     * @return postRepository[]
     */
    public function getPosts()
    {
        //Use to Fetch All records
        $search_criteria =  $this->searchCriteriaBuilder->create();
        $postRepository = $this->postRepository->getList($search_criteria);
        return $postRepository->getItems();
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