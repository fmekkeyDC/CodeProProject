<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreItems extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('store_items', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer("invoice_number");
			$table->string("invoice_date")->default("");
			$table->string("provider_name")->default("");
			$table->integer("item_code")->unsigned();
			// $table->foreign('item_code')->references('item_code')->on('item_definer')->onDelete('cascade')->onUpdate('cascade');
			$table->integer("item_type");
			$table->float("item_quantity");
			$table->float("item_price");
			$table->float("item_total_price");
			$table->float("items_total_price");
			$table->float("items_discount");
			$table->float("payment_method");
			$table->float("addons");
			$table->float("items_net_total");
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
		Schema::drop('store_items');
	}

}
