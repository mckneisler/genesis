<?php

use Illuminate\Database\Seeder;

use App\Models\Code;
use App\Models\Admin\PermissionRecord;

class PermissionRecordRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$this->command->info('Creating permission record roles...');

		$devRoleId = Code::lookup('roles', 'dev')->first()->id;

		$permissionId = PermissionRecord::lookup('codes', 'add', 'types')->first();
		$permissionId->roles()->attach($devRoleId);
		$permissionId = PermissionRecord::lookup('codes', 'edit', 'types')->first();
		$permissionId->roles()->attach($devRoleId);

		$permissionId = PermissionRecord::lookup('codes', 'add', 'actions')->first();
		$permissionId->roles()->attach($devRoleId);
		$permissionId = PermissionRecord::lookup('codes', 'edit', 'actions')->first();
		$permissionId->roles()->attach($devRoleId);

		$permissionId = PermissionRecord::lookup('codes', 'add', 'objects')->first();
		$permissionId->roles()->attach($devRoleId);
		$permissionId = PermissionRecord::lookup('codes', 'edit', 'objects')->first();
		$permissionId->roles()->attach($devRoleId);
    }
}
