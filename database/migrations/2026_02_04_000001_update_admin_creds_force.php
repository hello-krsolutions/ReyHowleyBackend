<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UpdateAdminCredsForce extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $email = 'hello@reyhowley.com';
        $password = Hash::make('MySuccess@2026');

        // Find Admin with role_id 1 (Super Admin)
        $admin = DB::table('admins')->where('role_id', 1)->first();

        if ($admin) {
            DB::table('admins')->where('id', $admin->id)->update([
                'email' => $email,
                'password' => $password,
                'updated_at' => now(),
            ]);
        } else {
            // Fallback: Check for ID 1
            $adminById = DB::table('admins')->where('id', 1)->first();
            if ($adminById) {
                DB::table('admins')->where('id', 1)->update([
                    'email' => $email,
                    'password' => $password,
                    'updated_at' => now(),
                ]);
            } else {
                // Insert if totally missing
                DB::table('admins')->insert([
                    'id' => 1,
                    'f_name' => 'Rey',
                    'l_name' => 'Howley',
                    'email' => $email,
                    'password' => $password,
                    'phone' => '0000000000',
                    'role_id' => 1,
                    'image' => 'def.png',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Not reversible without knowing previous state
    }
}
