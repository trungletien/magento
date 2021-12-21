<?php
namespace Mageplaza\HelloWorld\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade( SchemaSetupInterface $setup, ModuleContextInterface $context ) {
        $installer = $setup;

        $installer->startSetup();
        if(version_compare($context->getVersion(), '1.4.0', '<')) {
            if (!$installer->tableExists('banner')) {
                $table = $installer->getConnection()->newTable(
                    $installer->getTable('banner')
                )
                    ->addColumn(
                        'banner_id',
                        \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                        null,
                        [
                            'identity' => true,
                            'nullable' => false,
                            'primary' => true,
                            'unsigned' => true,
                        ],
                        'Banner ID'
                    )
                    ->addColumn(
                        'name',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        255,
                        ['nullable => false'],
                        'Banner Name'
                    )
                    ->addColumn(
                        'description',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        255,
                        [],
                        'Banner Description'
                    )
                    ->addColumn(
                        'image',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        '64k',
                        [],
                        'Banner Image'
                    )
                    ->addColumn(
                        'status',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        255,
                        [],
                        'Banner Status'
                    )
                    ->addColumn(
                        'created_at',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                        null,
                        ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                        'Created At'
                    )->addColumn(
                        'updated_at',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                        null,
                        ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
                        'Updated At')
                    ->setComment('Banner Table');
                $installer->getConnection()->createTable($table);

//            $installer->getConnection()->addIndex(
//                $installer->getTable('banner'),
//                $setup->getIdxName(
//                    $installer->getTable('banner'),
//                    ['name','url_key','post_content','tags','featured_image'],
//                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
//                ),
//                ['name','url_key','post_content','tags','featured_image'],
//                \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
//            );
            }
        }

        $installer->endSetup();
    }
}
