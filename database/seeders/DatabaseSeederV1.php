<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeederV1 extends Seeder
{
    /**
     * Seed the application's database.
     */

    public function refreshSequence($table,$column): void
    {
      \DB::unprepared("
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
          \App\Models\User::create([
            'id' => $user["id"],
            'name' => $user["name"],
          ]);
        };
        $this->refreshSequence("users","id");

        $roles = [
          ["id"=>1,"name"=>"Admin"],
          ["id"=>2,"name"=>"Guest"],
        ];
        
        $this->refreshSequence("roles","id");
        foreach($roles as $role) {
          \App\Models\Role::create([
            'id' => $role["id"],
            'name' => $role["name"],
          ]);
        };
        $this->refreshSequence("roles","id");
        
        $role_users = [
          ["user_id"=>1,"role_id"=>1],
          ["user_id"=>2,"role_id"=>1],
          ["user_id"=>3,"role_id"=>2],
        ];

        $this->refreshSequence("role_user","id");
        foreach($role_users as $role_user) {
          \App\Models\RoleUser::create([
            'user_id' => $role_user["user_id"],
            'role_id' => $role_user["role_id"],
          ]);
        };
        $this->refreshSequence("role_user","id");
    }
}
