<?php

namespace Tbb\News\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\DB\Adapter\AdapterInterface;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     * @param SchemaSetupInterface   $setup
     * @param ModuleContextInterface $context
     *
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        $this->installNewsEntity($installer);
    }

    /**
     * @param SchemaSetupInterface $installer
     * @return void
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function installNewsEntity(SchemaSetupInterface $installer)
    {
        $table = $installer->getConnection()
            ->newTable($installer->getTable('tbb_news_entity'))
            ->addColumn(
                'entity_id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Entity ID'
            )->addColumn(
                'author_id',
                Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => true],
                'Author Id'
            )->addColumn(
                'type',
                Table::TYPE_TEXT,
                255,
                ['unsigned' => true, 'nullable' => true],
                'Post type'
            )->addColumn(
                'parent_id',
                Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => 0],
                'Parent Post Id'
            )->addColumn(
                'created_at',
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
                'Created At'
            )->addColumn(
                'updated_at',
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE],
                'Updated At'
            );
        $installer->getConnection()->createTable($table);

        $table = $installer->getConnection()
            ->newTable($installer->getTable('tbb_news_entity_datetime'))
            ->addColumn(
                'value_id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true],
                'Value ID'
            )->addColumn(
                'attribute_id',
                Table::TYPE_SMALLINT,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Attribute ID'
            )->addColumn(
                'store_id',
                Table::TYPE_SMALLINT,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Store ID'
            )->addColumn(
                'entity_id',
                Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Entity ID'
            )->addColumn(
                'value',
                Table::TYPE_DATETIME,
                null,
                [],
                'Value'
            )->addIndex(
                $installer->getIdxName(
                    'tbb_news_entity_datetime',
                    ['entity_id', 'attribute_id', 'store_id'],
                    AdapterInterface::INDEX_TYPE_UNIQUE
                ),
                ['entity_id', 'attribute_id', 'store_id'],
                ['type' => AdapterInterface::INDEX_TYPE_UNIQUE]
            )->addIndex(
                $installer->getIdxName('tbb_news_entity_datetime', ['attribute_id']),
                ['attribute_id']
            )->addIndex(
                $installer->getIdxName('tbb_news_entity_datetime', ['store_id']),
                ['store_id']
            )->addForeignKey(
                $installer->getFkName(
                    'tbb_news_entity_datetime',
                    'attribute_id',
                    'eav_attribute',
                    'attribute_id'
                ),
                'attribute_id',
                $installer->getTable('eav_attribute'),
                'attribute_id',
                Table::ACTION_CASCADE
            )->addForeignKey(
                $installer->getFkName(
                    'tbb_news_entity_datetime',
                    'entity_id',
                    'tbb_news_entity',
                    'entity_id'
                ),
                'entity_id',
                $installer->getTable('tbb_news_entity'),
                'entity_id',
                Table::ACTION_CASCADE
            )->addForeignKey(
                $installer->getFkName('tbb_news_entity_datetime', 'store_id', 'store', 'store_id'),
                'store_id',
                $installer->getTable('store'),
                'store_id',
                Table::ACTION_CASCADE
            )
            ->setComment('Blog Post Datetime Attribute Backend Table');
        $installer->getConnection()->createTable($table);

        $table = $installer->getConnection()
            ->newTable($installer->getTable('tbb_news_entity_decimal'))
            ->addColumn(
                'value_id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true],
                'Value ID'
            )->addColumn(
                'attribute_id',
                Table::TYPE_SMALLINT,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Attribute ID'
            )->addColumn(
                'store_id',
                Table::TYPE_SMALLINT,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Store ID'
            )->addColumn(
                'entity_id',
                Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Entity ID'
            )->addColumn(
                'value',
                Table::TYPE_DECIMAL,
                '12,4',
                [],
                'Value'
            )->addIndex(
                $installer->getIdxName(
                    'tbb_news_entity_decimal',
                    ['entity_id', 'attribute_id', 'store_id'],
                    AdapterInterface::INDEX_TYPE_UNIQUE
                ),
                ['entity_id', 'attribute_id', 'store_id'],
                ['type' => AdapterInterface::INDEX_TYPE_UNIQUE]
            )->addIndex(
                $installer->getIdxName('tbb_news_entity_decimal', ['store_id']),
                ['store_id']
            )->addIndex(
                $installer->getIdxName('tbb_news_entity_decimal', ['attribute_id']),
                ['attribute_id']
            )->addForeignKey(
                $installer->getFkName(
                    'tbb_news_entity_decimal',
                    'attribute_id',
                    'eav_attribute',
                    'attribute_id'
                ),
                'attribute_id',
                $installer->getTable('eav_attribute'),
                'attribute_id',
                Table::ACTION_CASCADE
            )->addForeignKey(
                $installer->getFkName(
                    'tbb_news_entity_decimal',
                    'entity_id',
                    'tbb_news_entity',
                    'entity_id'
                ),
                'entity_id',
                $installer->getTable('tbb_news_entity'),
                'entity_id',
                Table::ACTION_CASCADE
            )->addForeignKey(
                $installer->getFkName('tbb_news_entity_decimal', 'store_id', 'store', 'store_id'),
                'store_id',
                $installer->getTable('store'),
                'store_id',
                Table::ACTION_CASCADE
            )->setComment('Blog Post Decimal Attribute Backend Table');
        $installer->getConnection()->createTable($table);


        $table = $installer->getConnection()
            ->newTable($installer->getTable('tbb_news_entity_int'))
            ->addColumn(
                'value_id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true],
                'Value ID'
            )->addColumn(
                'attribute_id',
                Table::TYPE_SMALLINT,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Attribute ID'
            )->addColumn(
                'store_id',
                Table::TYPE_SMALLINT,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Store ID'
            )->addColumn(
                'entity_id',
                Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Entity ID'
            )->addColumn(
                'value',
                Table::TYPE_INTEGER,
                null,
                [],
                'Value'
            )->addIndex(
                $installer->getIdxName(
                    'tbb_news_entity_int',
                    ['entity_id', 'attribute_id', 'store_id'],
                    AdapterInterface::INDEX_TYPE_UNIQUE
                ),
                ['entity_id', 'attribute_id', 'store_id'],
                ['type' => AdapterInterface::INDEX_TYPE_UNIQUE]
            )->addIndex(
                $installer->getIdxName('tbb_news_entity_int', ['attribute_id']),
                ['attribute_id']
            )->addIndex(
                $installer->getIdxName('tbb_news_entity_int', ['store_id']),
                ['store_id']
            )->addForeignKey(
                $installer->getFkName('tbb_news_entity_int', 'attribute_id', 'eav_attribute', 'attribute_id'),
                'attribute_id',
                $installer->getTable('eav_attribute'),
                'attribute_id',
                Table::ACTION_CASCADE
            )->addForeignKey(
                $installer->getFkName('tbb_news_entity_int', 'entity_id', 'tbb_news_entity', 'entity_id'),
                'entity_id',
                $installer->getTable('tbb_news_entity'),
                'entity_id',
                Table::ACTION_CASCADE
            )->addForeignKey(
                $installer->getFkName('tbb_news_entity_int', 'store_id', 'store', 'store_id'),
                'store_id',
                $installer->getTable('store'),
                'store_id',
                Table::ACTION_CASCADE
            )->setComment('Blog Post Integer Attribute Backend Table');
        $installer->getConnection()->createTable($table);


        $table = $installer->getConnection()
            ->newTable($installer->getTable('tbb_news_entity_text'))
            ->addColumn(
                'value_id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true],
                'Value ID'
            )->addColumn(
                'attribute_id',
                Table::TYPE_SMALLINT,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Attribute ID'
            )->addColumn(
                'store_id',
                Table::TYPE_SMALLINT,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Store ID'
            )->addColumn(
                'entity_id',
                Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Entity ID'
            )->addColumn(
                'value',
                Table::TYPE_TEXT,
                '64k',
                [],
                'Value'
            )->addIndex(
                $installer->getIdxName(
                    'tbb_news_entity_text',
                    ['entity_id', 'attribute_id', 'store_id'],
                    AdapterInterface::INDEX_TYPE_UNIQUE
                ),
                ['entity_id', 'attribute_id', 'store_id'],
                ['type' => AdapterInterface::INDEX_TYPE_UNIQUE]
            )->addIndex(
                $installer->getIdxName('tbb_news_entity_text', ['attribute_id']),
                ['attribute_id']
            )->addIndex(
                $installer->getIdxName('tbb_news_entity_text', ['store_id']),
                ['store_id']
            )->addForeignKey(
                $installer->getFkName(
                    'tbb_news_entity_text',
                    'attribute_id',
                    'eav_attribute',
                    'attribute_id'
                ),
                'attribute_id',
                $installer->getTable('eav_attribute'),
                'attribute_id',
                Table::ACTION_CASCADE
            )->addForeignKey(
                $installer->getFkName(
                    'tbb_news_entity_text',
                    'entity_id',
                    'tbb_news_entity',
                    'entity_id'
                ),
                'entity_id',
                $installer->getTable('tbb_news_entity'),
                'entity_id',
                Table::ACTION_CASCADE
            )->addForeignKey(
                $installer->getFkName('tbb_news_entity_text', 'store_id', 'store', 'store_id'),
                'store_id',
                $installer->getTable('store'),
                'store_id',
                Table::ACTION_CASCADE
            )->setComment('Blog Post Text Attribute Backend Table');
        $installer->getConnection()->createTable($table);


        $table = $installer->getConnection()
            ->newTable($installer->getTable('tbb_news_entity_varchar'))
            ->addColumn(
                'value_id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true],
                'Value ID'
            )->addColumn(
                'attribute_id',
                Table::TYPE_SMALLINT,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Attribute ID'
            )->addColumn(
                'store_id',
                Table::TYPE_SMALLINT,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Store ID'
            )->addColumn(
                'entity_id',
                Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Entity ID'
            )->addColumn(
                'value',
                Table::TYPE_TEXT,
                255,
                [],
                'Value'
            )->addIndex(
                $installer->getIdxName(
                    'catalog_product_entity_varchar',
                    ['entity_id', 'attribute_id', 'store_id'],
                    AdapterInterface::INDEX_TYPE_UNIQUE
                ),
                ['entity_id', 'attribute_id', 'store_id'],
                ['type' => AdapterInterface::INDEX_TYPE_UNIQUE]
            )->addIndex(
                $installer->getIdxName('tbb_news_entity_varchar', ['attribute_id']),
                ['attribute_id']
            )->addIndex(
                $installer->getIdxName('tbb_news_entity_varchar', ['store_id']),
                ['store_id']
            )->addForeignKey(
                $installer->getFkName(
                    'tbb_news_entity_varchar',
                    'attribute_id',
                    'eav_attribute',
                    'attribute_id'
                ),
                'attribute_id',
                $installer->getTable('eav_attribute'),
                'attribute_id',
                Table::ACTION_CASCADE
            )->addForeignKey(
                $installer->getFkName(
                    'tbb_news_entity_varchar',
                    'entity_id',
                    'tbb_news_entity',
                    'entity_id'
                ),
                'entity_id',
                $installer->getTable('tbb_news_entity'),
                'entity_id',
                Table::ACTION_CASCADE
            )->addForeignKey(
                $installer->getFkName('tbb_news_entity_varchar', 'store_id', 'store', 'store_id'),
                'store_id',
                $installer->getTable('store'),
                'store_id',
                Table::ACTION_CASCADE
            )->setComment('Blog Post Varchar Attribute Backend Table');
        $installer->getConnection()->createTable($table);


        $table = $installer->getConnection()
            ->newTable($installer->getTable('tbb_news_entity_gallery'))
            ->addColumn(
                'value_id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true],
                'Value ID'
            )->addColumn(
                'attribute_id',
                Table::TYPE_SMALLINT,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Attribute ID'
            )->addColumn(
                'store_id',
                Table::TYPE_SMALLINT,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Store ID'
            )->addColumn(
                'entity_id',
                Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Entity ID'
            )->addColumn(
                'position',
                Table::TYPE_INTEGER,
                null,
                ['nullable' => false, 'default' => '0'],
                'Position'
            )->addColumn(
                'value',
                Table::TYPE_TEXT,
                255,
                ['nullable' => true, 'default' => null],
                'Value'
            )->addIndex(
                $installer->getIdxName(
                    'tbb_news_entity_gallery',
                    ['entity_id', 'attribute_id', 'store_id'],
                    AdapterInterface::INDEX_TYPE_UNIQUE
                ),
                ['entity_id', 'attribute_id', 'store_id'],
                ['type' => AdapterInterface::INDEX_TYPE_UNIQUE]
            )->addIndex(
                $installer->getIdxName('tbb_news_entity_gallery', ['entity_id']),
                ['entity_id']
            )->addIndex(
                $installer->getIdxName('tbb_news_entity_gallery', ['attribute_id']),
                ['attribute_id']
            )->addIndex(
                $installer->getIdxName('tbb_news_entity_gallery', ['store_id']),
                ['store_id']
            )->addForeignKey(
                $installer->getFkName(
                    'tbb_news_entity_gallery',
                    'attribute_id',
                    'eav_attribute',
                    'attribute_id'
                ),
                'attribute_id',
                $installer->getTable('eav_attribute'),
                'attribute_id',
                Table::ACTION_CASCADE
            )->addForeignKey(
                $installer->getFkName(
                    'tbb_news_entity_gallery',
                    'entity_id',
                    'tbb_news_entity',
                    'entity_id'
                ),
                'entity_id',
                $installer->getTable('tbb_news_entity'),
                'entity_id',
                Table::ACTION_CASCADE
            )->addForeignKey(
                $installer->getFkName('tbb_news_entity_gallery', 'store_id', 'store', 'store_id'),
                'store_id',
                $installer->getTable('store'),
                'store_id',
                Table::ACTION_CASCADE
            )->setComment('Blog Post Gallery Attribute Backend Table');
        $installer->getConnection()->createTable($table);
    }

   
}
