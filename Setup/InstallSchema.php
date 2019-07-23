<?php

namespace SmartOSC\Blog\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context
    ) {
        $installer = $setup;
        $installer->startSetup();
        // Post table
        if (!$installer->tableExists('SmartOSC_blog_post')) {
            $table = $installer->getConnection()
                ->newTable($installer->getTable('SmartOSC_blog_post'))
                ->addColumn(
                    'post_id',
                    Table::TYPE_INTEGER,
                    null,
                    ['identity' => true,
                    'nullable' => false,
                    'primary' => true,
                    'unsigned' => true],
                    'Post ID'
                )->addColumn(
                    'store_id',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => true, 'unsigned' => true],
                    'Store Id'
                )->addColumn(
                    'category_ids',
                    Table::TYPE_TEXT,
                    255,
                    [],
                    'Category ID'
                )->addColumn(
                    'title',
                    Table::TYPE_TEXT,
                    255,
                    [],
                    'Title'
                )->addColumn(
                    'content',
                    Table::TYPE_TEXT,
                    '64k',
                    ['nullable' => false],
                    'Content'
                )->addColumn(
                    'author_id',
                    Table::TYPE_INTEGER,
                    null,
                    [],
                    'Author'
                )->addColumn(
                    'is_active',
                    Table::TYPE_SMALLINT,
                    null,
                    ['default' => 1],
                    'Is Active'
                )->addColumn(
                    'is_featured',
                    Table::TYPE_SMALLINT,
                    null,
                    ['default' => 0],
                    'Is Featured'
                )->addColumn(
                    'allow_comment',
                    Table::TYPE_SMALLINT,
                    1,
                    ['default' => 1],
                    'Allow Comment'
                )->addColumn(
                    'url_key',
                    Table::TYPE_TEXT,
                    255,
                    [],
                    'URL Key'
                )->addColumn(
                    'views',
                    Table::TYPE_INTEGER,
                    null,
                    [],
                    'Views'
                )->addColumn(
                    'image',
                    Table::TYPE_TEXT,
                    255,
                    [],
                    'Image'
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
                    'Updated At');
            $installer->getConnection()->createTable($table);
        }
        // Tag table
        if (!$installer->tableExists('SmartOSC_blog_tag')) {
            $table = $installer->getConnection()
                ->newTable($installer->getTable('SmartOSC_blog_tag'))
                ->addColumn('tag_id', Table::TYPE_INTEGER, null, [
                    'identity' => true,
                    'nullable' => false,
                    'primary'  => true,
                    'unsigned' => true,
                ], 'Tag ID')
                ->addColumn(
                    'name',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable => false'],
                    'Tag Name'
                )->addColumn(
                    'url_key',
                    Table::TYPE_TEXT,
                    255,
                    [],
                    'URL Key'
                )->addColumn(
                    'description',
                    Table::TYPE_TEXT,
                    '64k',
                    [],
                    'Description'
                )->addColumn(
                    'updated_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
                    'Updated At'
                )->addColumn(
                    'created_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE],
                    'Created At');
            $installer->getConnection()->createTable($table);
        }

        // Category table
        if (!$installer->tableExists('SmartOSC_blog_category')) {
            $table = $installer->getConnection()
                ->newTable($installer->getTable('SmartOSC_blog_category'))
                ->addColumn('category_id', Table::TYPE_INTEGER, null, [
                    'identity' => true,
                    'nullable' => false,
                    'primary'  => true,
                    'unsigned' => true,
                ], 'Category ID')
                ->addColumn('name',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable => false'],
                    'Category Name')
                ->addColumn('description',
                    Table::TYPE_TEXT,
                    '64k',
                    [],
                    'Description')
                ->addColumn('url_key',
                    Table::TYPE_TEXT,
                    255,
                    [],
                    'URL Key')
                ->addColumn('enabled',
                    Table::TYPE_INTEGER,
                    1,
                    [],
                    'Enabled')
                ->addColumn('parent_id',
                    Table::TYPE_INTEGER,
                    null,
                    [],
                    'Category Parent Id')
                ->addColumn('path',
                    Table::TYPE_TEXT,
                    255,
                    [],
                    'Path')
                ->addColumn('position',
                    Table::TYPE_INTEGER,
                    null,
                    [],
                    'Position')
                ->addColumn('level',
                    Table::TYPE_INTEGER,
                    null,
                    [],
                    'Level')
                ->addColumn('children_count',
                    Table::TYPE_INTEGER,
                    null,
                    [],
                    'Children Count')
                ->addColumn('updated_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE],
                    'Updated At')
                ->addColumn('created_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
                    'Created At');
            $installer->getConnection()->createTable($table);
        }

        // Post_Category table
        if (!$installer->tableExists('SmartOSC_blog_post_category')) {
            $table = $installer->getConnection()
                ->newTable($installer->getTable('SmartOSC_blog_post_category'))
                ->addColumn('category_id', Table::TYPE_INTEGER, null, [
                    'unsigned' => true,
                    'primary'  => true,
                    'nullable' => false
                ], 'Category ID')
                ->addColumn('post_id', Table::TYPE_INTEGER, null, [
                    'unsigned' => true,
                    'primary'  => true,
                    'nullable' => false
                ], 'Post ID')
                ->addColumn('position', Table::TYPE_INTEGER, null, ['nullable' => false, 'default' => '0'], 'Position')
                ->addIndex($installer->getIdxName('SmartOSC_blog_post_category', ['category_id']), ['category_id'])
                ->addIndex($installer->getIdxName('SmartOSC_blog_post_category', ['post_id']), ['post_id'])
                ->addForeignKey(
                    $installer->getFkName('SmartOSC_blog_post_category', 'category_id', 'SmartOSC_blog_category', 'category_id'),
                    'category_id',
                    $installer->getTable('SmartOSC_blog_category'),
                    'category_id',
                    Table::ACTION_CASCADE
                )
                ->addForeignKey(
                    $installer->getFkName('SmartOSC_blog_post_category', 'post_id', 'SmartOSC_blog_post', 'post_id'),
                    'post_id',
                    $installer->getTable('SmartOSC_blog_post'),
                    'post_id',
                    Table::ACTION_CASCADE
                )
                ->addIndex(
                    $installer->getIdxName('SmartOSC_blog_post_category', ['category_id', 'post_id'], AdapterInterface::INDEX_TYPE_UNIQUE),
                    ['category_id', 'post_id'],
                    ['type' => AdapterInterface::INDEX_TYPE_UNIQUE]
                );
            $installer->getConnection()->createTable($table);
        }

        // Post_Tag table
        if (!$installer->tableExists('SmartOSC_blog_post_tag')) {
            $table = $installer->getConnection()
                ->newTable($installer->getTable('SmartOSC_blog_post_tag'))
                ->addColumn('post_id', Table::TYPE_INTEGER, null, [
                    'unsigned' => true,
                    'primary'  => true,
                    'nullable' => false
                ], 'Post ID')
                ->addColumn('tag_id', Table::TYPE_INTEGER, null, [
                    'unsigned' => true,
                    'primary'  => true,
                    'nullable' => false
                ], 'Tag ID')
                ->addColumn('position', Table::TYPE_INTEGER, null, [
                    'nullable' => false,
                    'default'  => '0'
                ], 'Position')
                ->addIndex($installer->getIdxName('SmartOSC_blog_post_tag', ['post_id']), ['post_id'])
                ->addIndex($installer->getIdxName('SmartOSC_blog_post_tag', ['tag_id']), ['tag_id'])
                ->addForeignKey(
                    $installer->getFkName('SmartOSC_blog_post_tag', 'post_id', 'SmartOSC_blog_post', 'post_id'),
                    'post_id',
                    $installer->getTable('SmartOSC_blog_post'),
                    'post_id',
                    Table::ACTION_CASCADE
                )
                ->addForeignKey(
                    $installer->getFkName('SmartOSC_blog_post_tag', 'tag_id', 'SmartOSC_blog_tag', 'tag_id'),
                    'tag_id',
                    $installer->getTable('SmartOSC_blog_tag'),
                    'tag_id',
                    Table::ACTION_CASCADE
                )
                ->addIndex(
                    $installer->getIdxName('mageplaza_blog_post_tag', ['post_id', 'tag_id'], AdapterInterface::INDEX_TYPE_UNIQUE),
                    ['post_id', 'tag_id'],
                    ['type' => AdapterInterface::INDEX_TYPE_UNIQUE]
                );

            $installer->getConnection()->createTable($table);

        }

        if (!$installer->tableExists('SmartOSC_blog_comment')) {
            $table = $installer->getConnection()
                ->newTable($installer->getTable('SmartOSC_blog_comment'))
                ->addColumn('comment_id', Table::TYPE_INTEGER, null, [
                    'identity' => true,
                    'unsigned' => true,
                    'nullable' => false,
                    'primary'  => true,
                ], 'Comment ID')
                ->addColumn('post_id',
                    Table::TYPE_INTEGER,
                    null,
                    ['unsigned' => true, 'nullable' => false],
                    'Post ID')
                ->addColumn('entity_id',
                    Table::TYPE_INTEGER,
                    null,
                    ['unsigned' => true, 'nullable' => false],
                    'User Comment ID')
                ->addColumn('has_reply',
                    Table::TYPE_SMALLINT,
                    2,
                    ['unsigned' => true, 'nullable' => false, 'default' => 0],
                    'Comment has reply')
                ->addColumn('is_reply',
                    Table::TYPE_SMALLINT,
                    2,
                    ['unsigned' => true, 'nullable' => false, 'default' => 0],
                    'Is reply comment')
                ->addColumn('reply_id',
                    Table::TYPE_INTEGER,
                    null,
                    ['unsigned' => true, 'nullable' => true, 'default' => 0],
                    'Reply ID')
                ->addColumn('content',
                    Table::TYPE_TEXT,
                    255,
                    [],
                    'Content')
                ->addColumn('created_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
                    'Created At')
                ->addColumn('updated_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE],
                    'Updated At')
                ->addColumn('is_active',
                    Table::TYPE_SMALLINT,
                    3,
                    ['unsigned' => true, 'nullable' => false, 'default' => 3],
                    'Is Active')
                ->addIndex($installer->getIdxName('SmartOSC_blog_comment', ['comment_id']), ['comment_id'])
                ->addIndex($installer->getIdxName('SmartOSC_blog_comment', ['entity_id']), ['entity_id'])
                ->addForeignKey(
                    $installer->getFkName('SmartOSC_blog_comment', 'entity_id', 'customer_entity', 'entity_id'),
                    'entity_id',
                    $installer->getTable('customer_entity'),
                    'entity_id',
                    Table::ACTION_CASCADE
                )->addForeignKey(
                    $installer->getFkName('SmartOSC_blog_comment', 'post_id', 'SmartOSC_blog_post', 'post_id'),
                    'post_id',
                    $installer->getTable('SmartOSC_blog_post'),
                    'post_id',
                    Table::ACTION_CASCADE
                );

            $installer->getConnection()->createTable($table);
        }
    }
}
