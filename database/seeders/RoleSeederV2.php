<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeederV2 extends Seeder
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

      $roles = [
        ["id"=>3,"name"=>"FreeUser"],
      ];
      
      $this->refreshSequence("roles","id");
      foreach($roles as $user) {
        \App\Models\Role::create([
          'id' => $user["id"],
          'name' => $user["name"],
        ]);
      };
      $this->refreshSequence("roles","id");
      
      // Add Role FreeUser to All Guest
      \DB::statement("
        INSERT INTO role_user(user_id,role_id)
        SELECT role_user.user_id,3 FROM role_user
        WHERE role_user.role_id = 2;
      ");
    }
}
