<?php

use Carbon\Carbon;
class otherServices extends BaseController{
	public function addNewOtherServices(){
		$service_name = Input::get("service_name");
		$check_date = Input::get("check_date");
		$price = Input::get("price");
		$client_name = Input::get("client_name");
		$client_mobile = Input::get("client_mobile");
		$gender = Input::get("gender");
		$notice = Input::get("notice");
		$animal_type = Input::get("animal_type");
		$service_invice_id = Input::get("service_invice_id",0);
		$from_invoice = Input::get("from_invoice",0);
		$service_name_modal = Input::get("service_name_modal",0);
		$table_name = Input::get("table_name",0);

		
		$rules = [
			"check_date" => "required|date_format:Y-m-d",
			"client_name" => "required",
			"client_mobile" => "required",
			"animal_type" => "required",
			"service_name" => "required",
			"price" => "required",
		];

		$messages = [
			"check_date.required" => "فضلاً ضع تاريخ بدء الخدمة",
			"check_date.date_format" => "صيغة التاريخ غير صحيحة فضلاً ضع التاريخ بالشكل الأتي ( مثال 2016-12-31 )",
			"client_name.required" => "فضلا ضع اسم العميل",
			"client_mobile.required" => "فضلاً ضع رقم موبايل العميل",
			"animal_type.required" => "فضلاً ضع نوع الحيوان",
			"service_name.required" => "فضلاً ضع اسم الخدمة",
			"price.required" => "فضلاً ضع سعر الخدمة",
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
				$insertData = DB::table("other_services")
				->where("id","=",Input::get("updated"))
				->update([
					// "check_date" => Carbon::parse($check_date)->format("Y-m-d"),
					"client_name" => $client_name,
					"service_name" => $service_name,
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
				$insertData = DB::table("other_services")
				->insertGetId([
					"check_date" => Carbon::parse($check_date)->format("Y-m-d"),
					"client_name" => $client_name,
					"service_name" => $service_name,
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
					$insertLink = DB::table("sell_invoice_with_service")->insert(["invoice_id" => $service_invice_id , "service_id" => $insertData , "service_name" => $service_name_modal , "table_name" => $table_name , "price" => $price ,"created_by" => Auth::user()->id,"created_at" => Carbon::now()]);
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

	public function getOtherServices (){
		$getStoreItemsData = DB::table("other_services")
		->select(
			DB::raw("CONCAT('C',other_services.id)"),
			"other_services.client_name",
			"other_services.service_name",
			"other_services.client_mobile",
			"other_services.animal_type",
			"other_services.check_date",
			"other_services.price"
		);

		return Datatables::of($getStoreItemsData)->make();
	}

	public function getOthrtServiceByID(){
		$invoiceID = str_replace("C","",Input::get("invoiceID"));
		$getStoreItemsData = DB::table("other_services")->where("id","=",$invoiceID)->first();
		return Response::json($getStoreItemsData);
	}

	public function getOtherServicesNames(){
		$keyword = Input::get("q");
		$page = Input::get("page");
		$limit = 10;
		if (isset($_GET["page"])) { 
			$page  = $_GET["page"]; 
		} else { 
			$page=1; 
		}
		$start_from = ($page-1) * $limit; 
		
		$searchQuery = DB::table("other_services")->select("id","service_name","price")->where('service_name', 'LIKE', '%'.$keyword.'%')->get();
		return Response::json(["items" => $searchQuery]);
	}
}