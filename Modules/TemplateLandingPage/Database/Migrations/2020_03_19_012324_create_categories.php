<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\File;
use Nwidart\Modules\Facades\Module;

class CreateCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 190);
            $table->string('thumb', 190)->nullable();
            $table->string('color', 190)->nullable();
            $table->integer('group_category_id')->nullable();
            $table->timestamps();
        });

        $module = Module::find('TemplateLandingPage');
        
        if ($module) {
            
            $path =  $module->getPath().'/Database/Seeders/sql/templatecategories.sql';
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
        Schema::dropIfExists('categories');
    }
}
