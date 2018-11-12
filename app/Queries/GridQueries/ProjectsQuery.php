<?php
namespace App\Queries\GridQueries;

use DB;
use Illuminate\Http\Request;
use App\Queries\GridQueries\Contracts\DataQuery;

class ProjectsQuery implements DataQuery
{
	public function data($column, $direction)
	{
		$rows = DB::table('projects')
		          ->select('id as Id',
		          		   'name as 專案名稱',
		          		   'link_url as 專案網址',
		               	   'is_showing as 顯示於前台')
		          ->orderBy($column, $direction)
		          ->get();

		$headers = ['專案名稱', '專案網址', '顯示於前台'];

		$data['headers'] = $headers;
		$data['data'] = $rows;

		return $data;

		// return $rows;
	}

	public function filteredData($column, $direction, $keyword)
	{
		$rows = DB::table('projects')
				  ->select('id as Id',
		          		   'name as 專案名稱',
		          		   'link_url as 專案網址',
		               	   'is_showing as 顯示於前台')
				  ->where('name', 'like binary', '%' . $keyword . '%')
				  ->orWhere('link_url', 'like binary', '%' . $keyword . '%')
				  ->orWhere('remarks', 'like binary', '%' . $keyword . '%')
				  // ->orWhere('county', 'like binary', '%' . $keyword . '%')
				  // ->orWhere('district', 'like binary', '%' . $keyword . '%')
				  // ->orWhere('address', 'like binary', '%' . $keyword . '%')
				  // ->orWhere('created_at', 'like binary', '%' . $keyword . '%')
				  ->orderBy($column, $direction)
				  ->get();

		$headers = ['專案名稱', '專案網址', '顯示於前台'];

		$data['headers'] = $headers;
		$data['data'] = $rows;

		return $data;

		// return $rows;
	}
}