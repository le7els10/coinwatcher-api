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
			'type' => 'varchar',
			'length' => 255,
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
	 * model
	 *
	 * @return BaseModel
	 */
	public static function model()
	{
		return (new static())->getModel();
	}
}
