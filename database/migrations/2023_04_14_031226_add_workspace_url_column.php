<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Channel;

class AddWorkspaceUrlColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('workspace_urls', function(Blueprint $table) {
            $table->foreignIdFor(Channel::class, 'channel_id')->before('created_at');
        });

        Schema::table('campaign_sources', function (Blueprint $table) {
            $table->dropColumn(['campaign_id']);
            $table->foreignId('workspace_id')->after('id')->references('id')->on('workspaces')->onDelete('cascade');
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
