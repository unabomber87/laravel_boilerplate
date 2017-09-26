<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\User;

class InitSeeder extends Seeder{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

    	// Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

    	// create permission
    	DB::table('permissions')->delete();
        Permission::create(['name' => 'permission.list']);
        Permission::create(['name' => 'permission.create']);
        Permission::create(['name' => 'permission.update']);
        Permission::create(['name' => 'permission.delete']);

        Permission::create(['name' => 'role.list']);
        Permission::create(['name' => 'role.create']);
        Permission::create(['name' => 'role.update']);
        Permission::create(['name' => 'role.delete']);

        Permission::create(['name' => 'user.list']);
        Permission::create(['name' => 'user.create']);
        Permission::create(['name' => 'user.update']);
        Permission::create(['name' => 'user.delete']);

        Permission::create(['name' => 'app.list']);
        Permission::create(['name' => 'app.create']);
        Permission::create(['name' => 'app.update']);
        Permission::create(['name' => 'app.delete']);

        Permission::create(['name' => 'setting.list']);
        Permission::create(['name' => 'setting.create']);
        Permission::create(['name' => 'setting.update']);
        Permission::create(['name' => 'setting.delete']);

      	// create apps
      	DB::table('apps')->delete();
        DB::table('apps')->insert(array(
			array('name'=>'permission'),
			array('name'=>'role'),
			array('name'=>'user'),
			array('name'=>'app'),
			array('name'=>'setting')
      	));

      	// create role
      	DB::table('roles')->delete();
        $role = Role::create(['name' => 'admin']);


        // affect role to permission
      	$role = Role::findByName('admin');
      	$permissions = Permission::all();
      	foreach($permissions as $perm){
      		$role->givePermissionTo($perm->name);
      	}

      	// create user
        DB::table('users')->delete();
        DB::table('users')->insert(array(
			array('name'=>'admin','email'=>'admin@boiler.com','password'=>bcrypt('boiler123'))
      	));

        // affect role to user
        $user = User::where('name', '=', 'admin')->first();
        $user->assignRole('admin');

        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        //print($user->can('setting.delete'));
    }
}
