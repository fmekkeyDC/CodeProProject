<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeleteItemsFromStore extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('delete_items_from_store', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer("invoice_number")->unsigned();
			// $table->foreign('invoice_number')->references('store_items')->on('invoice_number')->onDelete('cascade')->onUpdate('cascade');
			$table->integer("item_code")->unsigned();
			// $table->foreign('item_code')->references('item_code')->on('item_definer')->onDelete('cascade')->onUpdate('cascade');
			$table->integer("item_type");
			$table->float("item_quantity");
			$table->float("item_price");
			$table->float("item_total_price");
			$table->float("items_total_price");
			$table->longText("delete_reason");
			$table->float("invoice_notice");
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
		Schema::drop('delete_items_from_store');
	}

}
