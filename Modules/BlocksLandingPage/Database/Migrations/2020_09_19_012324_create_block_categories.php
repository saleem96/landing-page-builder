<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\File;
use Nwidart\Modules\Facades\Module;

class CreateBlockCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('block_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 190);
            $table->string('color', 190)->nullable();
            $table->timestamps();
        });

        $module = Module::find('BlocksLandingPage');
        if ($module) {
            $path =  $module->getPath().'/Database/Seeders/sql/blockcategories.sql';
            if(File::exists($path)) {
                \DB::unprepared(file_get_contents($path));
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('block_categories');
    }
}
