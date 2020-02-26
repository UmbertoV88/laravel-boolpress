<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            // creo prima una tabella segna assegnare nulla
            $table->unsignedBigInteger('category_id')->after('id')->nullable();
            // creo la relazione tra la chiave esterna + il riferimento alla colonna + a quale tab
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            // butto via la colonna, ma prima devo eliminare la chiave foreign(dropForeign(nome della tabella+nome della chiave+foreign))
            $table->dropForeign('posts_category_id_foreign');
            $table->dropColums('category_id');
        });
    }
}
