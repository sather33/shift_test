<?php
namespace App\Queries\GridQueries;

use DB;
use Illuminate\Http\Request;
use App\Queries\GridQueries\Contracts\DataQuery;
use App\Dm;

class DmsQuery implements DataQuery
{
	public function data($column, $direction)
	{
		$rows = DB::table('dms')
		          ->select('id as Id',
		          		   'file_url as FileURL',
		          		   'title as Title',
		                   'open_date as OpenDate',
		                   'close_date as CloseDate',
		                   'is_showing as Status',
		                   'order as Order',
		                   'last_updated_by_staff_name as 上次編輯者',
		               	   'last_updated_by_datetime as 上次編輯時間')
		          ->orderBy($column, $direction)
		          ->get();

		return $rows;
	}

	public function filteredData($column, $direction, $keyword)
	{
		$rows = DB::table('dms')
				  ->select('id as Id',
		          		   'file_url as FileURL',
		          		   'title as Title',
		                   'open_date as OpenDate',
		                   'close_date as CloseDate',
		                   'is_showing as Status',
		                   'order as Order',
		                   'last_updated_by_staff_name as 上次編輯者',
		               	   'last_updated_by_datetime as 上次編輯時間')
				  ->where('title', 'like binary', '%' . $keyword . '%')
				  ->orWhere('open_date', 'like binary', '%' . $keyword . '%')
				  ->orWhere('close_date', 'like binary', '%' . $keyword . '%')
				  ->orderBy($column, $direction)
				  ->get();

		
		
		return $rows;
	}
}