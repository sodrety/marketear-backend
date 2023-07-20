<?php

use App\Models\CampaignSource;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIntentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('intents', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(CampaignSource::class, 'campaign_source_id');
            $table->text('nickname')->nullable();
            $table->string('region')->nullable();
            $table->string('language')->nullable();
            $table->text('picture')->nullable();
            $table->text('text')->nullable();
            $table->string('cid')->nullable();
            $table->timestamp('comment_at');
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
        Schema::dropIfExists('intents');
    }
}
