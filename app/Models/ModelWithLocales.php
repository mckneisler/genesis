<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Locales;
use App\Models\Code;

abstract class ModelWithLocales extends Model
{

	/**
	 * Class name for the locale model
	 *
	 * @var string
	 */
	protected $localeClass;

	/**
	 * After the parent is constructed, set the class name
	 * for the locale model
	 *
	 * @param array   $attributes
	 *
     * @return void
	 */
	public function __construct(array $attributes = [])
	{
		parent::__construct($attributes);

		$this->localeClass = get_class($this) . 'Locale';
	}

	/**
	 * Relationship to the locale model
	 *
     * @return hasMany
	 */
	public function locales()
	{
		return $this->hasMany($this->localeClass, 'model_id');
	}

	/**
	 * Scope to return the locale values
	 *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @param  array   $requestedColumns
     * @param  string  $relationship
     * @param  string  $locale
     * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeLocale($query, array $requestedColumns = [], $locale = null)
	{
		// Get the locale table name
		$table = $this->getTable();
		$tableId = $this->getKeyName();
		$localeTable = rtrim($table, 's') . '_locales';
		$localeParentId = 'model_id';

		$query = Locales::addScope($query, $table, $tableId, $localeTable, $localeParentId, $requestedColumns, $locale);

		return $query;
	}

	/**
	 * After creating the parent model, create multiple locale models
	 *
	 * @param  array   $attributes
     * @return static
	 */
	public static function create(array $attributes = [])
	{
		// Remove the locale entries and create the parent model
		$parentAttributes = array_filter($attributes, function($value){
			return ! is_array($value);
		});
		$model = parent::create($parentAttributes);

		// Create the locale models
		$localeClass = $model->localeClass;
		$locales = [];
		foreach ($attributes as $locale => $fields) {
			if (is_array($fields)) {
				if (is_string($locale)) {
					$locale_id = Code::getCodeId('locales', $locale);
				} else {
					$locale_id = $locale;
				}
				if ($locale_id) {
					$fields['locale_id'] = $locale_id;
					$locales[] = $fields;
				}
			}
		}

		if (count($locales)) {
			$model->locales()->createMany($locales);
		}

		return $model;
	}
}
