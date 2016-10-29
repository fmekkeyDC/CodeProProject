<?php
use Carbon\Carbon;
class shaving extends BaseController{

	public function addNewShavingService(){
		$date = Input::get("date");
		$client_name = Input::get("client_name");
		$service_type = Input::get("service_type");
		$client_mobile = Input::get("client_mobile");
		$gender = Input::get("gender");
		$notice = Input::get("notice");
		$animal_type = Input::get("animal_type");
		$animal_type_2 = Input::get("animal_type_2");
		$animal_type_token = "";
		$discount_price = Input::get("discount_price",0);
		$service_invice_id = Input::get("service_invice_id",0);
		$from_invoice = Input::get("from_invoice",0);
		$service_name = Input::get("service_name",0);
		$table_name = Input::get("table_name",0);

		if ($animal_type){
			$animal_type_token = $animal_type;
			$getServicesPriceList = DB::table("services_definer")
			->where("service_plan","=",6)
			->where("id","=",$animal_type)
			->first();
		}else{
			$animal_type_token = $animal_type_2;
			$getServicesPriceList = DB::table("services_definer")
			->where("service_plan","=",5)
			->where("id","=",$animal_type_2)
			->first();
		}

		$price = $getServicesPriceList->service_price - $discount_price;


		$rules = [
			"date" => "required|date_format:Y-m-d",
			"client_name" => "required",
			"client_mobile" => "required",
			"animal_type" => "required_if:animal_type_2,''",
			"animal_type_2" => "required_if:animal_type,''",
		];

		$messages = [
			"date.required" => "فضلاً ضع تاريخ بدء الخدمة",
			"date.date_format" => "صيغة التاريخ غير صحيحة فضلاً ضع التاريخ بالشكل الأتي ( مثال 2016-12-31 )",
			"client_name.required" => "فضلا ضع اسم العميل",
			"client_mobile.required" => "فضلاً ضع رقم موبايل العميل",
			"animal_type.required" => "فضلاً ضع نوع الحيوان",
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
				$insertData = DB::table("shaving")
				->where("id","=",Input::get("updated"))
				->update([
					// "date" => Carbon::parse($date)->format("Y-m-d"),
					"client_name" => $client_name,
					"service_type" => $service_type,
					"client_mobile" => $client_mobile,
					"animal_type" => $animal_type_token,
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
				$insertData = DB::table("shaving")
				->insertGetId([
					"date" => Carbon::parse($date)->format("Y-m-d"),
					"client_name" => $client_name,
					"client_mobile" => $client_mobile,
					"service_type" => $service_type,
					"animal_type" => $animal_type_token,
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
				return $response = Response::json(
					[
						"errorsFounder" => 0,
						"messages"=> "تم إدخال البيانات بنجاح",
						"ServiceCode" => $insertData
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

	public function getShavingServices (){
		$getStoreItemsData = DB::table("shaving")
		->join("services_definer","services_definer.id","=","shaving.animal_type")
		->select(
			DB::raw("CONCAT('C',shaving.id)"),
			"shaving.client_name",
			"shaving.client_mobile",
			"services_definer.service_name",
			"shaving.date",
			"shaving.price"
		);

		return Datatables::of($getStoreItemsData)->make();
	}

	public function getShavingByID(){
		$invoiceID = str_replace("C","",Input::get("invoiceID"));
		$getStoreItemsData = DB::table("shaving")->where("id","=",$invoiceID)->first();
		return Response::json($getStoreItemsData);
	}
}