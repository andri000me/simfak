<?php
function unique_multidim_array($array, $key,$unsets = []) {
	$temp_array = array();
	$key_array = array();

	foreach($array as $i => $val) {
		if (!in_array($val->{$key}, $key_array)) {
			//pushing unique value based on key
			$key_array[$i] = $val->{$key};
			//pushing unique value object
			$temp_array[$i] = $val;
		}
	}
	return $temp_array;
}
function get_same_value($array,$value,$key){
	return array_filter($array,function($v,$k) use ($value,$key){
		return $v->{$key} == $value;
	},ARRAY_FILTER_USE_BOTH);
}

function array_copy($array){
	$temp_array = new ArrayObject($array);
	return $temp_array->getArrayCopy();
}
function get_status_message($number){
	$status = (object) ['status'=>'Pending','color'=>'info','number'=>'23','message'=>'Sedang diproses dibagian BMN'];
	if($number == 1){
		$status = (object) ['status'=>'Menunggu Persetujuan','color'=>'info','number'=>'60','message'=>'Surat telah dibuat, akan dilanjutkan ke Kabag Umum'];
	}
	if($number == 2){
		$status = (object) ['status'=>'Di infokan ke Kabag Umum','color'=>'primary','number'=>'75','message'=>'Diterima oleh Kabag Umum, akan segera diproses'];
	}
	if($number == 3){
		$status = (object) ['status'=>'Diterima Kabag Umum','color'=>'success','number'=>'100','message'=>'Disetujui oleh Kabag Umum'];
	}
	if($number == 33){
		$status = (object) ['status'=>'Ditolak Kabag Umum','color'=>'danger','number'=>'99','message'=>'Ditolak oleh Kabag Umum'];
	}
	return $status;
}
