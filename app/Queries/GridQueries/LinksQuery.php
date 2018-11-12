<?php
namespace App\Queries\GridQueries;

use DB;
use Illuminate\Http\Request;
use App\Queries\GridQueries\Contracts\DataQuery;
use App\Link;

class LinksQuery implements DataQuery
{
	public function data($column, $direction)
	{
		$rows = DB::table('links')
		          ->select('id as Id',
		          		   'type as 連結類型',
		          		   'name as 連結名稱',
		                   'url as 連結網址',
		               	   'is_showing as 顯示於前台')
		          ->orderBy($column, $direction)
		          ->get();

		foreach ($rows as $key => $row) {
			$link = Link::findOrFail($row->Id);
			
			if($link->imgs()->whereTag('img')->first())
				$url = asset($link->imgs()->whereTag('img')->first()->url);
			else
				$url = 'http://fakeimg.pl/200x67/';

			$row->ImgURL = $url;

			if($row->連結類型 == 0)
			{
				$row->連結類型 = '常用資料庫';
			}
			else
			{
				$row->連結類型 = '友站連結';
			}
		}

		$headers = ['圖檔', '連結類型', '連結名稱', '連結網址', '顯示於前台'];

		$data['headers'] = $headers;
		$data['data'] = $rows;

		return $data;

		// return $rows;
	}

	public function filteredData($column, $direction, $keyword)
	{
		$rows = DB::table('links')
				  ->select('id as Id',
		          		   'type as 連結類型',
		          		   'name as 連結名稱',
		                   'url as 連結網址',
		               	   'is_showing as 顯示於前台')
				  ->where('type', 'like binary', '%' . $keyword . '%')
				  ->orWhere('name', 'like binary', '%' . $keyword . '%')
				  ->orWhere('url', 'like binary', '%' . $keyword . '%')	
				  ->orderBy($column, $direction)
				  ->get();

		foreach ($rows as $key => $row) {
			$link = Link::findOrFail($row->Id);
			
			if($link->imgs()->whereTag('img')->first())
				$url = asset($link->imgs()->whereTag('img')->first()->url);
			else
				$url = 'http://fakeimg.pl/200x67/';

			$row->ImgURL = $url;

			if($row->連結類型 == 0)
			{
				$row->連結類型 = '常用資料庫';
			}
			else
			{
				$row->連結類型 = '友站連結';
			}
		}

		$headers = ['圖檔', '連結類型', '連結名稱', '連結網址', '顯示於前台'];

		$data['headers'] = $headers;
		$data['data'] = $rows;

		return $data;

		// return $rows;
	}
}