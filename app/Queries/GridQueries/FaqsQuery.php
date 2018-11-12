<?php
namespace App\Queries\GridQueries;

use DB;
use Illuminate\Http\Request;
use App\Queries\GridQueries\Contracts\DataQuery;

class FaqsQuery implements DataQuery
{
	public function data($column, $direction)
	{
		$rows = DB::table('faqs')
		          ->select('id as Id',
		          		   'q as 問題',
		          		   'a as 答案',
		               	   'is_showing as 顯示於前台')
		          ->orderBy($column, $direction)
		          ->get();

		$headers = ['問題', '答案', '顯示於前台'];

		$data['headers'] = $headers;
		$data['data'] = $rows;

		return $data;

		// return $rows;
	}

	public function filteredData($column, $direction, $keyword)
	{
		$rows = DB::table('faqs')
				  ->select('id as Id',
		          		   'q as 問題',
		          		   'a as 答案',
		               	   'is_showing as 顯示於前台')
				  ->where('q', 'like binary', '%' . $keyword . '%')
				  ->orWhere('a', 'like binary', '%' . $keyword . '%')
				  ->orderBy($column, $direction)
				  ->get();

		$headers = ['問題', '答案', '顯示於前台'];

		$data['headers'] = $headers;
		$data['data'] = $rows;

		return $data;

		// return $rows;
	}
}