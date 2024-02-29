<?php

namespace AndrewAvelonetwork\AvelonNetworkAffiliateMarketing\Setup;

use Psr\Log\LoggerInterface;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $this->logger->debug('InstallSchema.php execution started.');
        $installer = $setup;
        $installer->startSetup();
        $tableName = $installer->getTable('avelon_settings');
        if ($installer->getConnection()->isTableExists($tableName) != true) {
            $table = $installer->getConnection()
                ->newTable($tableName)
                ->addColumn(
                    'id',
                    Table::TYPE_INTEGER,
                    null,
                    ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                    'ID'
                )
                ->addColumn(
                    'avelon_account_id',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false],
                    'Avelon Account ID'
                )
                ->addColumn(
                    'avelon_api_token',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false],
                    'Avelon API Token'
                )
                ->setComment('Avelon Settings Table')
                ->setOption('type', 'InnoDB') // Setting table type to InnoDB
                ->setOption('charset', 'utf8'); // Setting table character set to utf8
            $installer->getConnection()->createTable($table);
        }
        $installer->endSetup();

        $this->logger->debug('InstallSchema.php execution completed.');
    }
}