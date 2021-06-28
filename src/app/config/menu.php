<?php

/**
 * menu.php
 */

/**
 * Menús.
 * En este este archivo se pueden definir elementos útiles para generar menús
 */

use App\Operations\Controllers\OperationsController;
use PiecesPHP\Core\Menu\MenuGroup;
use PiecesPHP\Core\Menu\MenuGroupCollection;
use PiecesPHP\Core\Menu\MenuItemCollection;
use PiecesPHP\Core\Roles;

$role = Roles::getCurrentRole();
$current_type_user = !is_null($role) ? $role['code'] : null;

$config['menus']['header_dropdown'] = new MenuItemCollection([
	'items' => [],
]);

$config['menus']['sidebar'] = new MenuGroupCollection([
	'items' => [
		new MenuGroup([
			'name' => __('sidebarAdminZone', 'Inicio'),
			'icon' => 'home',
			'visible' => Roles::hasPermissions('admin', $current_type_user),
			'asLink' => true,
			'href' => get_route('admin'),
		]),
		new MenuGroup([
			'name' => 'Operaciones',
			'icon' => 'user',
			'visible' => Roles::hasPermissions('pages-operations-list', $current_type_user),
			'asLink' => true,
			'href' => get_route('pages-operations-list', [], true),
		]),
		new MenuGroup([
			'name' => __('sidebarAdminZone', 'Gestionar usuarios'),
			'icon' => 'user',
			'visible' => Roles::hasPermissions('users-list', $current_type_user),
			'asLink' => true,
			'href' => get_route('users-list'),
		]),
		new MenuGroup([
			'name' => __('sidebarAdminZone', 'Informes de ingreso'),
			'icon' => 'file',
			'visible' => Roles::hasPermissions('informes-acceso', $current_type_user),
			'asLink' => true,
			'href' => get_route('informes-acceso'),
		]),
		new MenuGroup([
			'name' => __('sidebarAdminZone', 'Importar usuarios'),
			'icon' => 'upload',
			'visible' => Roles::hasPermissions('importer-form', $current_type_user),
			'asLink' => true,
			'href' => get_route('importer-form', ['type' => 'users'], true),
		]),

		new MenuGroup([
			'name' => __('sidebarAdminZone', 'Opciones de usuario'),
			'icon' => 'user cog',
			'visible' => true,
			'asLink' => true,
			'href' => get_route('users-form-profile'),
		]),
		new MenuGroup([
			'name' => __('sidebarAdminZone', 'Personalización'),
			'icon' => 'pencil alternate',
			'visible' => Roles::hasPermissions('configurations-customization', $current_type_user),
			'asLink' => true,
			'href' => get_route('configurations-customization', [], true),
		]),
		new MenuGroup([
			'name' => __('sidebarAdminZone', 'Configuraciones'),
			'icon' => 'cogs',
			'visible' => Roles::hasPermissions('configurations-generals', $current_type_user),
			'asLink' => true,
			'href' => get_route('configurations-generals', [], true),
		]),
		new MenuGroup([
			'name' => __('sidebarAdminZone', 'Log de errores'),
			'icon' => 'file alternate outline',
			'visible' => Roles::hasPermissions('admin-error-log', $current_type_user),
			'asLink' => true,
			'href' => get_route('admin-error-log'),
		]),


		new MenuGroup([
			'name' => __('sidebarAdminZone', 'Cerrar sesión'),
			'icon' => 'share',
			'visible' => true,
			'asLink' => false,
			'attributes' => [
				'pcsphp-users-logout' => '',
			],
		]),
	],
]);
