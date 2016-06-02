<?php

namespace JakeSharp\Productslider\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * Class UpgradeSchema
 * @package JakeSharp\Productslider\Setup
 */
class UpgradeSchema implements UpgradeSchemaInterface
{
    const TABLE_NAME = 'js_productslider';

    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if(version_compare($context->getVersion(), '1.1.2', '<')){
            $this->addDisplayPrice($setup);
        }

        if(version_compare($context->getVersion(), '1.1.3', '<')){
            $this->addProductsNumber($setup);
        }

        $setup->endSetup();
    }

    /**
     * @param SchemaSetupInterface $setup
     */
    private function addDisplayPrice(SchemaSetupInterface $setup)
    {
        $setup->getConnection()->addColumn(
            $setup->getTable(self::TABLE_NAME),
            'display_price',
            [   'type' => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                'unsigned' => true,
                'nullable' => false,
                'default' => 1,
                'comment' => 'Display product price'
            ]);
        $setup->getConnection()->addColumn(
            $setup->getTable(self::TABLE_NAME),
            'display_cart',
            [   'type' => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                'unsigned' => true,
                'nullable' => false,
                'default' => 1,
                'comment' => 'Display add to cart button'
            ]);

        $setup->getConnection()->addColumn(
            $setup->getTable(self::TABLE_NAME),
            'display_wishlist',
            [   'type' => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                'unsigned' => true,
                'nullable' => false,
                'default' => 1,
                'comment' => 'Display add to wish list'
            ]);

        $setup->getConnection()->addColumn(
            $setup->getTable(self::TABLE_NAME),
            'display_compare',
            [   'type' => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                'unsigned' => true,
                'nullable' => false,
                'default' => 1,
                'comment' => 'Display add to compare'
            ]);

    }

    private function addProductsNumber(SchemaSetupInterface $setup)
    {
        $setup->getConnection()->addColumn(
            $setup->getTable(self::TABLE_NAME),
            'products_number',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                'unsigned' => true,
                'comment' => 'Number of products in slider'
            ]);
    }

}