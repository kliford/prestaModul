<?php
# /modules/statystykakoszyka/models/statystykakoszyka.php

/**
 * Statystyka Koszyka - A Prestashop Module
 * 
 * Informacja o zakupach
 * 
 * @author Ivan Bolonnyi <ivan.bolonniy@gmail.com>
 * @version 1.0.1
 */

if ( !defined('_PS_VERSION_') ) exit;

class statystykakoszykaModel extends ObjectModel
{
	/** Your fields names, adapt to your needs */
	public $id;
	public $name;
	public $value;

	/** Your table definition, adapt to your needs */
	public static $definition = [
		'table' => 'statystykakoszyka',
		'primary' => 'id',
		'fields' => [
			'name' => [
				'type' => self::TYPE_STRING,
				'validate' => 'isString',
				'size' => 256,
				'required' => true,
			],
			'value' => [
				'type' => self::TYPE_STRING,
				'validate' => 'isString',
				'size' => 256,
				'required' => true,
			]
		],
	];

	/** Create your table into database, adapt to your needs */
	public static function installSql()
	{
		$tableName = _DB_PREFIX_ . self::$definition['table'];
		$primaryField = self::$definition['primary'];

		$sql = "
			CREATE TABLE IF NOT EXISTS `{$tableName}` (
				`{$primaryField}` int(10) unsigned NOT NULL AUTO_INCREMENT,
				`name` varchar(256) NOT NULL,
				`value` varchar(256) NOT NULL,
				PRIMARY KEY (`{$primaryField}`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;
			INSERT INTO `{$tableName}` ({$primaryField}, name, value) VALUES 
			('1', 'Order', '1'),
			('2', 'Total', '1'),
			('3', 'Basket', '1'),
			('4', 'Client', '1');
		";

		return Db::getInstance()->execute($sql);
	}
	
	public static function uninstallSql()
	{
		$tableName = _DB_PREFIX_ . self::$definition['table'];
		$sql = "
		DROP TABLE `{$tableName}`
		";
		return Db::getInstance()->execute($sql);
	}
}
