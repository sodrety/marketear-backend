<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfileDetailUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->text('image')->nullable()->after('remember_token');
        $table->text('phone')->nullable()->after('image');
        $table->text('title')->nullable()->after('phone');
        $table->text('description')->nullable()->after('title');
        $table->boolean('status')->default(0)->after('description');
        $table->text('job')->nullable()->after('status');
        $table->text('company')->nullable()->after('job');
        $table->foreignId('workspace_id')->nullable()->constrained()->after('company');
    });
}

/**
 * Reverse the migrations.
 *
 * @return void
 */
public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('image');
        $table->dropColumn('phone');
        $table->dropColumn('title');
        $table->dropColumn('description');
        $table->dropColumn('status');
        $table->dropColumn('job');
        $table->dropColumn('company');
        $table->dropForeign('workspace_id');
        $table->dropColumn('workpace_id');
    });
}
}
