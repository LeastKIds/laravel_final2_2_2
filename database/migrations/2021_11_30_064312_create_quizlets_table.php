<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quizlets', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('answer');
            $table->string('answer_type');
            $table->string('quiz');
            $table->string('quiz_type');
            $table->bigInteger('timer') -> nullable();


            $table->foreignId('voca_id')
                ->constrained();
            $table->foreignId('room_id')
                ->constrained()
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quizlets');
    }
}
