<?php

/**
 * OperationsController.php
 */

namespace App\Operations\Controllers;

use App\Controller\AdminPanelController;
use App\Model\UsersModel;
use App\Obligations\Models\ObligationsModel;
use App\Operations\Models\OperationsModel as MainMapper;
use PiecesPHP\Core\HTML\HtmlElement;
use PiecesPHP\Core\Roles;
use PiecesPHP\Core\Route;
use PiecesPHP\Core\RouteGroup;
use PiecesPHP\Core\Utilities\Helpers\DataTablesHelper;
use PiecesPHP\Core\Utilities\ReturnTypes\Operation;
use PiecesPHP\Core\Utilities\ReturnTypes\ResultOperations;
use Slim\Exception\NotFoundException;
use \Slim\Http\Request as Request;
use \Slim\Http\Response as Response;

/**
 * OperationsController.
 *
 * @package     App\Operations\Controllers
 * @author      Edgar Hdz
 * @copyright   Copyright (c) 2019
 */
class OperationsController extends AdminPanelController
{
	const FORMAT_DATETIME = 'd-m-Y h:i A';

	/**
	 * $prefixParentEntity
	 *
	 * @var string
	 */
	protected static $prefixParentEntity = 'pages';

	/**
	 * $prefixEntity
	 *
	 * @var string
	 */
	protected static $prefixEntity = 'operations';

	/**
	 * $title
	 *
	 * @var string
	 */

	protected static $title = 'Gestionar operaciones';
	/**
	 * $pluralTitle
	 *
	 * @var string
	 */
	protected static $pluralTitle = 'Gestionar operaciones';

	/**
	 * $uploadDir
	 *
	 * @var string
	 */
	protected $uploadDir = '';
	/**
	 * $uploadDir
	 *
	 * @var string
	 */
	protected $uploadTmpDir = '';
	/**
	 * $uploadDirURL
	 *
	 * @var string
	 */
	protected $uploadDirURL = '';
	/**
	 * $uploadDirTmpURL
	 *
	 * @var string
	 */
	protected $uploadDirTmpURL = '';

	/**
	 * __construct
	 *
	 * @return static
	 */
	public function __construct()
	{
		parent::__construct(false); //No cargar ningún modelo automáticamente.

		$this->model = (new MainMapper)->getModel();
		set_title(self::$title . ' - ' . get_title());
	}

	/**
	 * listView
	 *
	 * @param Request $request
	 * @param Response $response
	 * @param array $args
	 * @return void
	 */
	public function listView(Request $request, Response $response, array $args)
	{
		$process_table = self::routeName('datatables');
		$back_link = get_route('admin');

		$data = [];
		$data['process_table'] = $process_table;
		$data['back_link'] = $back_link;
		$data['title'] = self::$pluralTitle;

		$this->render('panel/layout/header');
		$this->render('panel/' . self::$prefixParentEntity . '/' . self::$prefixEntity . '/list', $data);
		$this->render('panel/layout/footer');
	}


	/**
	 * all
	 *
	 * @param Request $request
	 * @param Response $response
	 * @param array $args
	 * @return Response
	 */
	public function all(Request $request, Response $response, array $args)
	{

		if ($request->isXhr()) {

			$query = $this->model->select();

			$query->execute();

			return $response->withJson($query->result());
		} else {
			throw new NotFoundException($request, $response);
		}
	}

	/**
	 * dataTables
	 *
	 * @param Request $request
	 * @param Response $response
	 * @param array $args
	 * @return Response
	 */
	public function dataTables(Request $request, Response $response, array $args)
	{

		if ($request->isXhr()) {

			$columns_order = [
				'id',
				'category',
				'description',
				'value',
				'user_id',
				'wrote',
			];

			$result = DataTablesHelper::process([
				'columns_order' => $columns_order,
				'mapper' => new MainMapper(),
				'request' => $request,
				'on_set_data' => function ($e) {



					$mapper = new MainMapper($e->id);

					return [
						$mapper->category,
						$mapper->description,
						$mapper->value,
						$mapper->user_id->firstname,
						$mapper->wrote,
					];
				},
			]);

			return $response->withJson($result->getValues());
		} else {
			throw new NotFoundException($request, $response);
		}
	}

