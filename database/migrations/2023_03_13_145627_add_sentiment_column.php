<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSentimentColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('intents', function(Blueprint $table) {
            $table->string('sentiment')->nullable();
            $table->string('score')->nullable();
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('intents', function(Blueprint $table) {
            $table->dropColumn('sentiment');
            $table->dropColumn('score');
        });
    }
}
