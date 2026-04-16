<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nama')->after('id');
            $table->string('nis')->unique()->nullable();
            $table->string('kelas')->nullable();
            $table->string('no_hp')->nullable();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nama', 'nis', 'kelas', 'no_hp']);
        });
    }
};
