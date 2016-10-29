<?php 

use Carbon\Carbon;

class serviceController extends BaseController {
	public function addNewService() {

		$service_plan = Input::get("service_plan");
		$service_name = Input::get("service_name");
		$service_price = Input::get("service_price");
		$service_type = Input::get("service_type");
		$weak_discount = Input::get("weak_discount");
		$month_discount = Input::get("month_discount");
		$service_notice = Input::get("service_notice");

		if ($service_type == 2){
			$weak_discount = 0;
			$month_discount = 0;
		}

		$rules = [
			"service_plan" => "required",
			"service_name" => "required",
			"service_price" => "required",
			"service_type" => "required",
			"weak_discount" => "required_if:service_type,1",
			"month_discount" => "required_if:service_type,1"
		];

		$messages = [
			"service_plan.required" => "فضلاً اختر نوع الخدة",
			"service_name.required" => "فضلاً ضع اسم الخدمة",
			"service_price.required" => "فضلاً ضع سعر الخدمة",
			"service_type.required" => "فضلاً حدد نوع المبلغ ( يومي - ثابت )",
			"weak_discount.required_if" => "فضلاً حدد نسبة خصم اليوم",
			"month_discount.required_if" => "فضلاً حدد نسبة خصم الشهر"
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
				$insertData = DB::table("services_definer")
				->where("id","=",Input::get("updated"))
				->update([
					"service_name" => $service_name,
					"service_price" => $service_price,
					"service_type" => $service_type,
					"weak_discount" => $weak_discount,
					"month_discount" => $month_discount,
					"service_plan" => $service_plan,
					"service_notice" => $service_notice,
					"created_by" => Auth::user()->id,
					"updated_at" => Carbon::now()
				]);
			}else{
				$insertData = DB::table("services_definer")
				->insert([
					"service_name" => $service_name,
					"service_price" => $service_price,
					"service_type" => $service_type,
					"weak_discount" => $weak_discount,
					"month_discount" => $month_discount,
					"service_plan" => $service_plan,
					"service_notice" => $service_notice,
					"created_by" => Auth::user()->id,
					"created_at" => Carbon::now()
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


	public function getServicesTypes(){
		$getStoreItemsData = DB::table("services_definer")
		->select(
			"services_definer.id",
			DB::raw("
				case  
				   when services_definer.service_plan = 1  then 'استضافة'
				   when services_definer.service_plan = 4  then 'شاور'
				   when services_definer.service_plan = 6  then 'حلاقة'
				end as service_plan 
			"),
			"services_definer.service_name",
			"services_definer.service_price"
		);

		return Datatables::of($getStoreItemsData)->make();

	}



	public function getServiceByID () {
		$invoiceID = Input::get("invoiceID");
		$getStoreItemsData = DB::table("services_definer")->where("id","=",$invoiceID)->first();
		return Response::json($getStoreItemsData);
	}
}