	/**
	 * historyByUser
	 *
	 * @param Request $request
	 * @param Response $response
	 * @param array $args
	 * @return Response
	 */
	public function historyByUser(Request $request, Response $response, array $args)
	{
		$category = $request->getParsedBodyParam('category', null);
		$current_user_id = $this->user->id;
		$res = MainMapper::getHistoryByUser($current_user_id, $category);
		return $response->withJson($res);
	}

	/**
	 * deleteOperation
	 *
	 * @param Request $request
	 * @param Response $response
	 * @param array $args
	 * @return Response
	 */
	public function deleteOperation(Request $request, Response $response, array $args)
	{
		$id = $request->getParsedBodyParam('id', null);

		$res = MainMapper::deleteOperation($id);
		return $response->withJson($res);
	}

	/**
	 * getMainValues
	 *
	 * @param Request $request
	 * @param Response $response
	 * @param array $args
	 * @return Response
	 */
	public function getMainValues(Request $request, Response $response, array $args)
	{
		$current_user_id = $this->user->id;


		$ahorro = MainMapper::getSumByCategory(AHORRO, $current_user_id);
		$entrada = MainMapper::getSumByCategory(ENTRADA, $current_user_id);
		$retiro = MainMapper::getSumByCategory(RETIRO, $current_user_id);
		$credito = MainMapper::getSumByCategory(CREDITO, $current_user_id);
		$obligaciones_por_pagar = ObligationsModel::getTotalObligations($current_user_id, true);

		$ahorro = isset($ahorro) ? $ahorro : 0;
		$entrada = isset($entrada) ? $entrada : 0;
		$retiro = isset($retiro) ? $retiro : 0;
		$credito = isset($credito) ? $credito : 0;
		$obligaciones_por_pagar = isset($obligaciones_por_pagar) ? $obligaciones_por_pagar->total : 0;

		$data['saved'] = $ahorro;
		$data['credit'] = $credito;
		$data['bank'] = $entrada - $retiro;
		$data['free'] = $data['bank'] - $credito - $obligaciones_por_pagar;

		return $response->withJson($data);
	}


	/**
	 * action
	 *
	 * Creación/Edición
	 *
	 * @param Request $request
	 * @param Response $response
	 * @param array $args
	 * @return Response
	 */
	public function action(Request $request, Response $response, array $args)
	{
		$id = $request->getParsedBodyParam('id', -1);
		$category = $request->getParsedBodyParam('category', null);
		$description = $request->getParsedBodyParam('description', null);
		$value = $request->getParsedBodyParam('value', null);
		$current_date = date(self::FORMAT_DATETIME);
		$current_user_id = $this->user->id;
		$is_edit = $id !== -1;

		$valid_params = !in_array(null, [
			$category,
			$description,
			$value,
		]);

		$operation_name = $is_edit ? 'Modificar Operacion' : 'Crear operacion';

		$result = new ResultOperations([
			new Operation($operation_name),
		], $operation_name);

		$result->setValue('redirect', false);

		$error_parameters_message = 'Los parámetros recibidos son erróneos.';
		$not_exists_message = 'La operacion que intenta modificar no existe';
		$success_create_message = 'Operacion creada.';
		$success_edit_message = 'Datos guardados.';
		$unknow_error_message = 'Ha ocurrido un error desconocido.';

		$redirect_url_on_create = self::routeName('list');

		if ($valid_params) {

			if (!$is_edit) {

				$mapper = new MainMapper();

				try {


					$mapper->category = $category;
					$mapper->description = $description;
					$mapper->value = $value;
					$mapper->user_id = $current_user_id;
					$mapper->wrote = $current_date;
					$saved = $mapper->save();

					if ($saved) {

						$result->setMessage($success_create_message)
							->operation($operation_name)
							->setSuccess(true);

						$result->setValue('redirect', true);
						$result->setValue('redirect_to', $redirect_url_on_create);
					} else {
						$result->setMessage($unknow_error_message);
					}
				} catch (\Exception $e) {
					$result->setMessage($e->getMessage());
				}
			} else {

				$mapper = new MainMapper((int) $id);
				$exists = !is_null($mapper->id);

				if ($exists) {

					try {


						$mapper->category = $category;
						$mapper->description = $description;
						$mapper->value = $value;
						$mapper->user_id = $current_user_id;
						$mapper->wrote = $current_date;

						$updated = $mapper->update();

						if ($updated) {

							$result->setValue('redirect', true);
							$result->setValue('redirect_to', $redirect_url_on_create);

							$result->setMessage($success_edit_message)
								->operation($operation_name)
								->setSuccess(true);
						} else {
							$result->setMessage($unknow_error_message);
						}
					} catch (\Exception $e) {
						$result->setMessage($e->getMessage());
					}
				} else {
					$result->setMessage($not_exists_message);
				}
			}
		} else {
			$result->setMessage($error_parameters_message);
		}

		return $response->withJson($result);
	}

