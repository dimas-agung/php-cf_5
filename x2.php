<?php

$arrX = [
	'strata 1' => [
		'min' => 1,
		'max' => 10,
	],
	'strata 2' => [
		'min' => 11,
		'max' => 20,
	],
	'strata 3' => [
		'min' => 21,
		'max' => 0,
	],
];

function getClosest($search, $arr) {
	$closest = null;
	$word = null;
	foreach ($arr as $key => $item) {
		if (is_array($item) && count($item) > 0) {
			foreach ($item as $itemKey => $itemVal) {			
				if ($closest === null || abs($search - $closest) > abs($itemVal - $search)) {
					$closest = $itemVal;
					$word = sprintf('Qty %d di dalam %s %s %d', $search, $key, $itemKey, $closest);
				}
			}
		}
	}
	
	return $word . '<pre>' . print_r($arr, true) . '</pre>';
}

echo getClosest(8, $arrX);