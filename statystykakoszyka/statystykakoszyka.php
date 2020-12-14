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


class statystykakoszyka extends Module
{
	protected $default_order_score = 1;
	protected $default_new_client = 1;
	protected $default_basket_score = 1;
	protected $default_total_order = 1;

	public function __construct()
	{
		$this->initializeModule();
	}

	public function install()
	{
		/* Adds Module */
		if (parent::install() &&
			 $this->registerHook('displayHeader')
			&& $this->registerHook('displayLeftColumn')
			&& $this->registerHook('displayRightColumn')
			&& $this->registerHook('displayHome')
			&& $this->registerHook('displayBackOfficeHeader')
		)
		{
			$shops = Shop::getContextListShopID();
			$shop_groups_list = array();
	
			/* Setup each shop */
			foreach ($shops as $shop_id)
			{
				$shop_group_id = (int)Shop::getGroupFromShop($shop_id, true);
	
				if (!in_array($shop_group_id, $shop_groups_list))
					$shop_groups_list[] = $shop_group_id;

					/* Sets up configuration */
					$res = Configuration::updateValue('ORDER_SCORE', $this->default_order_score, false, $shop_group_id, $shop_id);
					$res &= Configuration::updateValue('NEW_CLIENT', $this->default_new_client, false, $shop_group_id, $shop_id);
					$res &= Configuration::updateValue('BASKET_SCORE', $this->default_basket_score, false, $shop_group_id, $shop_id);
					$res &= Configuration::updateValue('TOTAL_ORDER', $this->default_total_order, false, $shop_group_id, $shop_id);
				}
	
				/* Sets up Shop Group configuration */
				if (count($shop_groups_list))
				{
					foreach ($shop_groups_list as $shop_group_id)
					{
						$res = Configuration::updateValue('ORDER_SCORE', $this->default_order_score, false, $shop_group_id);
						$res &= Configuration::updateValue('NEW_CLIENT', $this->default_new_client, false, $shop_group_id);
						$res &= Configuration::updateValue('BASKET_SCORE', $this->default_basket_score, false, $shop_group_id);
						$res &= Configuration::updateValue('TOTAL_ORDER', $this->default_total_order, false, $shop_group_id);
					}
				}
	
				/* Sets up Global configuration */
				$res = Configuration::updateValue('ORDER_SCORE', $this->default_order_score);
				$res &= Configuration::updateValue('NEW_CLIENT', $this->default_new_client);
				$res &= Configuration::updateValue('BASKET_SCORE', $this->default_basket_score);
				$res &= Configuration::updateValue('TOTAL_ORDER', $this->default_total_order);
	
				// Disable on mobiles and tablets
				$this->disableDevice(Context::DEVICE_MOBILE);
	
				return (bool)$res;
			}
	
			return false;
	}

	public function uninstall()
	{
		if (parent::uninstall())
		{

			/* Unsets configuration */
			$res = Configuration::deleteByName('ORDER_SCORE');
			$res &= Configuration::deleteByName('NEW_CLIENT');
			$res &= Configuration::deleteByName('BASKET_SCORE');
			$res &= Configuration::deleteByName('TOTAL_ORDER');

			return (bool)$res;
		}

		return false;
		
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

		$this->_html .= $this->renderForm();

		if(Tools::isSubmit('submitStatystykaKoszyka')){
			$this->_postProcess();
		}

		return $this->_html;
	}

