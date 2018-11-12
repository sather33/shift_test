<?php
namespace App\Queries\GridQueries;

use DB;
use Illuminate\Http\Request;
use App\Queries\GridQueries\Contracts\DataQuery;

class StoresQuery implements DataQuery
{
	public function data($column, $direction)
	{
		$rows = DB::table('stores')
		          ->select('id as Id',
		          		   'name as Name',
		                   'updated_at as Updated',
		                   'is_showing as 狀態',
		                   'last_updated_by_staff_name as 上次編輯者',
		               	   'last_updated_by_datetime as 上次編輯時間')
		          ->orderBy($column, $direction)
		          ->get();

		return $rows;
	}

	public function filteredData($column, $direction, $keyword)
	{
		$rows = DB::table('stores')
				  ->select('id as Id',
		          		   'name as Name',
		                   'updated_at as Updated',
		                   'is_showing as 狀態',
		                   'last_updated_by_staff_name as 上次編輯者',
		               	   'last_updated_by_datetime as 上次編輯時間')
				  ->where('name', 'like binary', '%' . $keyword . '%')
				  ->orWhere('taiwan_part', 'like binary', '%' . $keyword . '%')
				  ->orWhere('zipcode', 'like binary', '%' . $keyword . '%')
				  ->orWhere('county', 'like binary', '%' . $keyword . '%')
				  ->orWhere('district', 'like binary', '%' . $keyword . '%')
				  ->orWhere('address', 'like binary', '%' . $keyword . '%')
				  ->orWhere('created_at', 'like binary', '%' . $keyword . '%')
				  ->orderBy($column, $direction)
				  ->get();

		return $rows;
	}
}