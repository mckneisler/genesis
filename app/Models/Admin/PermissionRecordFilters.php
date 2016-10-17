<?php

namespace App\Models\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

use App\Models\QueryFilter;

class PermissionRecordFilters extends QueryFilter
{
	public function search($string) {
		$name = $this->getObjectCode();
		if ($name == 'codes') {
			$type = 'code';
		} else {
			$type = isTableOrCode($name);
		}

		switch ($type) {
			case 'table':
				if (Schema::hasColumn($name, 'name')) {
					$this->builder->where(
						'records.name',
						'like',
						'%' . $string . '%'
					);
				} else {
					switch ($name) {
						case 'permissions':
							$this->builder->where(
								DB::Raw('IFNULL(IFNULL(object_loc.name, object_def.name), object.code)'),
								'like',
								'%' . $string . '%'
							);
							$this->builder->orWhere(
								DB::Raw('IFNULL(IFNULL(action_loc.name, action_def.name), action.code)'),
								'like',
								'%' . $string . '%'
							);
							break;
					}
				}
				break;
			case 'code':
				$this->builder->where(
					DB::Raw('IFNULL(IFNULL(record_loc.name , record_def.name), record.code)'),
					'like',
					'%' . $string . '%'
				);
				break;
		}

		return $this->builder;
	}

	public function role($string) {
		$this->builder->whereHas('roles', function($query) use ($string) {
			$query->where('code', $string);
		});
		return $this->builder;
	}

	public function sort($string) {
		$name = $this->getObjectCode();

		$order = $this->order();
		$reverse = $this->reverse();

		switch ($string) {
			case 'record':
				switch ($name) {
					case 'permissions':
						$sorts = [
							'IFNULL( IFNULL( object_loc.name, object_def.name ) , object.code)' => $order,
							'IFNULL( IFNULL( action_loc.name, action_def.name ) , action.code)' => $order
						];
						break;
					default:
						$sorts = [
							'record_name' => $order
						];
				}
				break;
		}

		return $this->applySorts($sorts);
	}

	public function getObjectCode()
	{
		$permission_code = request()->segments()[3];
		$object_code = explode('-', $permission_code)[0];
		return $object_code;
	}
}
