<?php
namespace App\Queries\GridQueries;

use DB;
use User;
use Illuminate\Http\Request;
use App\Queries\GridQueries\Contracts\DataQuery;

class BackendUnactivatedUsersQuery implements DataQuery
{
	public function data($column, $direction)
	{
		$rows = DB::table('users')
				  ->select('id as Id',
						   'name as Name',
						   'mobile as Mobile',
						   'email as Email')
				  ->where('is_activated', '=', 0)
				  ->orderBy($column, $direction)
				  ->get();

		return $rows;
	}

	public function filteredData($column, $direction, $keyword)
	{
		$rows = DB::table('users')
				  ->where('is_activated', 0)
				  ->select('id as Id',
						   'name as Name',
						   'mobile as Mobile',
						   'email as Email')
				  ->where(function($query) use($keyword)
			      {
			          $query
			          ->where('name', 'like binary', '%' . $keyword . '%')
					  ->orWhere('mobile', 'like binary', '%' . $keyword . '%')
					  ->orWhere('email', 'like binary', '%' . $keyword . '%');
			      })
				  ->orderBy($column, $direction)
				  ->get();
		
		return $rows;
	}
}