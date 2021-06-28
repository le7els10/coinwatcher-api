<?php

/**
 * SubCategoryMapper.php
 */

namespace PiecesPHP\BuiltIn\Shop\SubCategory\Mappers;

use PiecesPHP\BuiltIn\Shop\Category\Mappers\CategoryMapper;
use PiecesPHP\Core\BaseModel;
use PiecesPHP\Core\Database\EntityMapperExtensible;

/**
 * SubCategoryMapper.
 *
 * @package     PiecesPHP\BuiltIn\Shop\SubCategory\Mappers
 * @author      Vicsen Morantes <sir.vamb@gmail.com>
 * @copyright   Copyright (c) 2020
 * @property int $id
 * @property int|CategoryMapper $category
 * @property string $name
 * @property string $description
 * @property string $image
 * @property \stdClass|string|null $meta
 */
class SubCategoryMapper extends EntityMapperExtensible
{

    protected $fields = [
        'id' => [
            'type' => 'int',
            'primary_key' => true,
        ],
        'category' => [
            'type' => 'int',
            'reference_table' => CategoryMapper::TABLE,
            'reference_field' => 'id',
            'reference_primary_key' => 'id',
            'human_readable_reference_field' => 'id',
            'mapper' => CategoryMapper::class,
        ],
        'name' => [
            'type' => 'text',
        ],
        'description' => [
            'type' => 'text',
            'null' => true,
            'dafault' => '',
        ],
        'image' => [
            'type' => 'text',
        ],
        'meta' => [
            'type' => 'json',
            'null' => true,
            'dafault' => null,
        ],
    ];

    const TABLE = 'pcsphp_shop_subcategories';
    const LANG_GROUP = 'bi-shop-categories';

    /**
     * $table
     *
     * @var string
     */
    protected $table = self::TABLE;

    /**
     * __construct
     *
     * @param int $value
     * @param string $fieldCompare
     * @return static
     */
    public function __construct(int $value = null, string $fieldCompare = 'primary_key')
    {
        parent::__construct($value, $fieldCompare);
    }

    /**
     * all
     *
     * @param bool $asMapper
     *
     * @return static[]|array
     */
    public static function all(bool $asMapper = false)
    {
        $model = self::model();

        $model->select()->execute();

        $result = $model->result();

        if ($asMapper) {
            $result = array_map(function ($e) {
                return new static($e->id);
            }, $result);
        }

        return $result;
    }

    /**
     * allByCategory
     *
     * @param int $categoryID
     * @param bool $asMapper
     *
     * @return static[]|array
     */
    public static function allByCategory(int $categoryID, bool $asMapper = false)
    {
        $model = self::model();

        $model->select()->where([
            'category' => $categoryID,
        ])->execute();

        $result = $model->result();

        if ($asMapper) {
            $result = array_map(function ($e) {
                return new static($e->id);
            }, $result);
        }

        return $result;
    }

    /**
     * allBy
     *
     * @param string $column
     * @param int $value
     * @param bool $asMapper
     *
     * @return static[]|array
     */
    public static function allBy(string $column, $value, bool $asMapper = false)
    {
        $model = self::model();

        $model->select()->where([
            $column => $value,
        ])->execute();

        $result = $model->result();

        if ($asMapper) {
            $result = array_map(function ($e) {
                return new static($e->id);
            }, $result);
        }

        return $result;
    }

    /**
     * getBy
     *
     * @param mixed $value
     * @param string $column
     * @param boolean $as_mapper
     * @return static|object|null
     */
    public static function getBy($value, string $column = 'id', bool $as_mapper = false)
    {
        $model = self::model();

        $where = [
            $column => $value,
        ];

        $model->select()->where($where);

        $model->execute();

        $result = $model->result();

        $result = count($result) > 0 ? $result[0] : null;

        if (!is_null($result) && $as_mapper) {
            $result = new static($result->id);
        }

        return $result;
    }

    /**
     * allForSelect
     *
     * @param string $defaultLabel
     * @param string $defaultValue
     * @return array
     */
    public static function allForSelect(string $defaultLabel = '', string $defaultValue = '')
    {
        $defaultLabel = strlen($defaultLabel) > 0 ? $defaultLabel : __(self::LANG_GROUP, 'Subcategorías');
        $options = [];
        $options[$defaultValue] = $defaultLabel;

        array_map(function ($e) use (&$options) {

            $value = $e->name;
            $options[$e->id] = $value;

        }, self::all());

        return $options;
    }

    /**
     * existsByID
     *
     * @param int $id
     * @return bool
     */
    public static function existsByID(int $id)
    {
        $model = self::model();

        $where = [
            "id = $id",
        ];
        $where = trim(implode(' ', $where));

        $model->select()->where($where);

        $model->execute();

        $result = $model->result();

        return count($result) > 0;
    }

    /**
     * isDuplicate
     *
     * @param string $name
     * @param int $categoryID
     * @param int $ignoreID
     * @return bool
     */
    public static function isDuplicate(string $name, int $categoryID, int $ignoreID)
    {
        $model = self::model();

        $name = \addslashes(\stripslashes($name));

        $where = [
            "name = '$name'",
            "AND category = $categoryID",
            "AND id != $ignoreID",
        ];
        $where = trim(implode(' ', $where));

        $model->select()->where($where);

        $model->execute();

        $result = $model->result();

        return count($result) > 0;
    }

    /**
     * model
     *
     * @return BaseModel
     */
    public static function model()
    {
        return (new static )->getModel();
    }
}
