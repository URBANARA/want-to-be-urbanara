#!/usr/bin/php
<?php

/**
 * @file
 * Contains class \urbanara\generators\ListGenerator.
 */
namespace urbanara\generators;
use Exception;

/**
 * Generates ordered list of elements based on given interval
 */
class ListGenerator {

	private $seenArr = array();

	/**
	 * Sort the given list of elements
	 * @params array of numbers
	 * @response sorted array
	 */
	public function sortList($sortMe) {
		if(count($sortMe) <= 0) return array();
		return $this->divideList($sortMe);
	}

	/**
	 * Group array elements based on given interval
	 * @params array of numbers
	 * @response sorted array
	 */
	public function groupByInterval($sortedArr,$givenRange) {
		$result = $subres = array();
		$rangeArr = array(0,0);

		foreach($sortedArr as $elem) {
			$range = $givenRange;
			if($this->checkRange($elem,$rangeArr)) array_push($subres,$elem);
			else {
				if(count($subres) > 0) {
					array_push($result,$subres);
					$subres = array();
				}
				$rangeArr = $this->createRange($elem,$range);
				array_push($subres,$elem);
			}
		}
		if(count($subres) > 0) array_push($result,$subres);
		return $result;
	}

	/**
	 * Check if non-numeric values provided in the list
	 * @params array of numbers
	 * @response
	 */
	private function isNumericFound($num) {
		if(in_array($num, $this->seenArr) || $num === 0) return;
		if (filter_var($num, FILTER_VALIDATE_INT)) array_push($this->seenArr, $num);
		else throw new Exception("Invalid data supplied in the list");
	}

	/**
	 * Divide the list into equal parts recursively
	 * @params array of numbers
	 * @response
	 */		
	private function divideList($numlist) {
	    if(count($numlist) == 1 ) return $numlist;
	    $mid = count($numlist) / 2;
	    $left = array_slice($numlist, 0, $mid);
	    $right = array_slice($numlist, $mid);
	    $left = $this->divideList($left);
	    $right = $this->divideList($right);
	    return $this->conquerList($left, $right);
	}

	/**
	 * Compare the list elements and returns the sorted list
	 * @params $left array of numbers, $right array of numbers
	 * @response sorted array $result
	 */
	private function conquerList($left,$right) {
	    $result=array();
	    $leftIndex=$rightIndex=0;
	    while($leftIndex<count($left) && $rightIndex<count($right)) {
	        if($left[$leftIndex]>$right[$rightIndex]) {
	        	$this->isNumericFound($right[$rightIndex]);
	            $result[]=$right[$rightIndex];
	            $rightIndex++;
	        } else {
	        	$this->isNumericFound($left[$leftIndex]);
	            $result[]=$left[$leftIndex];
	            $leftIndex++;
	        }
	    }
	    while($leftIndex<count($left)) {
	    	$this->isNumericFound($left[$leftIndex]);
	        $result[]=$left[$leftIndex];
	        $leftIndex++;
	    }
	    while($rightIndex<count($right)) {
	    	$this->isNumericFound($right[$rightIndex]);
	        $result[]=$right[$rightIndex];
	        $rightIndex++;
	    }
	    return $result;
	}

	/**
	 * create range for the given value
	 * @params $val integer value, $rangeArr range defining start & end
	 * @response array
	 */
	private function createRange($val,$range) {
		if(empty($val)) return array(0,0);
		$mod = $val % $range;
		$add = $sub = 1;
		if($val < 0) {
			$range = -1 * $range;
			$add = $sub = -1;
		}
		if($mod === 0) {
			$endPt = $val;
			$startPt = ($endPt - $range) + $add;
		} else {
			$startPt = ($val - $mod) + $add;
			$endPt = ($startPt + $range -$sub);
		}
		return array($startPt, $endPt);
	}	

	/**
	 * Check if given value exists in the given range
	 * @params $val integer value, $rangeArr range defining start & end
	 * @response boolean
	 */
	private function checkRange($val,$rangeArr) {
		list($startPt,$endPt) = $rangeArr;
		if($val < 0) list($startPt,$endPt) = array($rangeArr[1],$rangeArr[0]);
		if($val >= $startPt && $val <= $endPt) return 1;
		return 0;
	}
}
