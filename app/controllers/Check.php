<?php

use Carbon\Carbon;
class check extends BaseController{

	public function addNewCheck(){
		$check_type = Input::get("check_type");
		$check_date = Input::get("check_date");
		$price = Input::get("price");
		$client_name = Input::get("client_name");
		$client_mobile = Input::get("client_mobile");
		$gender = Input::get("gender");
		$notice = Input::get("notice");
		$animal_type = Input::get("animal_type");
		$service_invice_id = Input::get("service_invice_id",0);
		$from_invoice = Input::get("from_invoice",0);
		$service_name = Input::get("service_name",0);
		$table_name = Input::get("table_name",0);
		
		$rules = [
			"check_date" => "required|date_format:Y-m-d",
			"client_name" => "required",
			"client_mobile" => "required",
			"animal_type" => "required",
			"check_type" => "required",
		];

		$messages = [
			"check_date.required" => "فضلاً ضع تاريخ بدء الخدمة",
			"check_date.date_format" => "صيغة التاريخ غير صحيحة فضلاً ضع التاريخ بالشكل الأتي ( مثال 2016-12-31 )",
			"client_name.required" => "فضلا ضع اسم العميل",
			"client_mobile.required" => "فضلاً ضع رقم موبايل العميل",
			"animal_type.required" => "فضلاً ضع نوع الحيوان",
			// "animal_color.required" => "فضلاً اكتب لون الحيوان"
		];

		if (Auth::user()->users_rights != 4){
			$check_date = Carbon::parse(Carbon::now())->format("Y-m-d");
			unset(
				$rules["check_date"]
			);
		}

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
				$insertData = DB::table("check")
				->where("id","=",Input::get("updated"))
				->update([
					// "check_date" => Carbon::parse($check_date)->format("Y-m-d"),
					"client_name" => $client_name,
					"check_type" => $check_type,
					"client_mobile" => $client_mobile,
					"animal_type" => $animal_type,
					"gender" => $gender,
					// "price" => $price,
					"notice" => $notice,
					"created_by" => Auth::user()->id,
					"updated_at" => Carbon::now()
				]);
				// return $response = Response::json(
				// 	[
				// 		"errorsFounder" => 1,
				// 		"messages"=> ["لا يمكن تعديل هذة البيانات"]
				// 	]
				// );
			}else{
				$insertData = DB::table("check")
				->insertGetId([
					"check_date" => Carbon::parse($check_date)->format("Y-m-d"),
					"client_name" => $client_name,
					"check_type" => $check_type,
					"client_mobile" => $client_mobile,
					"animal_type" => $animal_type,
					"gender" => $gender,
					"price" => $price,
					"notice" => $notice,
					"created_by" => Auth::user()->id,
					"created_at" => Carbon::now()
				]);

				if ($service_invice_id != 0){
					if ($service_invice_id != 0){
					$insertLink = DB::table("sell_invoice_with_service")->insert(["invoice_id" => $service_invice_id , "service_id" => $insertData , "service_name" => $service_name , "table_name" => $table_name , "price" => $price ,"created_by" => Auth::user()->id,"created_at" => Carbon::now()]);
				}
				}
			}
			if ($insertData){
				if (Input::get("updated") && !empty(Input::get("updated"))){
					return $response = Response::json(
					[
						"errorsFounder" => 0,
						"messages"=> "تم إدخال البيانات بنجاح",
						"ServiceCode" => Input::get("updated")
					]
				);
				}else{
					return $response = Response::json(
						[
							"errorsFounder" => 0,
							"messages"=> "تم إدخال البيانات بنجاح",
							"ServiceCode" => $insertData
						]
					);
				}
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

	public function getCheckServices (){
		$getStoreItemsData = DB::table("check")
		->select(
			DB::raw("CONCAT('C',check.id)"),
			"check.client_name",
			"check.client_mobile",
			"check.animal_type",
			"check.check_date",
			"check.price"
		);

		return Datatables::of($getStoreItemsData)->make();
	}

	public function getCheckingByID(){
		$invoiceID = str_replace("C","",Input::get("invoiceID"));
		$getStoreItemsData = DB::table("check")->where("id","=",$invoiceID)->first();
		return Response::json($getStoreItemsData);
	}
}