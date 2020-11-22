<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from')->constrained('users');
            $table->foreignId('to')->constrained('users');
            $table->string('title');
            $table->string('content');
            $table->boolean('opened')->default(0);
            $table->boolean('from_deleted')->default(0);
            $table->boolean('to_deleted')->default(0);
            $table->foreignId('child_of')->nullable()->constrained('mails');
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
        Schema::dropIfExists('mails');
        Schema::table('listings', function(Blueprint $table){
            $table->dropForeign('from');
            $table->dropForeign('to');
            $table->dropColumn('title');
            $table->dropColumn('content');
            $table->dropColumn('opened');
            $table->dropColumn('from_deleted');
            $table->dropColumn('to_deleted');
            $table->dropForeign('child_of');
        });
    }
}
