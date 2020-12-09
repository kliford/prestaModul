<?php
# /modules/statystykakoszyka/statystykakoszyka.php

/**
 * Statystyka Koszyka - A Prestashop Module
 * 
 * Informacja o zakupach
 * 
 * @author Ivan Bolonnyi <ivan.bolonniy@gmail.com>
 * @version 1.0.1
 */

if ( !defined('_PS_VERSION_') ) exit;

// We look for our model since we want to install it's SQL from the module install
require_once(__DIR__ . '/models/statystykakoszyka.php');

class statystykakoszyka extends Module
{
	const DEFAULT_CONFIGURATION = [
		// Put your default configuration here, e.g :
		// 'STATYSTYKAKOSZYKA_BACKGROUND_COLOR' => '#eee',
	];

	public function __construct()
	{
		$this->initializeModule();
	}

	public function install()
	{

		return
			parent::install()
			&& $this->installTab()
			&& $this->initDefaultConfigurationValues()
			&& $this->registerHook('displayHeader')
			&& $this->registerHook('displayLeftColumn')
			&& $this->registerHook('displayRightColumn')
			&& $this->registerHook('displayHome')
			&& $this->registerHook('displayBackOfficeHeader')
			&& statystykakoszykaModel::installSql()
		;
	}

	public function uninstall()
	{

		return
			parent::uninstall()
			&& $this->uninstallTab()
			&& $this->unregisterHook('displayHome')
			&& $this->unregisterHook('displayLeftColumn')
			&& $this->unregisterHook('displayRightColumn')
			&& $this->unregisterHook('displayHeader')
			&& $this->unregisterHook('displayBackOfficeHeader')
			&& statystykakoszykaModel::uninstallSql()
		;
		
	}
	
	public function hookDisplayBackOfficeHeader()
	{
		$this->context->controller->addCss($this->_path . 'views/css/statystykakoszyka.css', 'all');
	}
	
	public function hookDisplayHeader($params)
	{
		$this->context->controller->addCss($this->_path . 'views/css/statystykakoszyka.css', 'all');
		$this->context->controller->addJS(($this->_path) . 'views/js/CountUp.js');
		$this->context->controller->addJS(($this->_path) . 'views/js/script.js');

	}
		
	/** Module configuration page */
	public function getContent()
	{
		return $this->display(__FILE__, 'statystykakoszyka-admin.tpl');
	}
	public function hookDisplayHome($params)
	{
		return $this->display(__FILE__, 'statystykakoszyka-page.tpl');
	}

	public function hookDisplayLeftColumn($params)
	{
		return $this->display(__FILE__, 'statystykakoszyka-page-column.tpl');
	}

	public function hookDisplayRightColumn($params)
	{
		return $this->display(__FILE__, 'statystykakoszyka-page-column.tpl');
	}

	/** Initialize the module declaration */
	private function initializeModule()
	{
		$this->name = 'statystykakoszyka';
		$this->tab = 'administration';
		$this->version = '1.0.1';
		$this->author = 'Ivan Bolonnyi';
		$this->need_instance = 1;
		$this->ps_versions_compliancy = [
			'min' => '1.6',
			'max' => _PS_VERSION_,
		];
		$this->bootstrap = true;
		
		parent::__construct();

		$this->displayName = $this->l('Statystyka Koszyka');
		$this->description = $this->l('Informacja o zakupach');
		$this->confirmUninstall = $this->l('Czy na pewno chcesz odinstalować ten moduł?');
	}

	/** Set module default configuration into database */
	private function initDefaultConfigurationValues()
	{
		foreach ( self::DEFAULT_CONFIGURATION as $key => $value )
		{
			if ( !Configuration::get($key) )
			{
				Configuration::updateValue($key, $value);
			}
		}

		return true;
	}

	/** Install module tab, to your admin controller */
	private function installTab()
	{
		$languages = Language::getLanguages();
		
		$tab = new Tab();
		$tab->class_name = 'AdminStatystykaKoszyka';
		$tab->module = $this->name;
		$tab->id_parent = (int) Tab::getIdFromClassName('DEFAULT');

		foreach ( $languages as $lang )
		{
			$tab->name[$lang['id_lang']] = 'Statystyka Koszyka';
		}

		try
		{
			$tab->save();
		}
		catch ( Exception $e )
		{
			return false;
		}

		return true;
	}

	/** Uninstall module tab */
	private function uninstallTab()
	{
		$tab = (int) Tab::getIdFromClassName('AdminStatystykaKoszyka');

		if ( $tab )
		{
			$mainTab = new Tab($tab);
			
			try
			{
				$mainTab->delete();
			}
			catch ( Exception $e )
			{
				echo $e->getMessage();
				return false;
			}
		}

		return true;
	}
}
