<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rated_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('professor_rated')->constrained('professors')->onDelete('cascade');
            $table->foreignId('course_taken')->nullable()->onDelete('cascade')->constrained('courses');
            //$table->foreignId('course_taken')->constrained('courses')->onDelete('cascade');
            $table->float('rating');
            $table->string('body')->nullable();
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
        Schema::dropIfExists('ratings');
        Schema::table('ratings', function(Blueprint $table){
            $table->dropForeign('rated_by');
            $table->dropForeign('professor_rated');
            $table->dropForeign('course_taken');
            $table->dropColumn('rating');
            $table->dropColumn('body');
        });
    }
}
