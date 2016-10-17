<?php

use Illuminate\Database\Seeder;

use App\Models\Code;
use App\Models\Admin\Permission;

class PermissionRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$this->command->info('Creating permission roles...');

		$devRoleId = Code::lookup('roles', 'dev')->first()->id;
		$adminRoleId = Code::lookup('roles', 'admin')->first()->id;
		$testerRoleId = Code::lookup('roles', 'maint_tester')->first()->id;
		$translatorRoleId = Code::lookup('roles', 'translator')->first()->id;

		$permission = Permission::select(['permissions.id'])->locale(['code'])->lookup('admin_menu', 'display')->first();
		$permission->roles()->attach([$devRoleId, $adminRoleId, $translatorRoleId]);

		$permission = Permission::select(['permissions.id'])->locale(['code'])->lookup('security_menu', 'display')->first();
		$permission->roles()->attach([$devRoleId, $adminRoleId]);

		$permission = Permission::select(['permissions.id'])->locale(['code'])->lookup('codes', 'list')->first();
		$permission->roles()->attach([$devRoleId, $adminRoleId]);
		$permission = Permission::select(['permissions.id'])->locale(['code'])->lookup('codes', 'add')->first();
		$permission->roles()->attach([$devRoleId, $adminRoleId]);
		$permission = Permission::select(['permissions.id'])->locale(['code'])->lookup('codes', 'add_child')->first();
		$permission->roles()->attach([$devRoleId]);
		$permission = Permission::select(['permissions.id'])->locale(['code'])->lookup('codes', 'edit')->first();
		$permission->roles()->attach([$devRoleId, $adminRoleId]);

		$permission = Permission::select(['permissions.id'])->locale(['code'])->lookup('permissions', 'list')->first();
		$permission->roles()->attach([$devRoleId, $adminRoleId]);
		$permission = Permission::select(['permissions.id'])->locale(['code'])->lookup('permissions', 'add')->first();
		$permission->roles()->attach([$devRoleId]);
		$permission = Permission::select(['permissions.id'])->locale(['code'])->lookup('permissions', 'edit')->first();
		$permission->roles()->attach([$devRoleId]);
		$permission = Permission::select(['permissions.id'])->locale(['code'])->lookup('permissions', 'edit_roles')->first();
		$permission->roles()->attach([$devRoleId, $adminRoleId]);

		$permission = Permission::select(['permissions.id'])->locale(['code'])->lookup('records', 'list')->first();
		$permission->roles()->attach([$devRoleId, $adminRoleId]);
		$permission = Permission::select(['permissions.id'])->locale(['code'])->lookup('records', 'add')->first();
		$permission->roles()->attach([$devRoleId]);
		$permission = Permission::select(['permissions.id'])->locale(['code'])->lookup('records', 'edit')->first();
		$permission->roles()->attach([$devRoleId]);
		$permission = Permission::select(['permissions.id'])->locale(['code'])->lookup('records', 'edit_roles')->first();
		$permission->roles()->attach([$devRoleId, $adminRoleId]);

		$permission = Permission::select(['permissions.id'])->locale(['code'])->lookup('users', 'list')->first();
		$permission->roles()->attach([$devRoleId, $adminRoleId]);
		$permission = Permission::select(['permissions.id'])->locale(['code'])->lookup('users', 'add')->first();
		$permission->roles()->attach([$devRoleId, $adminRoleId]);
		$permission = Permission::select(['permissions.id'])->locale(['code'])->lookup('users', 'edit')->first();
		$permission->roles()->attach([$devRoleId, $adminRoleId]);

		$permission = Permission::select(['permissions.id'])->locale(['code'])->lookup('maint', 'display')->first();
		$permission->roles()->attach([$devRoleId, $adminRoleId, $testerRoleId]);
		$permission = Permission::select(['permissions.id'])->locale(['code'])->lookup('maint', 'edit')->first();
		$permission->roles()->attach([$devRoleId, $adminRoleId]);

		$permission = Permission::select(['permissions.id'])->locale(['code'])->lookup('options', 'edit')->first();
		$permission->roles()->attach([$devRoleId, $adminRoleId]);

		$permission = Permission::select(['permissions.id'])->locale(['code'])->lookup('translations', 'edit')->first();
		$permission->roles()->attach([$devRoleId, $adminRoleId, $translatorRoleId]);
    }
}
