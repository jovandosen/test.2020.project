<?php

function quick_sort($my_array)
{
	$loe = $gt = array();

	if(count($my_array) < 2){
		return $my_array;
	}

	$pivot_key = key($my_array); // key = 0 | key = 0 | key = 0 | key = 0 | key = 0 | key = 0

	echo $pivot_key;

	$pivot = array_shift($my_array); // pivot = 3 | pivot = 1 | pivot = 5 | pivot = 8 | pivot = 7 | pivot = 10

	echo $pivot;

	// my_array = [5, 1, 4, 2, 8, 10, 9, 7, 6] | my_array = [2] | my_array = [4, 8, 10, 9, 7, 6] | my_array = [10, 9, 7, 6] | my_array = [6] | my_array = [9]

	foreach($my_array as $val){ 

		if($val <= $pivot){

			$loe[] = $val; // loe = [1, 2] | loe = [4] | loe = [7, 6] | loe = [6] | loe = [9]

		}elseif ($val > $pivot){

			$gt[] = $val; // gt = [5, 4, 8, 10, 9, 7, 6] | gt = [2] | gt = [8, 10, 9, 7, 6] | gt = [10, 9]

		}
	}

	return array_merge(quick_sort($loe),array($pivot_key=>$pivot),quick_sort($gt));
}

// $my_array = array(3, 0, 2, 5, -1, 4, 1);

// $my_array = [3, 5, 1, 4, 2, 8, 10, 9, 7, 6];

$my_array = ['e', 'a', 'd', 'b', 'c'];

echo 'Original Array : '.implode(',',$my_array).'\n';

$my_array = quick_sort($my_array);

echo 'Sorted Array : '.implode(',',$my_array);

?>