<?php 

use Carbon\Carbon;

class usersController extends BaseController {

	public function addNewUser () {
		$username = Input::get("username");
		$users_apps = Input::get("users_apps");
		$userpassword = Input::get("userpassword");
		$confuserpassword = Input::get("confuserpassword");
		$users_rights = Input::get("users_rights");

		$rules = [
			"username" => "required|unique:users,username",
			"userpassword" => "required",
			"confuserpassword" => "required|same:userpassword",
			"users_rights" => "required",
			"users_apps" => "required",
		];

		$messages = [
			"username.required" => "فضلاً ضع اسم المستخدم",
			"username.unique" => "يوجد مستخدم بنفس الإسم",
			"userpassword.required" => "فضلاً ضع كلمة المرور للمستخدم",
			"confuserpassword.same" => "كلمة المرور غير مطابقة",
			"confuserpassword.required" => "فضلاً أكد كلمة المرور",
			"users_rights.required" => "فضلا حدد التطبيقات الخاصة بالمستخدم",
			"users_apps.required" => "فضلا حدد صلاحية المستخدم",
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
			$insertData = DB::table("users")
			->insert([
				"username" => $username,
				"password" => Hash::make($userpassword),
				"users_apps" => serialize($users_apps),
				// "created_by" => User::find(1)->id,
				"created_at" => Carbon::now(),
				"users_rights" => $users_rights,
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

	public function getUsersTable(){
		$getUsersTableQuery = DB::table("users")->select("id","username","users_apps","users_rights")->get();
		return Response::json($getUsersTableQuery);
	}

	public function deleteApp () {
		$id = Input::get("id");

		$rules = [
			"id" => "required|integer|exists:users,id",
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
			$updateData = DB::table("users")
			->where("id","=",$id)
			->update([
				"users_status" => 2,
				// "created_by" => User::find(1)->id,
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

	public function updateUsers(){
		$id = Input::get("id");
		$username = Input::get("username");
		$userpassword = Input::get("userpassword");
		$app_type = Input::get("app_type");
		$newPassword = Input::get("newPassword");

		$rules = [
			"id" => "required|integer|exists:users,id",
			"username" => "required",
			"app_type" => "required",
		];

		$messages = [
			"id.required" => "معرف التطبيق غير موجود",
			"id.integer" => "خطأ في نوع المعرف",
			"id.exists" => "المعرف غير موجود",
			"username.required" => "فضلاً ضع اسم التطبيق",
			"app_type.required" => "فضلاً ضع مسار التوجيه للتطبيق",
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
			if ($newPassword != ""){
				$updateData = DB::table("users")
				->where("id","=",$id)
				->update([
					"username" => $username,
					"users_rights" => $app_type,
					"password" => Hash::make($newPassword),
					"users_apps" => serialize($userpassword),
					"updated_at" => Carbon::now(),
				]);
			}else{
				$updateData = DB::table("users")
				->where("id","=",$id)
				->update([
					"username" => $username,
					"users_rights" => $app_type,
					"users_apps" => serialize($userpassword),
					"updated_at" => Carbon::now(),
				]);
			}

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