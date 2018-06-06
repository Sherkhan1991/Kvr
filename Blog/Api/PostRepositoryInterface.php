<?php

namespace Kvr\Blog\Api;

use Kvr\Blog\Api\Data\PostInterface;

/**
 * @api
 * @since 100.0.2
 */
interface PostRepositoryInterface
{
    /**
     * Create post
     *
     * @param PostInterface $post
     * @return PostInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(PostInterface $post);

    /**
     * Get info about post by post id
     *
     * @param int $postId
     * @return PostInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($postId);

    /**
     * Delete post
     *
     * @param PostInterface $post
     * @return bool Will returned True if deleted
     * @throws \Magento\Framework\Exception\StateException
     */
    public function delete(PostInterface $post);

    /**
     * @param string $postId
     * @return bool Will returned True if deleted
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\StateException
     */
    public function deleteById($postId);

    /**
     * Get post list
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return Kvr\Blog\Api\Data\PostSearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

}
