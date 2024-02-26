<?php

namespace Avelon\AvelonNetwork\Setup;
 
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Customer\Model\Customer;
use Magento\Customer\Setup\CustomerSetupFactory;
 
class InstallData implements InstallDataInterface
{
 
    private $customerSetupFactory;
 
    /**
     * Constructor
     *
     * @param \Magento\Customer\Setup\CustomerSetupFactory $customerSetupFactory
     */
    public function __construct(
        CustomerSetupFactory $customerSetupFactory
    ) {
        $this->customerSetupFactory = $customerSetupFactory;
    }
 
    /**
     * {@inheritdoc}
     */
    public function install(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $installer = $setup;
 
        $installer->startSetup();
 
        $installer->getConnection()->addColumn(
            $installer->getTable('quote'),
            'avln_cid',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'visible'  => true,
                'default' => 0,
                'comment' => 'Avelon Cid'
            ]
        );
 
 
        $installer->getConnection()->addColumn(
            $installer->getTable('sales_order'),
            'avln_cid',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'visible'  => true,
                'default' => 0,
                'comment' => 'Avelon Cid'
            ]
        );
    }
}