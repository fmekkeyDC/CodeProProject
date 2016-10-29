<?php 

use Carbon\Carbon;

class applicationController extends BaseController {
	public function __construct(){

	}

	public function getAppsTable() {
		return Response::json(HomeController::getAppsParents("all"));
	}


	public function addNewApplication() {
		$app_name = Input::get("app_name");
		$parent = Input::get("parent");
		$app_route = Input::get("app_route");
		$icon = Input::get("icon");
		$app_active = Input::get("app_active");
		$sort = Input::get("sort");

		$rules = [
			"app_name" => "required|unique:applications,app_name",
			"app_route" => "required|unique:applications,app_route",
			"app_active" => "required|integer",
			"sort" => "required|integer",
		];

		$messages = [
			"app_name.required" => "فضلاً ضع اسم التطبيق",
			"app_name.unique" => "يوجد تطبيق بنفس الإسم",
			"app_route.required" => "فضلاً ضع مسار التوجيه للتطبيق",
			"app_route.unique" => "يوجد تطبيق بنفس مسار التوجيه",
			"app_active.required" => "فضلاً حدد حالة التطبيق",
			"app_active.integer" => "يجب ان تكون حالة التطبيق مكتوبة في شكل رقمي",
			"sort.required" => "فضلا ضع الترتيب",
			"sort.integer" => "يجب ان تكون الترتيب مكتوبة في شكل رقمي",

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
			$insertData = DB::table("applications")
			->insert([
				"app_name" => $app_name,
				"app_route" => $app_route,
				"parent" => $parent,
				"icon" => $icon,
				"app_active" => $app_active,
				"created_by" => User::find(1)->id,
				"created_at" => Carbon::now(),
				"sort" => $sort,
			]);

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

	public function deleteApp () {
		$id = Input::get("id");

		$rules = [
			"id" => "required|integer|exists:applications,id",
		];

		$messages = [
			"id.required" => "معرف التطبيق غير موجود",
			"id.integer" => "خطأ في نوع المعرف",
			"id.exists" => "المعرف غير موجود",
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
			$updateData = DB::table("applications")
			->where("id","=",$id)
			->update([
				"app_active" => 2,
				"created_by" => User::find(1)->id,
				"updated_at" => Carbon::now(),
			]);

			if ($updateData){
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

	public function updateApp () {
		$id = Input::get("id");
		$app_name = Input::get("app_name");
		$parent = Input::get("app_type");
		$app_route = Input::get("app_route");
		$icon = Input::get("icon");
		$sort = Input::get("sort");

		$rules = [
			"id" => "required|integer|exists:applications,id",
			"app_name" => "required",
			"app_route" => "required",
			"sort" => "required|integer",
		];

		$messages = [
			"id.required" => "معرف التطبيق غير موجود",
			"id.integer" => "خطأ في نوع المعرف",
			"id.exists" => "المعرف غير موجود",
			"app_name.required" => "فضلاً ضع اسم التطبيق",
			"app_route.required" => "فضلاً ضع مسار التوجيه للتطبيق",
			"sort.required" => "فضلا ضع الترتيب",
			"sort.integer" => "يجب ان تكون الترتيب مكتوبة في شكل رقمي",
		];

		if ($parent == 0){
			unset($rules["app_route"]);
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
			$updateData = DB::table("applications")
			->where("id","=",$id)
			->update([
				"app_active" => 1,
				"app_name" => $app_name,
				"app_route" => $app_route,
				"parent" => $parent,
				"icon" => $icon,
				"created_by" => User::find(1)->id,
				"updated_at" => Carbon::now(),
				"sort" => $sort
			]);

			if ($updateData){
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
}