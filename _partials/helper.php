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