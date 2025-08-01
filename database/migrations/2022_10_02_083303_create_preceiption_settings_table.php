<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreceiptionSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preceiption_settings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('doctor_id')->nullable();
            $table->string('name')->nullable();
            $table->string('logo')->nullable();
            $table->string('degree')->nullable();
            $table->string('address')->nullable();
            $table->string('tel')->nullable();
            $table->string('cel')->nullable();
            $table->string('footer_right')->nullable();
            $table->string('footer_left')->nullable();
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
        Schema::dropIfExists('preceiption_settings');
    }
}
