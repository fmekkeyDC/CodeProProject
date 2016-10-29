<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTypeDefiner extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('items_type_definer', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string("item_type_name");
			$table->integer('created_by')->unsigned();
			$table->foreign('created_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
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
		Schema::drop('items_type_definer');
	}

}
