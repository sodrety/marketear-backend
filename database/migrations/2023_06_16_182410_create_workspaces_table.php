<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkspacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workspaces', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->foreignIdFor(\App\Models\User::class, 'user_id');
            $table->timestamps();
        });

        Schema::create('workspace_relation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workspace_id')->references('id')->on('workspaces');
            $table->string('name', 100);
            $table->integer('relation_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('workspaces');
        Schema::dropIfExists('workspace_relation');
    }
}
