<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeederV2Rollback extends Seeder
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
      // Remove Role FreeUser from All Guest
      \DB::statement("
        DELETE FROM role_user WHERE role_user.role_id = 3;
      ");

      $roles = [
        ["id"=>3,"name"=>"FreeUser"],
      ];
      
      $this->refreshSequence("roles","id");
      foreach($roles as $user) {
        \App\Models\Role::where('id',$user["id"])->delete();
      };
      $this->refreshSequence("roles","id");
      
    }
}
