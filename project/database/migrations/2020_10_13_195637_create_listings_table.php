<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('posted_by')->constrained('users');
            $table->foreignId('course_id')->nullable()->constrained('courses')->onDelete('cascade');
            $table->string('title');
            $table->string('description');
            $table->float('price');
            $table->boolean('sold');
            $table->boolean('deleted');
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
        Schema::dropIfExists('listings');
        Schema::table('listings', function(Blueprint $table){
            $table->dropForeign('posted_by');
            $table->dropForeign('course_id');
            $table->dropColumn('title');
            $table->dropColumn('description');
            $table->dropColumn('price');
        });
    }
}
