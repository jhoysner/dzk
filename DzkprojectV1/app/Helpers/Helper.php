<?php

namespace App\Helpers;

use App\Params;

class Helper {

	public static function getPaginate()
	{
		$paginate = Params::where('key','=','search_paginate')->first();
		return $paginate->val;
	}


}
