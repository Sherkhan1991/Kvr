<?php
namespace Kvr\Blog\Model\ResourceModel\Post;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    /**
     * @var string
     */
    protected $_idFieldName = 'post_id';	
	
    /**
     * Remittance File Collection Constructor
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Kvr\Blog\Model\Post', 'Kvr\Blog\Model\ResourceModel\Post');
    }
}
