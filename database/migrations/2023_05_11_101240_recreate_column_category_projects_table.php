<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RecreateColumnCategoryProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table
            ->foreignId('category_id')
            ->after('type')
            ->references('id')
            ->on('project_categories');
            
            $table->foreignId('user_id')
            ->default(1)
            ->after('category_id')
            ->references('id')
            ->on('users');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('role_id')
            ->default(1)
            ->after('email')
            ->references('id')
            ->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
