<?php

namespace App\Helpers;

use App\Params;

class Helper {

	public static function getPaginate()
	{
		$paginate = Params::where('key','=','search_paginate')->first();
		return $paginate->val;
	}

	public static function getCoordenateDefault()
    {
		$param = Params::where('key','coordenates_default')->first();
    	return $param;	
    }

    public static function getSearchRange()
    {
    	$param = Params::where('key','search_distance_ranges')->first();
    	return $param;
    }


}
