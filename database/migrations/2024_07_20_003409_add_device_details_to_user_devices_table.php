<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeviceDetailsToUserDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_devices', function (Blueprint $table) {
            $table->string('browser')->after('device_info');
            $table->string('browser_version')->after('browser');
            $table->string('platform')->after('browser_version');
            $table->string('platform_version')->after('platform');
            $table->string('device')->after('platform_version');
            $table->string('brand')->after('device');
            $table->boolean('is_mobile')->default(false)->after('device');
            $table->boolean('is_tablet')->default(false)->after('is_mobile');
            $table->boolean('is_desktop')->default(false)->after('is_tablet');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_devices', function (Blueprint $table) {
            $table->dropColumn('browser');
            $table->dropColumn('browser_version');
            $table->dropColumn('platform');
            $table->dropColumn('platform_version');
            $table->dropColumn('device');
            $table->dropColumn('brand');
            $table->dropColumn('is_mobile');
            $table->dropColumn('is_tablet');
            $table->dropColumn('is_desktop');
        });
    }
}
