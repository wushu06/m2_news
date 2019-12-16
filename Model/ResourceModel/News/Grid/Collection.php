<?php
namespace Tbb\News\Model\ResourceModel\News\Grid;

use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\Search\AggregationInterface;
use Tbb\News\Model\ResourceModel\News\Collection as NewsCollection;


class Collection extends NewsCollection implements SearchResultInterface
{

    /**
     * {@inheritdoc}
     */
    public function getAggregations()
    {
        return $this->aggregations;
    }

    /**
     * {@inheritdoc}
     */
    public function setAggregations($aggregations)
    {
        $this->aggregations = $aggregations;
    }

    /**
     * {@inheritdoc}
     */
    public function getAllIds($limit = null, $offset = null)
    {
        return $this->getConnection()->fetchCol($this->_getAllIdsSelect($limit, $offset), $this->_bindParams);
    }

    /**
     * {@inheritdoc}
     */
    public function getSearchCriteria()
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function setSearchCriteria(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria = null)
    {
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTotalCount()
    {
        return $this->getSize();
    }

    /**
     * {@inheritdoc}
     */
    public function setTotalCount($totalCount)
    {
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setItems(array $items = null)
    {
        return $this;
    }

    /**
     * Overrides the basic implementation of this to add special handling for the `category_ids`
     * column. This adds the category ids filter to be used in the Magento admin and joins that
     * table in (grouping by the post entity_id column).
     * 
     * @param array|int|\Magento\Eav\Model\Entity\Attribute\AttributeInterface|string $attribute
     * @param null $condition
     * @param string $joinType
     * @return $this
     */
    public function addAttributeToFilter($attribute, $condition = null, $joinType = 'inner')
    {
        $select = $this->getSelect();


        return parent::addAttributeToFilter($attribute, $condition, $joinType);

    }



}