	/**
	 * routeName
	 *
	 * @param string $name
	 * @param array $params
	 * @param bool $silentOnNotExists
	 * @return string
	 */
	public static function routeName(string $name = null, array $params = [], bool $silentOnNotExists = false)
	{

		if (!is_null($name)) {
			$name = trim($name);
			$name = strlen($name) > 0 ? "-{$name}" : '';
		}

		$name = !is_null($name) ? self::$prefixParentEntity . '-' . self::$prefixEntity . $name : self::$prefixParentEntity;

		$allowed = false;
		$current_user = get_config('current_user');

		if ($current_user != false) {
			$allowed = Roles::hasPermissions($name, (int) $current_user->type);
		} else {
			$allowed = true;
		}

		if ($allowed) {
			return get_route(
				$name,
				$params,
				$silentOnNotExists
			);
		} else {
			return '';
		}
	}

	/**
	 * routes
	 *
	 * @param RouteGroup $group
	 * @return RouteGroup
	 */
	public static function routes(RouteGroup $group)
	{

		$routes = [];

		$groupSegmentURL = $group->getGroupSegment();

		$lastIsBar = last_char($groupSegmentURL) == '/';
		$startRoute = $lastIsBar ? '' : '/';

		$roles_manage_permission = [
			UsersModel::TYPE_USER_ROOT,
			UsersModel::TYPE_USER_ADMIN,
			UsersModel::TYPE_USER_GENERAL,
		];

		$group->active(true);
		$group->register($routes);

		//Rutas
		$group->register(
			self::genericManageRoutes($startRoute, self::$prefixParentEntity, self::class, self::$prefixEntity, $roles_manage_permission, true)
		);

		return $group;
	}
	/**
	 * genericManageRoutes
	 *
	 * @param string $startRoute
	 * @param string $namePrefix
	 * @param string $handler
	 * @param string $uriPrefix
	 * @param array $rolesAllowed
	 * @return Route[]
	 */
	protected static function genericManageRoutes(string $startRoute, string $namePrefix, string $handler, string $uriPrefix, array $rolesAllowed = [], bool $withQuillHandler = false)
	{
		$namePrefix .= '-' . $uriPrefix;
		$startRoute .= $uriPrefix;
		$all_roles = array_keys(UsersModel::TYPES_USERS);

		$routes = [
			new Route(
				"{$startRoute}",
				"{$handler}:all",
				"{$namePrefix}-ajax-all",
				'GET'
			),
			new Route(
				"{$startRoute}/datatables[/]",
				"{$handler}:dataTables",
				"{$namePrefix}-datatables",
				'GET'
			),
			new Route(
				"{$startRoute}/list[/]",
				"{$handler}:listView",
				"{$namePrefix}-list",
				'GET',
				true,
				null,
				$rolesAllowed
			),

			new Route(
				"{$startRoute}/action/add[/]",
				"{$handler}:action",
				"{$namePrefix}-actions-add",
				'POST',
				true,
				null,
				$rolesAllowed
			),

			new Route(
				"{$startRoute}/action/edit[/]",
				"{$handler}:action",
				"{$namePrefix}-actions-edit",
				'POST',
				true,
				null,
				$rolesAllowed
			),

			new Route(
				"{$startRoute}/history[/]",
				"{$handler}:historyByUser",
				"{$namePrefix}-history",
				'POST',
				true,
				null,
				$rolesAllowed
			),

			new Route(
				"{$startRoute}/delete[/]",
				"{$handler}:deleteOperation",
				"{$namePrefix}-delete",
				'POST',
				true,
				null,
				$rolesAllowed
			),

			new Route(
				"{$startRoute}/main_values[/]",
				"{$handler}:getMainValues",
				"{$namePrefix}-main-values",
				'POST',
				true,
				null,
				$rolesAllowed
			),

		];

		return $routes;
	}
}
