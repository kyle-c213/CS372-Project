<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->string('class_name');
            $table->integer('year');
            $table->string('semester');
            $table->foreignId('taught_by')->constrained('professors')->onDelete('cascade');
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
        Schema::dropIfExists('courses');
        Schema::table('courses', function(Blueprint $table){
            $table->dropForeign('created_by');
            $table->dropForeign('taught_by');
            $table->dropColumn('class_name');
            $table->dropColumn('year');
            $table->dropColumn('semester');
        });
    }
}
