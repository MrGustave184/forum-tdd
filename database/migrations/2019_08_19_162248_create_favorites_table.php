<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFavoritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favorites', function (Blueprint $table) {
						$table->bigIncrements('id');
						$table->unsignedInteger('user_id');

						// favorited_id contains the id of the favorited entity (reply, user, thread, etc)
						$table->unsignedInteger('favorited_id'); 

						// favorited_type contains the name of the model that holds the relationship (
						// Reply, User, Thread, etc...)

						// With both favorited_id and favorited_reply, we stablish a polymorphic relationship
						// This allows us to bind a model to several others
						$table->string('favorited_type', 50);

						$table->timestamps();
						
						// DB level protection against user favoriting an item more than once
						$table->unique(['user_id', 'favorited_id', 'favorited_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('favorites');
    }
}
