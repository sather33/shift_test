<?php
namespace App\Queries\GridQueries;

use DB;
use Illuminate\Http\Request;
use App\Queries\GridQueries\Contracts\DataQuery;

class NewsQuery implements DataQuery
{
	public function data($column, $direction)
	{
		if(strpos(request()->path(), 'en') === false)
		{
			$headers = ['標題', '發布日期', '顯示於前台', '編輯紀錄'];
			$query = DB::table('news')
			          ->select('id as Id',
			          		   'title as 標題',
			          		   'release_date as 發布日期',
			               	   'is_showing as 顯示於前台',
			               	   'updated_at as 編輯紀錄')
			          ->whereIsLangEn(0);
		}
		else
		{
			$headers = ['Title', 'ReleaseDate', 'Showing', 'LastEditedAt'];
			$query = DB::table('news')
			          ->select('id as Id',
			          		   'title as Title',
			          		   'release_date as ReleaseDate',
			               	   'is_showing as Showing',
			               	   'updated_at as LastEditedAt')
			          ->whereIsLangEn(1);
		}

		$rows = $query->orderBy($column, $direction)
			          ->get();

		$data['headers'] = $headers;
		$data['data'] = $rows;
		// $data['request'] = request()->path();

		return $data;

		// return $rows;
		
	}

	public function filteredData($column, $direction, $keyword)
	{
		if(strpos(request()->path(), 'en') === false)
		{
			$headers = ['標題', '發布日期', '顯示於前台', '編輯紀錄'];
			$query = DB::table('news')
			          ->select('id as Id',
			          		   'title as 標題',
			          		   'release_date as 發布日期',
			               	   'is_showing as 顯示於前台',
			               	   'updated_at as 編輯紀錄')
			          ->whereIsLangEn(0);
		}
		else
		{
			$headers = ['Title', 'ReleaseDate', 'Showing', 'LastEditedAt'];
			$query = DB::table('news')
			          ->select('id as Id',
			          		   'title as Title',
			          		   'release_date as ReleaseDate',
			               	   'is_showing as Showing',
			               	   'updated_at as LastEditedAt')
			          ->whereIsLangEn(1);
		}

		$rows = $query->where(function($query) use($keyword)
				      {
				          $query
				          ->where('title', 'like binary', '%' . $keyword . '%')
						  ->orWhere('content', 'like binary', '%' . $keyword . '%')
						  ->orWhere('release_date', 'like binary', '%' . $keyword . '%');
				      })
					  ->orderBy($column, $direction)
					  ->get();

		$data['headers'] = $headers;
		$data['data'] = $rows;

		return $data;

		// return $rows;
	}
}