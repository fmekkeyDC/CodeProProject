<?php
use Carbon\Carbon;
class shower extends BaseController{

	public function addNewShowerService(){
		$date = Input::get("date");
		$client_name = Input::get("client_name");
		$client_mobile = Input::get("client_mobile");
		$gender = Input::get("gender");
		$service_type = Input::get("service_type");
		$notice = Input::get("notice");
		$animal_type = Input::get("animal_type");
		$discount_price = Input::get("discount_price",0);
		$service_invice_id = Input::get("service_invice_id",0);
		$from_invoice = Input::get("from_invoice",0);
		$service_name = Input::get("service_name",0);
		$table_name = Input::get("table_name",0);
		
		$getServicesPriceList = DB::table("services_definer")
		->where("service_plan","=",4)
		->where("id","=",$animal_type)
		->first();

		$price = $getServicesPriceList->service_price - $discount_price;

		if ($service_type == 2){
			$price = 10 - $discount_price;
		}

		$rules = [
			"date" => "required|date_format:Y-m-d",
			"client_name" => "required",
			"client_mobile" => "required",
			"animal_type" => "required",
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
				$insertData = DB::table("shower")
				->where("id","=",Input::get("updated"))
				->update([
					// "date" => Carbon::parse($date)->format("Y-m-d"),
					"client_name" => $client_name,
					"client_mobile" => $client_mobile,
					"animal_type" => $animal_type,
					"gender" => $gender,
					"service_type" => $service_type,
					// "price" => $price,
					"notice" => $notice,
					"created_by" => Auth::user()->id,
					"updated_at" => Carbon::now()
				]);
			}else{
				$insertData = DB::table("shower")
				->insertGetId([
					"date" => Carbon::parse($date)->format("Y-m-d"),
					"client_name" => $client_name,
					"client_mobile" => $client_mobile,
					"animal_type" => $animal_type,
					"gender" => $gender,
					"service_type" => $service_type,
					"price" => $price,
					"notice" => $notice,
					"created_by" => Auth::user()->id,
					"created_at" => Carbon::now()
				]);
				if ($service_invice_id != 0){
					$insertLink = DB::table("sell_invoice_with_service")->insert(["invoice_id" => $service_invice_id , "service_id" => $insertData , "service_name" => $service_name , "table_name" => $table_name , "price" => $price ,"created_by" => Auth::user()->id,"created_at" => Carbon::now()]);
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

	public function getShowerServices (){
		$getStoreItemsData = DB::table("shower")
		->join("services_definer","services_definer.id","=","shower.animal_type")
		->select(
			DB::raw("CONCAT('C',shower.id)"),
			"shower.client_name",
			"shower.client_mobile",
			"services_definer.service_name",
			"shower.date",
			"shower.price"

		);

		return Datatables::of($getStoreItemsData)->make();
	}

	public function getShowerByID(){
		$invoiceID = str_replace("C","",Input::get("invoiceID"));
		$getStoreItemsData = DB::table("shower")->where("id","=",$invoiceID)->first();
		return Response::json($getStoreItemsData);
	}
}