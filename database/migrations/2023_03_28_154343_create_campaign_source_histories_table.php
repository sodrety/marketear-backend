<?php

use App\Models\CampaignSource;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignSourceHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_source_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(CampaignSource::class, "campaign_source_id");
            $table->integer('comment_count')->nullable();
            $table->integer('collect_count')->nullable();
            $table->integer('like_count')->nullable();
            $table->integer('share_count')->nullable();
            $table->integer('play_count')->nullable();
            $table->json('other_share_count')->nullable();
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
        Schema::dropIfExists('campaign_source_histories');
    }
}