	public function renderForm()
	{
		$fields_form = array(
			'form' => array(
				'legend' => array(
					'title' => $this->l('Ustawienia'),
					'icon' => 'icon-cogs'
				),
				'input' => array(
					array(
						'type' => 'switch',
						'label' => $this->l('Pokazywać ilość zamówień'),
						'name' => 'ORDER_SCORE',
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
							),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
							)
						),
					),
					array(
						'type' => 'switch',
						'label' => $this->l('Pokazywać kwotę zamówień'),
						'name' => 'TOTAL_ORDER',
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
							),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
							)
						),
					),
					array(
						'type' => 'switch',
						'label' => $this->l('Pokazywać ilość koszyków'),
						'name' => 'BASKET_SCORE',
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
							),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
							)
						),
					),
					array(
						'type' => 'switch',
						'label' => $this->l('Pokazywać nowych klientów'),
						'name' => 'NEW_CLIENT',
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
							),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
							)
						),
					),
				),
				'submit' => array(
					'title' => $this->l('Save'),
				)
			),
		);

		$helper = new HelperForm();
		$helper->show_toolbar = false;
		$helper->table =  $this->table;
		$lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
		$helper->default_form_language = $lang->id;
		$helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
		$this->fields_form = array();
		
		$helper->identifier = $this->identifier;
		$helper->submit_action = 'submitStatystykaKoszyka';
		$helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$helper->tpl_vars = array(
			'fields_value' => $this->getConfigFieldsValues(),
			'languages' => $this->context->controller->getLanguages(),
			'id_language' => $this->context->language->id
		);

		return $helper->generateForm(array($fields_form));
	}

	public function getConfigFieldsValues()
	{
		$id_shop_group = Shop::getContextShopGroupID();
		$id_shop = Shop::getContextShopID();

		return array(
			'ORDER_SCORE' => Tools::getValue('ORDER_SCORE', Configuration::get('ORDER_SCORE', null, $id_shop_group, $id_shop)),
			'NEW_CLIENT' => Tools::getValue('NEW_CLIENT', Configuration::get('NEW_CLIENT', null, $id_shop_group, $id_shop)),
			'BASKET_SCORE' => Tools::getValue('BASKET_SCORE', Configuration::get('BASKET_SCORE', null, $id_shop_group, $id_shop)),
			'TOTAL_ORDER' => Tools::getValue('TOTAL_ORDER', Configuration::get('TOTAL_ORDER', null, $id_shop_group, $id_shop)),
		);

	}


	protected function _postProcess()
	{
		$shop_group_list = array();
		$shop = Shop::getContextListShopID();

		foreach ($shop as $shop_id)
		{
			$shop_group_id = (int)Shop::getGroupFromShop($shop_id, true);

			if (!in_array($shop_group_id, $shop_group_list))
				$shop_group_list[] = $shop_group_id;

			$res = Configuration::updateValue('ORDER_SCORE', (int)Tools::getVAlue('ORDER_SCORE'), false, $shop_group_id, $shop_id);
			$res = Configuration::updateValue('NEW_CLIENT', (int)Tools::getVAlue('NEW_CLIENT'), false, $shop_group_id, $shop_id);
			$res = Configuration::updateValue('BASKET_SCORE', (int)Tools::getVAlue('BASKET_SCORE'), false, $shop_group_id, $shop_id);
			$res = Configuration::updateValue('TOTAL_ORDER', (int)Tools::getVAlue('TOTAL_ORDER'), false, $shop_group_id, $shop_id);

		}

		/* Update global shop context if needed */

			$res = Configuration::updateValue('ORDER_SCORE', (int)Tools::getVAlue('ORDER_SCORE'));
			$res &= Configuration::updateValue('NEW_CLIENT', (int)Tools::getVAlue('NEW_CLIENT'));
			$res &= Configuration::updateValue('BASKET_SCORE', (int)Tools::getVAlue('BASKET_SCORE'));
			$res &= Configuration::updateValue('TOTAL_ORDER', (int)Tools::getVAlue('TOTAL_ORDER')); 

	}

	public function hookDisplayHome($params)
	{	

		$this->getValueConfiguration();

		return $this->display(__FILE__, 'statystykakoszyka-page.tpl');
	}

	public function hookDisplayLeftColumn($params)
	{
		$this->getValueConfiguration();
		
		return $this->display(__FILE__, 'statystykakoszyka-page-column.tpl');
	}

	public function hookDisplayRightColumn($params)
	{

		$this->getValueConfiguration();
		
		return $this->display(__FILE__, 'statystykakoszyka-page-column.tpl');
	}

	public function getValueConfiguration()
	{		
		$todayFrom = date('Y-m-d') . ' 00:00:00';
		$todayTo = date('Y-m-d') . ' 23:59:59';

		$new_customers = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue('
			SELECT COUNT(*)
			FROM `'._DB_PREFIX_.'customer`
			WHERE `date_add` BETWEEN "'.pSQL($todayFrom).'" AND "'.pSQL($todayTo).'"
			'.Shop::addSqlRestriction(Shop::SHARE_ORDER)
		);

		$new_cart = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue('
			SELECT COUNT(*)
			FROM `'._DB_PREFIX_.'cart`
			WHERE `date_add` BETWEEN "'.pSQL($todayFrom).'" AND "'.pSQL($todayTo).'"
			'.Shop::addSqlRestriction(Shop::SHARE_ORDER)
		);

		$new_order = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue('
			SELECT COUNT(*)
			FROM `'._DB_PREFIX_.'orders`
			WHERE `date_add` BETWEEN "'.pSQL($todayFrom).'" AND "'.pSQL($todayTo).'"
			AND current_state = 2
			'.Shop::addSqlRestriction(Shop::SHARE_ORDER)
		);

		$new_total = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue('
			SELECT SUM(total_paid)
			FROM `'._DB_PREFIX_.'orders`
			WHERE `date_add` BETWEEN "'.pSQL($todayFrom).'" AND "'.pSQL($todayTo).'"
			AND current_state = 2
			'.Shop::addSqlRestriction(Shop::SHARE_ORDER)
		);

		$id_currency_active = $this->context->currency->sign;

		$new_currency = $this->context->currency->conversion_rate;

		$new_total_paid = $new_total * $new_currency;

		$this->context->smarty->assign(
			array(
				'order_value' => (int)Configuration::get('ORDER_SCORE', (int)Tools::getVAlue('ORDER_SCORE')),
				'client_value' => (int)Configuration::get('NEW_CLIENT', (int)Tools::getVAlue('NEW_CLIENT')),
				'basket_value' => (int)Configuration::get('BASKET_SCORE', (int)Tools::getVAlue('BASKET_SCORE')),
				'total_value' => (int)Configuration::get('TOTAL_ORDER', (int)Tools::getVAlue('TOTAL_ORDER')),
				'new_customer' => $new_customers,
				'new_cart' => $new_cart,
				'new_order' => $new_order,
				'new_total_paid' => $new_total_paid,
				'currency_shop' => $id_currency_active
			)
		);
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
