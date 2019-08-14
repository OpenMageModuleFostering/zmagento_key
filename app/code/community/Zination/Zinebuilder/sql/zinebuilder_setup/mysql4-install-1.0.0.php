<?php
//echo 'Running This Upgrade: ' . get_class($this) . '\n <br/> \n' ;
//die('Exit For Now') ;
Mage::log('Module Zinebuilder Install', null, 'zinebuilder.log') ;
$installer = $this ;
$installer -> startSetup() ;

Mage::log('Create new table `zinebuilder`', null, 'zinebuilder.log') ;
$table = $installer -> getConnection() -> newTable($installer->getTable('zinebuilder/zinebuilder'))
        -> addColumn('zinebuilder_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'unsigned' => true,
        'nullable' => false,
        'primary' => true,
        'identity' => true,
        ), 'Zinebuilder ID')
        -> addColumn('title', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable' => true,
        ), 'Zinebuilder Title')
        -> addColumn('z_app_id', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => false,
        ), 'Zinebuilder App ID')
        -> addColumn('z_user_token', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable' => true,
        ), 'Zinebuilder User Token')
        -> addColumn('created', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
        ), 'Created Date')
        -> addColumn('updated', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
        ), 'Updated Date')
        -> addColumn('verified', Varien_Db_Ddl_Table::TYPE_BOOLEAN, null, array(
        'default' => false,
        ), 'Verified')
        -> setComment('Zination Zinebuilder App Table');

$installer -> getConnection() -> createTable($table) ;
Mage::log("Table created completely", null, 'zinebuilder.log') ;

$installer -> endSetup() ;
?>
