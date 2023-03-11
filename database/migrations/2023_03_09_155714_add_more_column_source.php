<?php

use App\Models\Creator;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreColumnSource extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaign_sources', function(Blueprint $table) {
            $table->integer('comment_count')->nullable();
            $table->integer('collect_count')->nullable();
            $table->integer('like_count')->nullable();
            $table->integer('share_count')->nullable();
            $table->integer('play_count')->nullable();
            $table->json('other_share_count')->nullable();
            $table->foreignIdFor(Creator::class, 'creator_id');
            $table->string('caption')->nullable();
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campaign_sources', function(Blueprint $table) {
            $table->dropColumn('comment_count');
            $table->dropColumn('collect_count');
            $table->dropColumn('like_count');
            $table->dropColumn('share_count');
            $table->dropColumn('play_count');
            $table->dropColumn('other_share_count');
            $table->dropColumn('other_share_count');
            $table->dropColumn('caption');
        });
    }
}
