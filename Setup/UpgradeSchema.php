<?php

namespace SmartOSC\Blog\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{

    /**
     * {@inheritdoc}
     */
    public function upgrade(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $postTable = 'SmartOSC_blog_post';
        $categoryTable = 'SmartOSC_blog_category';
        $postCategoryTable = 'SmartOSC_blog_post_category';
        
        if (version_compare($context->getVersion(), "1.0.1", "<")) {
            $connection = $setup->getConnection();

            /**
             * Modify POST table
             */
            $connection->addColumn(
                $setup->getTable($postTable),
                'meta_description',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => '64k',
                    'comment' => 'Meta Description',
                    'after' => 'url_key',
                ]
            );
            $connection->addColumn(
                $setup->getTable($postTable),
                'meta_title',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => '255',
                    'comment' => 'Meta Title',
                    'after' => 'url_key',
                ]
            );
            $connection->addColumn(
                $setup->getTable($postTable),
                'short_description',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => '255',
                    'comment' => 'Short Description',
                    'before' => 'content',
                ]
            );
            $connection->addIndex(
                $setup->getTable($postTable),
                'url_key',
                ['url_key']
            );

            /**
             * Modify Category table
             */

            $connection->addColumn(
                $setup->getTable($categoryTable),
                'meta_description',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => '64k',
                    'comment' => 'Meta Description',
                    'after' => 'url_key',
                ]
            );
            $connection->addColumn(
                $setup->getTable($categoryTable),
                'meta_title',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => '255',
                    'comment' => 'Meta Title',
                    'after' => 'url_key',
                ]
            );
            $connection->dropColumn(
                $setup->getTable($categoryTable),
                'description'
            );
            $connection->dropColumn(
                $setup->getTable($categoryTable),
                'parent_id'
            );
            $connection->dropColumn(
                $setup->getTable($categoryTable),
                'path'
            );
            $connection->dropColumn(
                $setup->getTable($categoryTable),
                'position'
            );
            $connection->dropColumn(
                $setup->getTable($categoryTable),
                'level'
            );
            $connection->dropColumn(
                $setup->getTable($categoryTable),
                'children_count'
            );

            $connection->changeColumn(
                $categoryTable,
                'enabled',
                'is_active',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                    'nullable' => false,
                    'default' => 0,
                    'size' => 1
                ],
                'Is Active'
            );

            /**
             * Add Post_Category table
             */
            $table = $setup->getConnection()
                ->newTable($setup->getTable($postCategoryTable))
                ->addColumn('post_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    ['nullable' => false, 'unsigned' => true, 'primary' => true],
                    'Post ID')
                ->addColumn('category_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    ['nullable' => false, 'unsigned' => true, 'primary' => true],
                    'Category ID')
                ->addIndex(
                    $setup->getIdxName($postCategoryTable, ['category_id']),
                    ['category_id']
                )->addIndex(
                    $setup->getIdxName($postCategoryTable, ['post_id']),
                    ['post_id']
                )->addForeignKey(
                    $setup->getFkName(
                        $postCategoryTable,
                        'category_id',
                        $categoryTable,
                        'category_id'
                    ),
                    'category_id',
                    $setup->getTable($categoryTable),
                    'category_id',
                    \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
                )->addForeignKey(
                    $setup->getFkName(
                        $postCategoryTable,
                        'post_id',
                        $postTable,
                        'post_id'
                    ),
                    'post_id',
                    $setup->getTable($postTable),
                    'post_id',
                    \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
                )->setComment('Blog Post To Category Relation Table');


            $setup->getConnection()->createTable($table);

        }

        if (version_compare($context->getVersion(), "1.0.2", "<")) {
            $connection = $setup->getConnection();

            /**
             * Modify POST table
             */
            $connection->addColumn(
                $setup->getTable($postTable),
                'product_ids',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'comment' => 'Product related id',
                    'after' => 'category_ids',
                ]
            );
        }
    }
}
