<?php
# /modules/statystykakoszyka/controllers/admin/AdminStatystykaKoszyka.php

/**
 * Statystyka Koszyka - A Prestashop Module
 * 
 * Informacja o zakupach
 * 
 * @author Ivan Bolonnyi <ivan.bolonniy@gmail.com>
 * @version 1.0.1
 */

if ( !defined('_PS_VERSION_') ) exit;

// You can now access this controller from /your_admin_directory/index.php?controller=AdminStatystykaKoszyka
class AdminStatystykaKoszykaController extends ModuleAdminController
{
	public function __construct()
	{
		parent::__construct();
		// Do your stuff here
	}

	public function renderList()
	{
		$html = $this->setTemplate('statystykakoszyka-admin.tpl');
		
		$list = parent::renderList();
		
		// You can create your custom HTML with smarty or whatever then concatenate your list to it and serve it however you want !
		return $html . $list;
	}
}
