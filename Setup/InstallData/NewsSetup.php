<?php
namespace Tbb\News\Setup\InstallData;


use Tbb\News\Model\NewsFactory;
use Magento\Eav\Model\Entity\Setup\Context;
use Magento\Eav\Model\ResourceModel\Entity\Attribute\Group\CollectionFactory;
use Magento\Eav\Setup\EavSetup;
use Magento\Framework\App\CacheInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;

class NewsSetup extends EavSetup
{
    /**
     * Category model factory
     *
     * @var NewsFactory
     */
    private $newsFactory;

    /**
     * Init
     *
     * @param ModuleDataSetupInterface $setup
     * @param Context                  $context
     * @param CacheInterface           $cache
     * @param CollectionFactory        $attrGroupCollectionFactory
     * @param PostFactory              $categoryFactory
     */
    public function __construct(
        ModuleDataSetupInterface $setup,
        Context $context,
        CacheInterface $cache,
        CollectionFactory $attrGroupCollectionFactory,
        NewsFactory $newsFactory
    ) {
        $this->newsFactory = $newsFactory;
        parent::__construct($setup, $context, $cache, $attrGroupCollectionFactory);
    }

    /**
     * Default entities and attributes
     *
     * @return array
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function getDefaultEntities()
    {
        return [
            'tbb_news' => [
                'entity_model' => 'Tbb\News\Model\ResourceModel\News',
                'table'        => 'tbb_news_entity',
                'attributes'   => [
                    'author_id' => [
                        'type'   => 'static',
                        'label'  => 'Author Id',
                        'input'  => 'select',
                        'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                    ],
                    'type'      => [
                        'type'   => 'static',
                        'label'  => 'Type',
                        'input'  => 'text',
                        'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                    ],
                    'name'      => [
                        'type'   => 'varchar',
                        'label'  => 'Name',
                        'input'  => 'text',
                        'global' => ScopedAttributeInterface::SCOPE_STORE,
                    ],

                    'url_key' => [
                        'type'   => 'varchar',
                        'label'  => 'Url Key',
                        'input'  => 'text',
                        'global' => ScopedAttributeInterface::SCOPE_STORE,
                    ],

                    'status' => [
                        'type'   => 'int',
                        'label'  => 'Status',
                        'input'  => 'select',
                        'source' => 'Tbb\News\Model\News\Attribute\Source\Status',
                        'global' => ScopedAttributeInterface::SCOPE_WEBSITE,
                    ],

                    'content' => [
                        'type'   => 'text',
                        'label'  => 'Content',
                        'input'  => 'textarea',
                        'global' => ScopedAttributeInterface::SCOPE_STORE,
                    ],

                    'short_content' => [
                        'type'   => 'text',
                        'label'  => 'Short Content',
                        'input'  => 'textarea',
                        'global' => ScopedAttributeInterface::SCOPE_STORE,
                    ],

                    'featured_image' => [
                        'type'   => 'text',
                        'label'  => 'Featured Image',
                        'input'  => 'text',
                        'global' => ScopedAttributeInterface::SCOPE_STORE,
                    ],

                    'is_pinned' => [
                        'type'   => 'int',
                        'label'  => 'Is pinned?',
                        'input'  => 'text',
                        'global' => ScopedAttributeInterface::SCOPE_STORE,
                    ],

                    'meta_title'       => [
                        'type'   => 'varchar',
                        'label'  => 'Meta Title',
                        'input'  => 'text',
                        'global' => ScopedAttributeInterface::SCOPE_STORE,
                    ],
                    'meta_keywords'    => [
                        'type'   => 'text',
                        'label'  => 'Meta Keywords',
                        'input'  => 'textarea',
                        'global' => ScopedAttributeInterface::SCOPE_STORE,
                    ],
                    'meta_description' => [
                        'type'   => 'varchar',
                        'label'  => 'Meta Description',
                        'input'  => 'textarea',
                        'global' => ScopedAttributeInterface::SCOPE_STORE,
                    ],
                ],
            ],
        ];
    }
}
