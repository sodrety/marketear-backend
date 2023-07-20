<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateProjectCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
        });

        DB::table('project_categories')->insert([
            [
                'name' => 'Health',
                'slug' => Str::slug('Health','-'),
            ],[
                'name' => 'Entertainment',
                'slug' => Str::slug('Entertainment','-'),
            ],[
                'name' => 'Politics',
                'slug' => Str::slug('Politics','-'),
            ],[
                'name' => 'Education',
                'slug' => Str::slug('Education','-'),
            ],[
                'name' => 'Social',
                'slug' => Str::slug('Social','-'),
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_categories');
    }
}
