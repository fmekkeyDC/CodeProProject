<?php

use Carbon\Carbon;
class Hosting extends BaseController{

	public function addNewHostingServices(){
		$start_date = Input::get("start_date");
		$client_name = Input::get("client_name");
		$mobile_number = Input::get("mobile_number");
		$animal_type = Input::get("animal_type");
		$animal_name = Input::get("animal_name");
		$animal_color = Input::get("animal_color");
		$gender = Input::get("gender");
		$notice = Input::get("notice");
		$price_under_reciept = Input::get("price_under_reciept",0);


		$getServicesPriceList = DB::table("services_definer")
		->where("service_type","=",1)
		->where("id","=",$animal_type)
		->first();

		$rules = [
			"start_date" => "required|date_format:Y-m-d",
			"client_name" => "required",
			"mobile_number" => "required",
			"animal_type" => "required",
			// "animal_color" => "required",
		];

		$messages = [
			"start_date.required" => "فضلاً ضع تاريخ بدء الإستضافة",
			"start_date.date_format" => "صيغة التاريخ غير صحيحة فضلاً ضع التاريخ بالشكل الأتي ( مثال 2016-12-31 )",
			"client_name.required" => "فضلا ضع اسم العميل",
			"mobile_number.required" => "فضلاً ضع رقم موبايل العميل",
			"animal_type.required" => "فضلاً ضع نوع الحيوان",
			// "animal_color.required" => "فضلاً اكتب لون الحيوان"
		];

		if (Auth::user()->users_rights != 4){
			$start_date = Carbon::parse(Carbon::now())->format("Y-m-d");
			unset(
				$rules["start_date"]
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
				$getLastHostingData = DB::table("hosting")
				->select("hosting.user_pay_before_end_date","hosting.notice","hosting.created_by","users.username")
				->join("users","users.id","=","hosting.created_by")
				->where("hosting.id","=",Input::get("updated"))->first();
				$insertData = DB::table("hosting")
				->where("id","=",Input::get("updated"))
				->update([
					"user_pay_before_end_date" => $price_under_reciept,
					"notice" => " {$getLastHostingData->notice} \n تم تعديل قيمة مبلغ تحت الحساب من {$getLastHostingData->user_pay_before_end_date} إلي {$price_under_reciept} في ".Carbon::now() . " بواسطة المستخدم {$getLastHostingData->username}",
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
				$insertData = DB::table("hosting")
				->insertGetId([
					"start_date" => Carbon::parse($start_date)->format("Y-m-d"),
					"client_name" => $client_name,
					"mobile_number" => $mobile_number,
					"animal_type" => $animal_type,
					"animal_name" => $animal_name,
					"animal_color" => $animal_color,
					"gender" => $gender,
					"notice" => $notice,
					"user_pay_before_end_date" => $price_under_reciept,
					"price_per_day" => $getServicesPriceList->service_price,
					"discount_day_percent" => $getServicesPriceList->weak_discount,
					"discount_month_percent" => $getServicesPriceList->month_discount,
					"created_by" => Auth::user()->id,
					"created_at" => Carbon::now()
				]);
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

	public function getHostingServicesItems(){
		$getStoreItemsData = DB::table("hosting")
		->select(
			DB::raw("CONCAT('C',hosting.id)"),
			"hosting.client_name",
			"hosting.mobile_number",
			"hosting.animal_name",
			"hosting.start_date",
			"hosting.end_date"
		);

		return Datatables::of($getStoreItemsData)->make();
	}

	public function getHostingByID () {
		$invoiceID = str_replace("C","",Input::get("invoiceID"));
		$getStoreItemsData = DB::table("hosting")->where("id","=",$invoiceID)->first();
		return Response::json($getStoreItemsData);
	}


	public function exitHosting() {
		$invoiceID = Input::get("invoiceID");
		$exitDate = Input::get("exitDate");
		$exitDateValue = Carbon::parse(date("Y-m-d"))->format("Y-m-d");

		if (Auth::user()->users_rights == 4){
			$exitDateValue = Carbon::parse($exitDate)->format("Y-m-d");
		}
		
		$rules = [
			"invoiceID" => "required|exists:hosting,id",
		];

		$messages = [
			"invoiceID.required" => "كود الخدمة غير متوفر فضلاً حاول مرة اخري او قم بمراسلة كودبرو",
			"invoiceID.exists" => "عفواً كود الخدمة غير صحيح فضلاً تأكد من اختيار العميل",
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

			$checkEndDateForThisHost = DB::table('hosting')->where("id","=",$invoiceID)->select("end_date","orderTotalValue","user_pay_before_end_date")->first();

			if (!empty($checkEndDateForThisHost->end_date) || $checkEndDateForThisHost->end_date != null){
				return $response = Response::json(
					[
						"errorsFounder" => 1,
						"messages"=>["هذة الزيارة تم إغلاقها من قبل"]
					]	
				);
			}else{
				$setExitDate = DB::table("hosting")->where("id","=",$invoiceID)->update(
					[
						"end_date" => $exitDateValue
					]	
				);

				$getObjectData = DB::table("hosting")
				->where("id","=",$invoiceID)
				->select(
					"start_date",
					"end_date",
					"discount_day_percent",
					"discount_month_percent",
					"price_per_day"
					)
				->first();

				$start_date = Carbon::parse($getObjectData->start_date);
				$end_date = Carbon::parse($getObjectData->end_date);

				$difference = $start_date->diff($end_date);
				$numOfmonths = $difference->m;
				$numOfDays = $difference->days;
				$numOfWeeks = floor($numOfDays / 7);
				$netWeeks = floor($numOfWeeks - $numOfmonths * 4 );
				$netWeeksToDays = $netWeeks * 7 ;
				$netMonthToDays = $numOfmonths * 30;
				$netDays =  $numOfDays - ($netWeeksToDays + $netMonthToDays)  ;
				if ($netWeeksToDays == 0){
					$netDays = $numOfDays;
				}

				if ($netDays <= 0){
					$netDays = 0;
				}

				$getMonthPriceAfterDiscount = ($getObjectData->discount_month_percent / 100) * ($getObjectData->price_per_day * $numOfmonths * 30);
				$getWeeksPriceAfterDiscount = $getObjectData->discount_day_percent / 100 * ($getObjectData->price_per_day * $netWeeks * 7);
				$getNetPriceAfterDiscount = $netDays * $getObjectData->price_per_day;
				$TotalMonth = ($getObjectData->price_per_day * $numOfmonths * 30) - $getMonthPriceAfterDiscount;
				$weekPrice = ($getObjectData->price_per_day * $netWeeks * 7) - $getWeeksPriceAfterDiscount;

				$setInvoicePrice = DB::table("hosting")->where("id","=",$invoiceID)->update(
					[
						"totalDays" => $numOfDays , 
						"totalWeeks" => $numOfWeeks , 
						"months" => $numOfmonths , 
						"netDays" => $netDays,
						"netWeeks" => $netWeeks,
						"monthPrice" => ($getObjectData->price_per_day * $numOfmonths * 30) - $getMonthPriceAfterDiscount,
						"weekPrice" => ($getObjectData->price_per_day * $netWeeks * 7) - $getWeeksPriceAfterDiscount,
						"NetPrice" => $getNetPriceAfterDiscount,
						"orderTotalValue" => ($getNetPriceAfterDiscount + $weekPrice) + $TotalMonth, 
						"total_remainig" => ($getNetPriceAfterDiscount + $weekPrice) + $TotalMonth - ($checkEndDateForThisHost->user_pay_before_end_date) ,
						"orderBeforeDiscount" => $numOfDays * $getObjectData->price_per_day,
						"total_invoice_order" => ($getNetPriceAfterDiscount + $weekPrice) + $TotalMonth,
						"created_by" => Auth::user()->id,
						"updated_at" => Carbon::now()
					]	
				);


				if ($setInvoicePrice){
					return $response = Response::json(
						[
							"errorsFounder" => 0,
							"messages"=> "تم إدخال البيانات بنجاح",
							"ServiceCode" => $invoiceID
						]
					);
				}else{
					return $response = Response::json(
						[
							"errorsFounder" => 1,
							"messages"=> ["خطأ في الإتصال بقاعدة البيانات"]
						]
					);
				}
			}
		}
	}

	public function exitHousing(){
		return ;
	}

	public function paymentRecord(){
		$invoiceID = Input::get("invoiceID");
		$total_invoice_pay = Input::get("total_invoice_pay");
		$total_invoice_change = Input::get("total_invoice_change");
		$invoice_remaining = Input::get("invoice_remaining");
		
		$rules = [
			"invoiceID" => "required|exists:hosting,id",
			"total_invoice_pay" => "required",
			"total_invoice_change" => "required",
		];

		$messages = [
			"invoiceID.required" => "كود الخدمة غير متوفر فضلاً حاول مرة اخري او قم بمراسلة كودبرو",
			"invoiceID.exists" => "عفواً كود الخدمة غير صحيح فضلاً تأكد من اختيار العميل",
			"total_invoice_pay.required" => "فضلا ضع المبلغ المدفوع",
			"total_invoice_change.required" => "الباقي غير محدد"
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

			$checkEndDateForThisHost = DB::table('hosting')->where("id","=",$invoiceID)->select("total_invoice_pay","user_pay_before_end_date")->first();
			
			// if (!empty($checkEndDateForThisHost->total_invoice_pay) || $checkEndDateForThisHost->total_invoice_pay != null){
			// 	return $response = Response::json(
			// 		[
			// 			"errorsFounder" => 1,
			// 			"messages"=>["تم سداد المبلغ المستحق لهذة الخدمة"]
			// 		]	
			// 	);
			// }else{
				$setInvoicePrice = DB::table("hosting")->where("id","=",$invoiceID)->update(
					[
						"total_invoice_pay" => $total_invoice_pay + $checkEndDateForThisHost->user_pay_before_end_date, 
						"total_invoice_change" => $total_invoice_change , 
						"created_by" => Auth::user()->id,
						"updated_at" => Carbon::now()
					]	
				);


				if ($setInvoicePrice){
					return $response = Response::json(
						[
							"errorsFounder" => 0,
							"messages"=> "تم إدخال البيانات بنجاح",
							"ServiceCode" => $invoiceID
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
			// }
		}
	}


	public function setRemainPrice(){
		$invoiceID = Input::get("invoiceID");

		$rules = [
			"invoiceID" => "required|exists:hosting,id"
		];

		$messages = [
			"invoiceID.required" => "كود الخدمة غير متوفر فضلاً حاول مرة اخري او قم بمراسلة كودبرو",
			"invoiceID.exists" => "عفواً كود الخدمة غير صحيح فضلاً تأكد من اختيار العميل"
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

			$checkEndDateForThisHost = DB::table('hosting')->where("id","=",$invoiceID)->select("total_invoice_order")->first();
			$setInvoicePrice = DB::table("hosting")->where("id","=",$invoiceID)->update(
					[
						"total_invoice_pay" => $checkEndDateForThisHost->total_invoice_order,
						"total_invoice_change" => 0 , 
						"created_by" => Auth::user()->id,
						"updated_at" => Carbon::now()
					]	
				);


				if ($setInvoicePrice){
					return $response = Response::json(
						[
							"errorsFounder" => 0,
							"messages"=> "تم إدخال البيانات بنجاح",
							"ServiceCode" => $invoiceID
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


	public function getPriceForServices(){
		$id = Input::get("id");
		$data = DB::table("services_definer")->where("id","=",$id)->select("service_price")->first()->service_price;
		return Response::json(["item_price" => $data]);
	}
}