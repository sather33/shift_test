<?php
namespace App\Queries\GridQueries;

use DB;
use Illuminate\Http\Request;
use App\Queries\GridQueries\Contracts\DataQuery;

class AboutsQuery implements DataQuery
{
	public function data($column, $direction)
	{
		$rows = DB::table('abouts')
		          ->select('id as Id',
		          		   'title as 區塊標題',
		          		   'brief_title as 短板標題',
		                   'content as 區塊內容',
		               	   'is_showing as 顯示於前台')
		          ->orderBy($column, $direction)
		          ->get();

		$headers = ['區塊標題', '短板標題', '區塊內容', '顯示於前台'];

		$data['headers'] = $headers;
		$data['data'] = $rows;

		return $data;

		// return $rows;
	}

	public function filteredData($column, $direction, $keyword)
	{
		$rows = DB::table('abouts')
				  ->select('id as Id',
		          		   'title as 區塊標題',
		          		   'brief_title as 短板標題',
		                   'content as 區塊內容',
		               	   'is_showing as 顯示於前台')
				  ->where('title', 'like binary', '%' . $keyword . '%')
				  ->orWhere('content', 'like binary', '%' . $keyword . '%')
				  // ->orWhere('zipcode', 'like binary', '%' . $keyword . '%')
				  // ->orWhere('county', 'like binary', '%' . $keyword . '%')
				  // ->orWhere('district', 'like binary', '%' . $keyword . '%')
				  // ->orWhere('address', 'like binary', '%' . $keyword . '%')
				  // ->orWhere('created_at', 'like binary', '%' . $keyword . '%')
				  ->orderBy($column, $direction)
				  ->get();

		$headers = ['區塊標題', '短板標題', '區塊內容', '顯示於前台'];

		$data['headers'] = $headers;
		$data['data'] = $rows;

		return $data;

		// return $rows;
	}
}