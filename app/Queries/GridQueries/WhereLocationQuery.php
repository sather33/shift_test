<?php
namespace App\Queries\GridQueries;

use DB;
use Illuminate\Http\Request;
use App\Queries\GridQueries\Contracts\DataQuery;

class WhereLocationQuery implements DataQuery
{
	public function data($column, $direction)
	{
		$rows = DB::table('where_locations')
		          ->select('id as Id',
		          		   'category as Category',
		                   'name as Name',
		                   'country as Country',
		                   'taiwan_part as Part',
		                   'address as Address',
		                   'tel as Tel',
		                   'open_time as OpenTime',
		                   'remark as Remark')
		          ->orderBy($column, $direction)
		          ->get();

		return $rows;
	}

	public function filteredData($column, $direction, $keyword)
	{
		$rows = DB::table('where_locations')
				  ->select('id as Id',
				  		   'category as Category',
		                   'name as Name',
		                   'country as Country',
		                   'taiwan_part as Part',
		                   'address as Address',
		                   'tel as Tel',
		                   'open_time as OpenTime',
		                   'remark as Remark')
				  ->where('name', 'like binary', '%' . $keyword . '%')
				  ->orWhere('category', 'like binary', '%' . $keyword . '%')
				  ->orderBy($column, $direction)
				  ->get();
		
		return $rows;
	}
}