<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\File;
use Nwidart\Modules\Facades\Module;
class CreateBlocks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blocks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('block_category_id');
            $table->string('thumb', 190);
            $table->string('name', 190);
            $table->longText('content')->nullable();
            $table->longText('style')->nullable();
            $table->boolean('active')->default(false);
            $table->timestamps();
        });

        // add default DB
        $module = Module::find('BlocksLandingPage');
        
        if ($module) {
            
            $path =  $module->getPath().'/Database/Seeders/sql/blocks.sql';
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
        Schema::dropIfExists('blocks');
    }
}
