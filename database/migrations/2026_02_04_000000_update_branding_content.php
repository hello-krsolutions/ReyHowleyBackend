<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;

class UpdateBrandingContentAndAdmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Update DataSettings (Slogans, Titles)
        $slogan = 'ReyHowley is your ultimate multivendor solution! Empower your business with cutting-edge features and seamless performance.';

        DB::table('data_settings')->where('key', 'fixed_footer_article_title')->update(['value' => $slogan]);
        DB::table('data_settings')->where('key', 'fixed_header_title')->update(['value' => 'ReyHowley']);
        // Use logic to replace 6amMart in other text fields if needed, but direct updates are safer for specific keys
        DB::table('data_settings')->where('key', 'download_user_app_sub_title')->update(['value' => 'ReyHowley is a dynamic multivendor delivery system.']);
        DB::table('data_settings')->where('key', 'download_seller_app_title')->update(['value' => 'Start Selling with ReyHowley']);
        DB::table('data_settings')->where('key', 'highlight_sub_title')->update(['value' => 'ReyHowley makes it easy to rent vehicles quickly and affordably.']);

        // Update BusinessSettings (Contact Info)
        DB::table('business_settings')->where('key', 'business_name')->update(['value' => 'Rey Howley']);
        DB::table('business_settings')->where('key', 'footer_text')->update(['value' => 'Rey Howley']);

        DB::table('business_settings')->where('key', 'phone')->update(['value' => '+91 - 9052 11 44 88']);
        DB::table('business_settings')->where('key', 'email_address')->update(['value' => 'hello@reyhowley.com']);
        DB::table('business_settings')->where('key', 'address')->update(['value' => '#101, Siri Appartments, Masapeta, Rayachoty, Annamayya Dist, Andhra Pradesh, IN, 516269']);

        // Update Admin Credentials
        // Assuming the first admin (ID 1) is the super admin to update
        $adminEmail = 'hello@reyhowley.com';
        $adminPassword = Hash::make('MySuccess@2026');

        $admin = DB::table('admins')->where('id', 1)->first();
        if ($admin) {
            DB::table('admins')->where('id', 1)->update([
                'email' => $adminEmail,
                'password' => $adminPassword,
                'updated_at' => now(),
            ]);
        } else {
            // Insert if not exists (fallback)
            DB::table('admins')->insert([
                'id' => 1,
                'f_name' => 'Rey',
                'l_name' => 'Howley',
                'email' => $adminEmail,
                'password' => $adminPassword,
                'phone' => '0000000000',
                'role_id' => 1, // Assuming 1 is super admin role
                'image' => 'def.png',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // No down needed really, it's just data updates
    }
}
