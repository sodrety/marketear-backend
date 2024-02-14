<?php

use App\Models\ExternalApis;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExternalApiEndpointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('external_api_endpoints', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ExternalApis::class, 'external_api_id');
            $table->string('name', 50);
            $table->string('endpoint', 150);
            $table->enum('method', ['post', 'get', 'patch', 'delete', 'put']);
            $table->string('description', 200)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('external_api_endpoints');
    }
}
