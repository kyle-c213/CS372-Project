<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListingTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listing_tags', function (Blueprint $table) {
            $table->id();
            $table->string('tag');
            $table->foreignId('listing_id')->constrained('listings')->onDelete('cascade');
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
        Schema::dropIfExists('listing_tags');
        Schema::table('listing_tags', function(Blueprint $table){
            $table->dropForeign('listing_id');
            $table->dropColumn('tag');
        });
    }
}
