<?php

use Carbon\Carbon;

class itemsGroupController extends BaseController {

	public function addNewItemGroups(){
		$item_type_name = Input::get("item_type_name");

		$rules = [
			"item_type_name" => "required|unique:items_type_definer,item_type_name",
		];

		$messages = [
			"item_type_name.required" => "فضلاً ضع اسم نوع الصنف",
			"item_type_name.unique" => "يوجد نوع صنف بنفس الإسم",

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
			$insertData = DB::table("items_type_definer")
			->insert([
				"item_type_name" => $item_type_name,
				"created_by" => Auth::user()->id,
				"created_at" => Carbon::now()
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

	public function EditItemGroups(){
		$id = Input::get("id");
		$item_type_name = Input::get("item_type_name");

		$rules = [
			"item_type_name" => "required",
			"id" => "required|exists:items_type_definer,id",
		];

		$messages = [
			"item_type_name.required" => "فضلاً ضع اسم نوع الصنف",
			// "item_type_name.unique" => "يوجد نوع صنف بنفس الإسم",
			"id.required" => "خطأ بالمعرف",
			"id.exists" => "معرف النوع غير موجود",

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
			$insertData = DB::table("items_type_definer")
			->where("id","=",$id)
			->update([
				"item_type_name" => $item_type_name,
				"created_by" => Auth::user()->id,
				"updated_at" => Carbon::now()
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
}