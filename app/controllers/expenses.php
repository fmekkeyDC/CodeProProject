<?php

use Carbon\Carbon;

class expenses extends BaseController{

	public function addNewCash() {
		$date = Input::get("date");
		$expenses_name = Input::get("expenses_name");
		$expenses_value = Input::get("expenses_value");
		$notice = Input::get("notice");
		$type = Input::get("type");
		$table_name = "expenses";

		if($type == 2){
			$table_name = "revenu";
		}else if ($type == 1){
			$table_name = "expenses";
		}else if ($type == 3){
			$table_name = "export";
		}else if ($type == 4){
			$table_name = "usable";
		}else if ($type == 5){
			$table_name = "monthlyCosts";
		}else{
			return ["stoping services"];
		}

		$rules = [
			"date" => "required",
			"expenses_name" => "required",
			"expenses_value" => "required",
		];

		$messages = [
			"date.required" => "فضلاً ضع التاريخ",
			"expenses_name.required" => "فضلاً ضع اسم المصروف",
			"expenses_value.required" => "فضلاً ضع سعر المصروف",
		];

		$validator = Validator::make(Input::all(), $rules, $messages);

		if ($validator->fails()){
			return $response = Response::json(
				[
					"errorsFounder" => 1,
					"messages"=>$validator->errors()->toArray()
				]
			);
		}else {
			if (Input::get("updated") && !empty(Input::get("updated"))){
				$insertData = DB::table($table_name)
				->where("id","=",Input::get("updated"))
				->update([
					// "date" => Carbon::parse($date)->format("Y-m-d"),
					"expenses_name" => $expenses_name,
					"expenses_value" => $expenses_value,
					"notice" => $notice,
					"date" => $date,
					"created_by" => Auth::user()->id,
					"updated_at" => Carbon::now()
				]);
			}else{
				$insertData = DB::table($table_name)
				->insert([
					"expenses_name" => $expenses_name,
					"expenses_value" => $expenses_value,
					"notice" => $notice,
					"date" => $date,
					"created_by" => Auth::user()->id,
					"updated_at" => Carbon::now()
				]);
			}
			if ($insertData){
				return $response = Response::json(
					[
						"errorsFounder" => 0,
						"messages"=> "تم إدخال البيانات بنجاح"
					]
				);
			}else{
				return $response = Response::json(
					[
						"errorsFounder" => 1,
						"messages"=> "خطأ في الإتصال بقاعدة البيانات"
					]
				);
			}
		}
	}

	public function getExpenses () {
		$type = Input::get("type");

		if($type == 2){
			$table_name = "revenu";
		}else if ($type == 1){
			$table_name = "expenses";
		}else if ($type == 3){
			$table_name = "export";
		}else if ($type == 4){
			$table_name = "usable";
		}else if ($type == 5){
			$table_name = "monthlyCosts";
		}
		
		$getexpenses = DB::table($table_name)
		->select(
			"{$table_name}.id",
			"{$table_name}.date",
			"{$table_name}.expenses_name",
			"{$table_name}.expenses_value"
		);

		return Datatables::of($getexpenses)->make();
	}

	public function getExpensesByID () {
		$invoiceID = Input::get("invoiceID");
		$getStoreItemsData = DB::table("expenses")->where("id","=",$invoiceID)->first();
		return Response::json($getStoreItemsData);
	}


	public function getCurrentCashBoxService(){
		$invoiceID = Input::get("invoiceID");
		$getStoreItemsData = DB::select(
			"
			SELECT( 
				    (IFNULL((SELECT SUM(`items_net_total`) FROM solditems where invoice_date = '{$invoiceID}' AND invoice_parent = 0),0)
				    + 
				    IFNULL((SELECT SUM(`price`) FROM shower where date = '{$invoiceID}'),0) 
				    + 
				    IFNULL((SELECT SUM(`price`) FROM shaving where date = '{$invoiceID}'),0)
				    +
				    IFNULL((SELECT SUM(`total_remainig`) FROM hosting where end_date = '{$invoiceID}'),0) 
				    +
				    IFNULL((SELECT SUM(`user_pay_before_end_date`) FROM hosting where start_date = '{$invoiceID}'),0) 
				    +
				    IFNULL((SELECT SUM(`price`) FROM `check` where check_date = '{$invoiceID}'),0) 
				    +
				    IFNULL((SELECT SUM(`price`) FROM `other_services` where check_date = '{$invoiceID}'),0)
				    +
				    IFNULL((SELECT SUM(`expenses_value`) FROM `revenu` where date = '{$invoiceID}'),0)
				    )
				    -
				    (
				    IFNULL((SELECT SUM(`expenses_value`) FROM `expenses` where date = '{$invoiceID}'),0)
				    )
				    -- -
				    -- (
				    -- IFNULL((SELECT SUM(`expenses_value`) FROM `export` where date = '{$invoiceID}'),0)
				    -- )
				    -
				    (
				    IFNULL((SELECT SUM(`expenses_value`) FROM `usable` where date = '{$invoiceID}'),0)
				    )
				    -
				    (
				    IFNULL((SELECT SUM(`items_net_total`) FROM reversing_invoice where invoice_date = '{$invoiceID}' AND invoice_parent = 0),0)
				    )
		    ) totalRevnue
			"
		);
		return Response::json($getStoreItemsData);
	}
}