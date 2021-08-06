<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\File;
use Nwidart\Modules\Facades\Module;
class CreateTemplates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('templates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id');
            $table->string('name', 190);
            $table->string('thumb', 190)->nullable();
            $table->longText('thank_you_page')->nullable();
            $table->longText('content')->nullable();
            $table->longText('style')->nullable();
            $table->boolean('active')->default(false);
            $table->boolean('is_premium')->default(false);
            $table->timestamps();
        });
        $module = Module::find('TemplateLandingPage');
        
        if ($module) {

            $path =  $module->getPath().'/Database/Seeders/sql/template.sql';
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
        Schema::dropIfExists('templates');
    }
}
