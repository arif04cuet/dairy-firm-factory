<?php

//
if(!function_exists('where')){
	function where($conditions=[]){
		$where = [];
		if(is_array($conditions)){
			foreach($conditions as $key=>$value){
				if(is_array($value)==false && $value!=''){
					$where[] = [$key, $value];
				}
				else if($key=='date' && is_array($value)){
					foreach($value as $entity=>$date){
						if($date!='' && $entity=='from')
							$where[] = ['date', '>=', $date];
						if($date!='' && $entity=='to')
							$where[] = ['date', '<=', $date];
					}
				}
			}
		}
		return $where;
	}
}

//
if(!function_exists('officeToEntity')){
	function officeToEntity($office_id=false){
		//
		if($office_id){
			$processing_plant = App\Models\ProcessingPlant::where('office_id', $office_id);
			$chilling_plant   = App\Models\ChillingPlant::where('office_id', $office_id);
			//
			if(!$chilling_plant->get()->isEmpty())
				return ['chilling_plant'=>$chilling_plant->first()];
			if(!$processing_plant->get()->isEmpty())
				return ['processing_plant'=>$processing_plant->first()];
		}
	}
}
//
if(!function_exists('clrDensity')){
	function clrDensity($number, $niddle='clr'){
		//
		if($niddle=='clr')
        {
            return (($number - 1) * 1000);
        }
        else if($niddle=='density')
        {
            return (($number / 1000) + 1);
        }
        return 0;
	}
}

//
if(!function_exists('roleId')){
	function roleId($slug='')
	{
		$role = App\Models\Role::where('slug', $slug);
		if($slug && $role->exists()){
			return $role->first()->id;
		}
		else return 0;
	}
}

//
if(!function_exists('DepartmentToProcessingPlat')){
	function DepartmentToProcessingPlat($department_id='')
	{
		if($department_id)
		{
			$department = App\Models\Department::where('id', $department_id)->with('processingPlant');
			if($department_id && $department->exists()){
				return $department->first()->processingPlant;
			}
			return false;
		}
		return false;
	}
}

//
if(!function_exists('paginate')){
	function paginate($model, $where = [], $per_page = null, $page_no = null)
	{
		$model  	  = $model->where($where);
        $total_row    = $model->count();
        
        if($per_page && $page_no){
            $model = $model->skip(($page_no*$per_page)-$per_page)->limit($per_page)->orderBy('id', 'DESC')->get();
        }
        else{
        	$model = $model->orderBy('id', 'DESC')->get();
        }
        //
        $model = $model->toArray();

        return $record = [
            "data"      => $model,
            "page_no"   => $page_no ?? 1,
            "per_page"  => $per_page ?? count($model),
            "total_row" => $total_row,
        ];
	}
}


if(!function_exists('imageUpload')){
	function imageUpload($path, $image_64, $name)
	{
		$extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf
		//
		$extension = str_replace('+xml', '', $extension);
		//
		$replace = substr($image_64, 0, strpos($image_64, ',')+1); 
		//
		$image = str_replace($replace, '', $image_64); 
		//
		$image = str_replace(' ', '+', $image); 
		//
		Storage::disk($path)->put($name.'.'.$extension, base64_decode($image));
		//
		return 'storage/'.($path)."/".$name.'.'.$extension;
	}
}

if(!function_exists('mkVoucherNo')){
	function mkVoucherNo($model, $key=null, $niddle='')
	{
		$invoice_no = date("Ymd{$niddle}000001");
		//
		$key = ($key ? $key : 'voucher_no');
		//
		$obj = $model->where([$key=>$invoice_no]);
		if(!$obj->get()->isEmpty()){
			$invoice_no = (+($model->orderBy('id', 'DESC')->first()->{$key}) + 1);
		}
		return $invoice_no;
	}
}

if(!function_exists('mkMemberCode')){
	function mkMemberCode($unit_id)
	{	
		$code  = $unit_id;
		//
		if(strlen($unit_id) < 2)
			$code = "0000000".$code;
		else if(strlen($unit_id) < 3)
			$code = "000000".$code;
		else if(strlen($unit_id) < 4)
			$code = "00000".$code;
		else if(strlen($unit_id) < 5)
			$code = "0000".$code;
		else if(strlen($unit_id) < 6)
			$code = "000".$code;
		else if(strlen($unit_id) < 7)
			$code = "00".$code;
		else if(strlen($unit_id) < 8)
			$code = "0".$code;
		//
		$users = (new App\Models\User())->where('username', $code);
		//
		if($users->exists()){
			return ($users->count())."d".$code;
		}
		//
		return $code;
	}
}

if(!function_exists('isRoleSlug'))
{
	function isRoleSlug($slug='')
	{
		if($slug && request()->user()->role_slug) 
		{
			return in_array($slug, collect(request()->user()->role_slug)->toArray());
		}
		return false;

	}
}



