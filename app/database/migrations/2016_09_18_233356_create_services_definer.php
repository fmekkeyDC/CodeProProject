<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesDefiner extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('services_definer', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('service_name');
			$table->float('service_price');
			$table->float('weak_discount');
			$table->float('month_discount');
			$table->integer('service_plan');
			$table->longText('service_notice');
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
		Schema::drop('services_definer');
	}

}
