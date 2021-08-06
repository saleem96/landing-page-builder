<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLandingpageOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('landingpage_orders', function (Blueprint $table) {
            
            $table->bigIncrements('id');

            $table->integer('user_id')->index();
            $table->integer('landing_page_id');
            $table->string('product_name')->nullable();
            $table->string('reference')->nullable();
            $table->string('gateway');
            $table->double('total', 13, 2);
            $table->boolean('is_paid')->default(false);
            $table->longText('options')->nullable();
            $table->string('currency', 3);
            $table->string('status', 120)->default('OPEN');
            $table->text('field_values')->nullable(); // form order data
            $table->text('browser')->nullable();
            $table->text('os')->nullable();
            $table->text('device')->nullable();

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
        Schema::dropIfExists('landingpage_orders');
    }
}
