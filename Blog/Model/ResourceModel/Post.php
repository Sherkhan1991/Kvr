<?php

namespace Kvr\Blog\Model\ResourceModel;

use \Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Post extends AbstractDb
{
    /**
     * Post Abstract Resource Constructor
     * @return void
     */
    protected function _construct()
    {
        $this->_init('kvr_blog_post', 'post_id');
    }
	
    /**
     * Load an object using 'url_key' field if there's no field specified and value is not numeric
     *
     * @param \Magento\Framework\Model\AbstractModel $object
     * @param mixed $value
     * @param string $field
     * @return $this
     */
    public function load(\Magento\Framework\Model\AbstractModel $object, $value, $field = null)
    {
        if (!is_numeric($value) && is_null($field)) {
            $field = 'url_key';
        }

        return parent::load($object, $value, $field);
    }


	
    /**
     * Retrieve load select with filter by post_id and activity
     *
     * @param string $post_id
     * @param int $isActive
     * @return \Magento\Framework\DB\Select
     */
    protected function _getLoadByPostIdSelect($post_id)
    {
        $select = $this->getConnection()->select()->from(
            ['tbp' => $this->getMainTable()]
        )->where(
            'tbp.post_id = ?',
            $post_id
        );

        return $select;
    }	

    /**
     * Check if post url key exists
     * return post id if post exists
     *
     * @param string $url_key
     * @return int
     */
    public function checkUrlKey($url_key)
    {
        $select = $this->_getLoadByUrlKeySelect($url_key, 1);
        $select->reset(\Zend_Db_Select::COLUMNS)->columns('tbp.post_id')->limit(1);

        return $this->getConnection()->fetchOne($select);
    }	
}
