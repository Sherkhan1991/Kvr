<?php

namespace Kvr\Blog\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for cms page search results.
 * @api
 */
interface PostSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get pages list.
     *
     * @return \Kvr\Blog\Api\Data\PostInterface[]
     */
    public function getItems();

    /**
     * Set pages list.
     *
     * @param \Kvr\Blog\Api\Data\PostInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}