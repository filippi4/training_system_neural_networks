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
            $table->unsignedBigInteger('test_id')->nullable()->unsigned();
            $table->unsignedBigInteger('user_id')->nullable()->unsigned();
            $table->unsignedInteger('tries')->default(0)->unsigned();
            $table->enum('score', ['неудовлетворительно', 'удовлетворительно', 'хорошо', 'отлично']);
            $table->timestamps();

            $table->foreign('test_id')->references('id')->on('tests')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->nullable();
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
