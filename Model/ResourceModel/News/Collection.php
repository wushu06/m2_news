<?php

namespace Tbb\News\Model\ResourceModel\News;

use Magento\Eav\Model\Entity\Collection\AbstractCollection;
use Tbb\News\Api\Data\NewsInterface;
use Tbb\News\Model\News;
use Tbb\News\Model\News\Attribute\Source\Status;

class Collection extends AbstractCollection
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('Tbb\News\Model\News', 'Tbb\News\Model\ResourceModel\News');
    }

    public function _afterLoad()
    {
        foreach ($this->_items as $item) {
            $item->load($item->getId());
        }

        return parent::_afterLoad();
    }

    /**
     * @return $this
     */
    public function addVisibilityFilter()
    {
        $this->addAttributeToFilter(NewsInterface::STATUS, NewsInterface::STATUS_PUBLISHED);
        $this->addFieldToFilter(NewsInterface::TYPE, NewsInterface::TYPE_POST);

        return $this;
    }


    /**
     * @param int $storeId
     * @return $this
     */
    public function addStoreFilter($storeId)
    {
        // NOT EXISTS is compatibility for prev versions
        $this->getSelect();

        return $this;
    }




    /**
     * @param string $q
     * @return $this
     */
    public function addSearchFilter($q)
    {
        $likeExpression = $this->_resourceHelper->addLikeEscape($q, ['position' => 'any']);

        $this->addAttributeToSelect('name');
        $this->addAttributeToSelect(['content', 'short_content'], 'left');

        $this->addAttributeToFilter([
            ['attribute' => 'name', 'like' => $likeExpression],
            ['attribute' => 'content', 'like' => $likeExpression],
            ['attribute' => 'short_content', 'like' => $likeExpression],
        ]);

        return $this;
    }


    /**
     * @return $this
     */
    public function addNewsFilter()
    {
        $this->addFieldToFilter('type', \Tbb\News\Model\News::TYPE_POST);

        return $this;
    }

    /**
     * @return $this
     */
    public function defaultOrder()
    {
        $this->addAttributeToSort('is_pinned', self::SORT_ORDER_DESC);
        $this->getSelect()->order('updated_at DESC');

        return $this;
    }
}