<?php

/**
 * OperationsModel.php
 */

namespace App\Operations\Models;

use PiecesPHP\Core\BaseEntityMapper;

/**
 * OperationsModel.
 *
 * @package     App\Operations\Model
 * @author    Dsharp
 * @copyright   Copyright (c) 2021
 * @property int $id
 * @property string $name
 */
class OperationsModel extends BaseEntityMapper
{
	const TABLE = 'co_operations';

	/**
	 * @var string $table
	 */
	protected $table = self::TABLE;

	protected $fields = [
		'id' => [
			'type' => 'int',
			'primary_key' => true,
		],
		'category' => [
			'type' => 'int',
		],
		'description' => [
			'type' => 'varchar',
			'length' => 255,
		],
		'value' => [
			'type' => 'varchar',
			'length' => 255,
		],
		'user_id' => [
			'type' => 'int',
			'reference_table' => 'pcsphp_users',
			'reference_field' => 'id',
			'reference_primary_key' => 'id',
			'human_readable_reference_field' => 'username',
			'mapper' => UsersModel::class,
		],
		'wrote' => [
			'type' => 'datetime',
		],

	];

	/**
	 * __construct
	 *
	 * @param int $value
	 * @param string $field_compare
	 * @return static
	 */
	public function __construct(int $value = null, string $field_compare = 'primary_key')
	{
		parent::__construct($value, $field_compare);
	}

	/**
	 * @inheritDoc
	 */
	public function save()
	{

		return parent::save();
	}

	/**
	 * @inheritDoc
	 */
	public function update()
	{
		return parent::update();
	}

	/**
	 * all
	 *
	 * @param bool $as_mapper
	 *
	 * @return static[]|array
	 */
	public static function all(bool $as_mapper = false, int $page = null, int $perPage = null)
	{
		$model = self::model();

		$model->select()->execute(false, $page, $perPage);

		$result = $model->result();

		return $result;
	}

	/**
	 * getBy
	 *
	 * @param mixed $value
	 * @param string $column
	 * @return static|object|null
	 */
	public static function getBy($value, string $column = 'id')
	{
		$model = self::model();

		$where = [
			$column => $value,
		];

		$model->select()->where($where);

		$model->execute();

		$result = $model->result();

		$result = count($result) > 0 ? $result[0] : null;

		return $result;
	}

	/**
	 * getHistoryByUser
	 *
	 * @param int $user
	 * @param int $category
	 * @return static|object|null
	 */
	public static function getHistoryByUser($user, $category)
	{
		$model = self::model();

		$where = "user_id = $user ";

		if (strlen($category) > 0) {
			$where .= " AND category = $category";
		}

		$model->select()->where($where)->orderBy('wrote desc');

		$model->execute();

		$result = $model->result();

		return $result;
	}

	/**
	 * deleteOperation
	 *
	 * @param int $id
	 * @return boolean
	 */
	public static function deleteOperation($id)
	{
		$model = self::model();

		$where = "id = $id ";

		$model->delete($where);

		$result = $model->execute();

		return $result;
	}


	/**
	 * getSumByCategory
	 *
	 * @param mixed $value
	 * @param string $column
	 * @return static|object|null
	 */
	public static function getSumByCategory($category, $user)
	{
		$model = self::model();

		$where = "category = $category and user_id = $user";

		$model->select('SUM(value) as total')->where($where);

		$model->execute();

		$result = $model->result();

		$result = count($result) > 0 ? $result[0]->total : 0;

		return $result;
	}

	/**
	 * getDataForLineChart
	 *
	 * @param string $categories
	 * @param int $user
	 * @return static|object|null
	 */
	public static function getDataForLineChart($categories, $user)
	{
		$model = self::model();

		$where = "(user_id = $user and category IN ($categories)) and value >= 0";

		$model->select('sum(value) as total,wrote,category')->where($where)->groupBy('MONTH(wrote),category')->orderBy('wrote asc');

		$model->execute();

		$result = $model->result();

		return $result;
	}

	/**
	 * getAverageForLineChart
	 *
	 * @param string $categories
	 * @param int $lenght of categories
	 * @param int $user
	 * @return static|object|null
	 */
	public static function getAverageForLineChart($categories, $categories_length, $user)
	{
		$model = self::model();

		$where = "(user_id = $user and category IN ($categories)) and value >= 0";

		$model->select("sum(value)/$categories_length as total,wrote,category")->where($where)->groupBy('MONTH(wrote)')->orderBy('wrote asc');

		$model->execute();

		$result = $model->result();

		return $result;
	}

	/**
	 * model
	 *
	 * @return BaseModel
	 */
	public static function model()
	{
		return (new static())->getModel();
	}
}
