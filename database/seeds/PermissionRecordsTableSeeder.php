<?php

use Illuminate\Database\Seeder;

use App\Models\Code;
use App\Models\Admin\Permission;
use App\Models\Admin\PermissionRecord;

class PermissionRecordsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$this->command->info('Creating permission records...');

		$permission = Permission::select(['permissions.id'])->locale(['code'])->lookup('codes', 'add')->first();
		PermissionRecord::create([
			'permission_id' => $permission->id,
			'record_id' => Code::getCodeId('types', 'types')
		]);
		PermissionRecord::create([
			'permission_id' => $permission->id,
			'record_id' => Code::getCodeId('types', 'actions')
		]);
		PermissionRecord::create([
			'permission_id' => $permission->id,
			'record_id' => Code::getCodeId('types', 'objects')
		]);

		$permission = Permission::select(['permissions.id'])->locale(['code'])->lookup('codes', 'edit')->first();
		PermissionRecord::create([
			'permission_id' => $permission->id,
			'record_id' => Code::getCodeId('types', 'types')
		]);
		PermissionRecord::create([
			'permission_id' => $permission->id,
			'record_id' => Code::getCodeId('types', 'actions')
		]);
		PermissionRecord::create([
			'permission_id' => $permission->id,
			'record_id' => Code::getCodeId('types', 'objects')
		]);
    }
}
