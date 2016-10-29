<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecordCash extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('record_cash', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('cash_date');
			$table->float('cash_amount');
			$table->integer('cash_type');
			$table->longText('cash_notice');
			$table->integer('cash_transactions')->unsigned();
			$table->foreign('cash_transactions')->references('id')->on('cash_types_definer')->onDelete('cascade')->onUpdate('cascade');
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
		Schema::drop('record_cash');
	}

}
