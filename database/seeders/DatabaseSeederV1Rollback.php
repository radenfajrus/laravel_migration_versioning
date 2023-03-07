<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeederV1Rollback extends Seeder
{
    /**
     * Seed the application's database.
     */

    public function refreshSequence($table,$column): void
    {
      \DB::statement("
        SELECT SETVAL(pg_get_serial_sequence('$table', '$column'), (SELECT MAX($column) FROM $table));
      ");
    }
    
    public function run(): void
    {
        $users = [
          ["id"=>1,"name"=>"Admin"],
          ["id"=>2,"name"=>"Tester"],
          ["id"=>3,"name"=>"Guest"],
        ];

        $this->refreshSequence("users","id");
        foreach($users as $user) {
          \App\Models\User::where("id",$user["id"])->delete();
        };
        $this->refreshSequence("users","id");

        $roles = [
          ["id"=>1,"name"=>"Admin"],
          ["id"=>2,"name"=>"Guest"],
        ];
        
        $this->refreshSequence("roles","id");
        foreach($roles as $role) {
          \App\Models\Role::where("id",$role["id"])->delete();
        };
        $this->refreshSequence("roles","id");
        
        $role_users = [
          ["user_id"=>1,"role_id"=>1],
          ["user_id"=>2,"role_id"=>1],
          ["user_id"=>3,"role_id"=>2],
        ];

        $this->refreshSequence("role_user","id");
        foreach($role_users as $role_user) {
          \App\Models\RoleUser::where("user_id",$role_user["user_id"])->where("role_id",$role_user["role_id"])->delete();
        };
        $this->refreshSequence("role_user","id");
    }
}
