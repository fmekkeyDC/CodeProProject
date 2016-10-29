<?php 
class servicesController extends BaseController {
	protected $public_path;
	protected $system_name;
	protected $system_lang;
	protected $tpl_name;
	protected $userdata;


	public function __construct(){
		$this->public_path = "public/layout/";
		$this->system_name = "CodePro|MyZoo project";
		$this->system_lang = "AR";
		$this->tpl_name = "content";
		$this->userdata = Auth::user();
	}


	public function getAppsData(){
		if (Auth::user()->id == 1){
			$getChildren = DB::table("applications")->where("app_active","=",1)->where("parent","!=",0)->where("parent","!=",0)->get();
			$apps_child_lists = [];
			foreach($getChildren as $childs){
				$apps_child_lists [] = $childs->parent;
			}
			$getParent = DB::table("applications")->where("app_active","=",1)->where("parent","=",0)->orderBy("sort","ASC")->get();
		}else{
			$getUserApps = DB::table("users")->where("id","=",$this->userdata->id)->select("users_apps")->first();
			$getAppsQuery = unserialize($getUserApps->users_apps);
			$getChildren = DB::table("applications")->where("app_active","=",1)->where("parent","!=",0)->whereIn("id",$getAppsQuery)->get();
			$apps_child_lists = [];
			foreach($getChildren as $childs){
				$apps_child_lists [] = $childs->parent;
			}
			$getParent = DB::table("applications")->where("app_active","=",1)->where("parent","=",0)->orderBy("sort","ASC")->whereIn("id",$apps_child_lists)->get();
		}
		return ["parent" => $getParent,"children" => $getChildren];
	}
	
}

