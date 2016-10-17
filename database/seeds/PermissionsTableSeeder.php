<?php

use Illuminate\Database\Seeder;

use App\Models\Code;
use App\Models\Admin\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$this->command->info('Creating permissions...');
		Permission::create([
			'object_id' => Code::getCodeId('objects', 'admin_menu'),
			'action_id' => Code::getCodeId('actions', 'display')
		]);
		Permission::create([
			'object_id' => Code::getCodeId('objects', 'security_menu'),
			'action_id' => Code::getCodeId('actions', 'display')
		]);
		Permission::create([
			'object_id' => Code::getCodeId('objects', 'codes'),
			'action_id' => Code::getCodeId('actions', 'list')
		]);
		Permission::create([
			'object_id' => Code::getCodeId('objects', 'codes'),
			'action_id' => Code::getCodeId('actions', 'add')
		]);
		Permission::create([
			'object_id' => Code::getCodeId('objects', 'codes'),
			'action_id' => Code::getCodeId('actions', 'add_child')
		]);
		Permission::create([
			'object_id' => Code::getCodeId('objects', 'codes'),
			'action_id' => Code::getCodeId('actions', 'edit')
		]);
		Permission::create([
			'object_id' => Code::getCodeId('objects', 'permissions'),
			'action_id' => Code::getCodeId('actions', 'list')
		]);
		Permission::create([
			'object_id' => Code::getCodeId('objects', 'permissions'),
			'action_id' => Code::getCodeId('actions', 'add')
		]);
		Permission::create([
			'object_id' => Code::getCodeId('objects', 'permissions'),
			'action_id' => Code::getCodeId('actions', 'edit')
		]);
		Permission::create([
			'object_id' => Code::getCodeId('objects', 'permissions'),
			'action_id' => Code::getCodeId('actions', 'edit_roles')
		]);
		Permission::create([
			'object_id' => Code::getCodeId('objects', 'records'),
			'action_id' => Code::getCodeId('actions', 'list')
		]);
		Permission::create([
			'object_id' => Code::getCodeId('objects', 'records'),
			'action_id' => Code::getCodeId('actions', 'add')
		]);
		Permission::create([
			'object_id' => Code::getCodeId('objects', 'records'),
			'action_id' => Code::getCodeId('actions', 'edit')
		]);
		Permission::create([
			'object_id' => Code::getCodeId('objects', 'records'),
			'action_id' => Code::getCodeId('actions', 'edit_roles')
		]);
		Permission::create([
			'object_id' => Code::getCodeId('objects', 'users'),
			'action_id' => Code::getCodeId('actions', 'list')
		]);
		Permission::create([
			'object_id' => Code::getCodeId('objects', 'users'),
			'action_id' => Code::getCodeId('actions', 'add')
		]);
		Permission::create([
			'object_id' => Code::getCodeId('objects', 'users'),
			'action_id' => Code::getCodeId('actions', 'edit')
		]);
		Permission::create([
			'object_id' => Code::getCodeId('objects', 'maint'),
			'action_id' => Code::getCodeId('actions', 'edit')
		]);
		Permission::create([
			'object_id' => Code::getCodeId('objects', 'maint'),
			'action_id' => Code::getCodeId('actions', 'display')
		]);
		Permission::create([
			'object_id' => Code::getCodeId('objects', 'options'),
			'action_id' => Code::getCodeId('actions', 'edit')
		]);
		Permission::create([
			'object_id' => Code::getCodeId('objects', 'translations'),
			'action_id' => Code::getCodeId('actions', 'edit')
		]);
    }
}
