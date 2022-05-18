<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_results', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            /**
             * Хранение результатов в бд
             * 2022-05-10 14:00 
             * 1:1 2:1 3:1 4:1 5:0;
             * 2022-05-10 15:00
             * 1:1 2:0 3:0 4:0 5:0;
             */
            $table->text('results'); 
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
        Schema::dropIfExists('test_results');
    }
}
