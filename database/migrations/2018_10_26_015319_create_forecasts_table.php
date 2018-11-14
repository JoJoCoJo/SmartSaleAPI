<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForecastsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forecasts', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('id_forecast');
            $table->tinyInteger('type_forecast');
            $table->longText('forecastData');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id_user')->on('users');
            $table->unsignedInteger('sale_id');
            $table->foreign('sale_id')->references('id_sale')->on('sales');
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
        Schema::dropIfExists('forecasts');
    }
}
