<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLandingPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('landing_pages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('template_id')->nullable();
            
            // uuid
            $table->string('code', 36)->index();

            $table->string('name', 190);

            // save content main page
            $table->longText('html')->nullable();
            $table->longText('css')->nullable();
            $table->longText('components')->nullable();
            $table->longText('styles')->nullable();
            $table->longText('main_page_script')->nullable();

            // save content thank you page 
            $table->longText('thank_you_page_html')->nullable();
            $table->longText('thank_you_page_css')->nullable();
            $table->longText('thank_you_page_components')->nullable();
            $table->longText('thank_you_page_styles')->nullable();

            // setting
            $table->string('favicon', 190)->nullable();
            $table->boolean('domain_type')->default(false);
            $table->string('sub_domain', 190)->unique()->nullable();
            $table->string('custom_domain', 190)->unique()->nullable();

            // search SEO
            $table->text('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->text('seo_keywords')->nullable();
            // social seo
            $table->text('social_title')->nullable();
            $table->string('social_image', 190)->nullable();
            $table->text('social_description')->nullable();
            // custom code
            $table->longText('custom_header')->nullable();
            $table->longText('custom_footer')->nullable();

            // alert form submit
            $table->string('type_form_submit', 190)->default('thank_you_page');
            $table->text('redirect_url')->nullable();

            // alert payment submit
            $table->string('type_payment_submit', 190)->default('thank_you_page');
            $table->text('redirect_url_payment')->nullable();

            $table->boolean('is_publish')->default(false);
            $table->boolean('is_trash')->default(false);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('landing_pages');
    }
}
