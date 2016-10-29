<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemDefiner extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('item_definer', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer("item_type_id")->unsigned();
			$table->foreign('item_type_id')->references('id')->on('items_type_definer')->onDelete('cascade')->onUpdate('cascade');
			$table->string("item_name");
			$table->integer("item_code");
			$table->float("paid_price");
			$table->float("sell_dist_price");
			$table->float("wholesale_price");
			$table->float("started_quantity");
			$table->float("item_profitability");
			$table->float("re_request_point");
			$table->integer("non_storeable_item")->default(0);
			$table->integer("none_active_item")->default(0);
			$table->longText("item_picture");
			$table->longText("item_description");
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
		Schema::drop('item_definer');
	}

}
