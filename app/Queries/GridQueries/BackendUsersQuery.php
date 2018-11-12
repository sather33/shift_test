<?php
namespace App\Queries\GridQueries;

use DB;
use Illuminate\Http\Request;
use App\Queries\GridQueries\Contracts\DataQuery;

class BackendUsersQuery implements DataQuery
{
	public function data($column, $direction)
	{
		$rows = DB::table('users')
				  ->select('id as Id',
						   'name as Name',
						   'mobile as Mobile',
						   'email as Email',
						   'is_vip as VIP',
						   'is_staff as Staff',
						   'is_admin as Admin')
				  ->where('is_activated', 1)
				  ->orderBy($column, $direction)
				  ->get();

		return $rows;
	}

	public function filteredData($column, $direction, $keyword)
	{
		$rows = DB::table('users')
				  ->select('id as Id',
						   'name as Name',
						   'mobile as Mobile',
						   'email as Email',
						   'is_vip as VIP',
						   'is_staff as Staff',
						   'is_admin as Admin')
				  ->where('is_activated', 1)
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