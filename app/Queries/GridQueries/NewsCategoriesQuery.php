<?php
namespace App\Queries\GridQueries;

use DB;
use Illuminate\Http\Request;
use App\Queries\GridQueries\Contracts\DataQuery;
use App\Category;

class NewsCategoriesQuery implements DataQuery
{
	public function data($column, $direction)
	{
		$rows = DB::table('categories')
		          ->select('id as Id',
		          		   'name as Name',
		                   'is_showing as Status',
		                   'order as Order',
		                   'is_deleteable as Deleteable',
		                   'last_updated_by_staff_name as 上次編輯者',
		               	   'last_updated_by_datetime as 上次編輯時間')
		          ->where('type', 'news')
		          ->orderBy($column, $direction)
		          ->get();

		return $rows;
	}

	public function filteredData($column, $direction, $keyword)
	{
		$rows = DB::table('banners')
				  ->select('id as Id',
		          		   'name as Name',
		                   'is_showing as Status',
		                   'order as Order',
		                   'is_deleteable as Deleteable',
		                   'last_updated_by_staff_name as 上次編輯者',
		               	   'last_updated_by_datetime as 上次編輯時間')
		          ->where('type', 'news')
		          ->where(function($query) use($keyword)
			      {
			          $query
			          ->where('name', 'like binary', '%' . $keyword . '%');
			      })
				  ->orderBy($column, $direction)
				  ->get();

		return $rows;
	}
}