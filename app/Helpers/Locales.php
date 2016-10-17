<?php

namespace App\Helpers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Code;

class Locales
{
	/**
	 * Scope to return the locale values
	 *
	 * The return query will contain three versions of the locale model
	 *   1) Attributes prefaced with loc_ will be from the requested locale (application locale by default)
	 *   2) Attributes prefaced with def_ will be from the fallback locale
	 *   3) Attributes with no preface will be
	 *      a) the requested locale value if it exists
	 *      b) the fallback locale value if the requested lacale does not exist
	 *      c) the code name from the parent model if neither exist
	 *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @param  string  $table				Table name of the table needing to resolve locales
     * @param  string  $tableId				Column name on the $table which is a foreign key to the locale table
     * @param  string  $localeTable			Table nome of the table containing the locale information
     * @param  string  $localeParentId		Column name on the locale table which is the foreign back to its parent table
     * @param  array   $requestedColumns	Array of column names from the locale table
     * @param  string  $relationship		Relationship name
     * @param  string  $locale				Code of the requested locale
	 *
     * @return \Illuminate\Database\Eloquent\Builder
	 */
	public static function addScope($query, $table, $tableId, $localeTable, $localeParentId, array $requestedColumns = [], $locale = null, $relationship = null, $parentId = null)
	{
		if ( ! Schema::hasTable('codes')) {
			return $query;
		}
		// Only return columns requested
		$checkColumns = $requestedColumns;

		// Get the fallback locale id
		$fallbackId = Code::getCodeId('locales', config('app.fallback_locale'));

		// Code table name is the parent table or the relatiionship if it exists
		$codeTable = $relationship ? $relationship : $table;

		// Get the requested locale id
		// Default is the application locale
		if (is_null($locale)) {
			$localeId = Code::getCodeId('locales', App::getLocale());
		} else {
			if (is_string($locale)) {
				$localeId = Code::getCodeId('locales', $locale);
			} else {
				$localeId = $locale;
			}
		}

		// Add the locale columns to the select clause
		$localeColumns = Schema::getColumnListing($localeTable);
		if ( ! count($requestedColumns)) {
			$checkColumns = $localeColumns;
		}
		$locPrefix = 'loc';
		$defPrefix = 'def';
		if ($relationship) {
			$locPrefix = $relationship . '_' . $locPrefix;
			$defPrefix = $relationship . '_' . $defPrefix;
		}
		$selectColumns = [];
		foreach ($localeColumns as $localeColumn) {
			if (in_array($localeColumn, $checkColumns)) {
				$columnName = $localeColumn;
				if ($relationship) {
					$columnName = $relationship . '_' . $columnName;
				}
				$selectColumns[] = $locPrefix . '.' . $localeColumn . ' as ' . $locPrefix . '_'. $localeColumn;
				$selectColumns[] = $defPrefix . '.' . $localeColumn . ' as ' . $defPrefix . '_'. $localeColumn;
				if ($localeColumn == 'name') {
					$selectColumns[] = DB::Raw('IFNULL(IFNULL(`' . $locPrefix . '`.`' . $localeColumn . '` , `' . $defPrefix . '`.`' . $localeColumn . '`), `' . $codeTable . '`.`code`) as ' . $columnName);
				} else {
					$selectColumns[] = DB::Raw('IFNULL(`' . $locPrefix . '`.`' . $localeColumn . '` , `' . $defPrefix . '`.`' . $localeColumn . '`) as ' . $columnName);
				}
			}
		}
		if (count($selectColumns)) {
			$query->addSelect($selectColumns);
		}

		// Join to the parent table when a relationship is used
		if ($relationship) {
			$tableNodes = explode('_', $localeTable);
			unset($tableNodes[count($tableNodes) - 1]);
			$parentTable = implode('_', $tableNodes) . 's';

			$parentColumns = Schema::getColumnListing($parentTable);
			if ( ! count($requestedColumns)) {
				$checkColumns = $parentColumns;
			}

			$selectColumns = [];
			foreach ($parentColumns as $parentColumn) {
				if (in_array($parentColumn, $checkColumns)) {
					$selectColumns[] = $relationship . '.' . $parentColumn . ' as ' . $relationship . '_'. $parentColumn;
				}
			}
			if (count($selectColumns)) {
				$query->addSelect($selectColumns);
			}

			$query->leftJoin($parentTable . ' as ' . $relationship, function($join) use ($tableId, $relationship, $parentId) {
				$join->on($tableId, '=', $relationship . '.' . $parentId);
			});
		}

		// Join to the locale table with the requested locale
		$query->leftJoin($localeTable . ' as ' . $locPrefix, function($join) use ($localeId, $locPrefix, $tableId, $localeParentId) {
			$join->on($tableId, '=', $locPrefix . '.' . $localeParentId)->where($locPrefix .'.locale_id', '=', $localeId);
		});

		// Join to the locale table with the fallback locale
		$query->leftJoin($localeTable . ' as ' . $defPrefix, function($join) use ($fallbackId, $defPrefix, $tableId, $localeParentId) {
			$join->on($tableId, '=', $defPrefix .'.' . $localeParentId)->where($defPrefix .'.locale_id', '=', $fallbackId);
		});

		return $query;
	}
}
