<?php
namespace App\Queries\GridQueries;

use DB;
use Illuminate\Http\Request;
use App\Queries\GridQueries\Contracts\DataQuery;

class VideosQuery implements DataQuery
{
	public function data($column, $direction)
	{
		$rows = DB::table('videos')
		          ->select('id as Id',
		          		   'url as VideoURL',
		          		   'title as 標題',
		          		   'content as 介紹內容',
		               	   'is_showing as 顯示於前台')
		          ->orderBy($column, $direction)
		          ->get();

		$headers = ['影片', '標題', '介紹內容', '顯示於前台'];

		$data['headers'] = $headers;
		$data['data'] = $rows;

		return $data;

		// return $rows;
	}

	public function filteredData($column, $direction, $keyword)
	{
		$rows = DB::table('videos')
				  ->select('id as Id',
		          		   'url as VideoURL',
		          		   'title as 標題',
		          		   'content as 介紹內容',
		               	   'is_showing as 顯示於前台')
				  ->where('title', 'like binary', '%' . $keyword . '%')
				  ->orWhere('content', 'like binary', '%' . $keyword . '%')
				  ->orderBy($column, $direction)
				  ->get();

		$headers = ['影片', '標題', '介紹內容', '顯示於前台'];

		$data['headers'] = $headers;
		$data['data'] = $rows;

		return $data;

		// return $rows;
	}
}