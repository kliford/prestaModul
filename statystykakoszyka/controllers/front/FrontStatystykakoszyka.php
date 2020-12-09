<?php
# /modules/statystykakoszyka/controllers/front/.php

/**
 * Statystyka Koszyka - A Prestashop Module
 * 
 * Informacja o zakupach
 * 
 * @author Ivan Bolonnyi <ivan.bolonniy@gmail.com>
 * @version 1.0.1
 */

if ( !defined('_PS_VERSION_') ) exit;

// You can now access this controller from /index.php?fc=module&module=statystykakoszyka&controller=
class statystykakoszykaModuleFrontController extends ModuleFrontController
{
	public function __construct()
	{
		parent::__construct();
		// Do your stuff here
	}

	public function initContent()
	{

		$this->setTemplate('statystykakoszyka-page.tpl');

		parent::initContent();
	}
}
