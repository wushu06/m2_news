<?php

namespace Tbb\News\Model\ResourceModel;

use Magento\Framework\DataObject;
use Magento\Eav\Model\Entity\AbstractEntity;
use Magento\Eav\Model\Entity\Context;
use Tbb\News\Api\Data\NewsInterface;
use Tbb\News\Model\Config;
use Magento\Framework\Filter\FilterManager;
use Magento\Framework\File\Uploader as FileUploader;

class News extends AbstractEntity
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * @var FilterManager
     */
    protected $filter;



    public function __construct(
        Config $config,
        FilterManager $filter,
        Context $context,
        $data = []
    ) {
        $this->config = $config;
        $this->filter = $filter;

        parent::__construct($context, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function getEntityType()
    {
        if (empty($this->_type)) {
            $this->setType(\Tbb\News\Model\News::ENTITY);
        }

        return parent::getEntityType();
    }

    protected function _afterLoad(DataObject $post)
    {

    }

    /**
     * {@inheritdoc}
     */
    protected function _afterSave(DataObject $post)
    {

    }



}