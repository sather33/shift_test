<?php
namespace App\Queries\GridQueries;

use DB;
use Illuminate\Http\Request;
use App\Queries\GridQueries\Contracts\DataQuery;
use App\Info;

class InfosQuery implements DataQuery
{
	public function data($column, $direction)
	{
		$rows = DB::table('infos')
		          ->select('id as Id',
		          		   'title as 標題',
		                   'sub_title as 副標題',
		                   'open_date as 發佈日期',
		                   'close_date as 有效日期',
		                   'order as 排序',
		                   'is_showing as 狀態',
		                   'last_updated_by_staff_name as 上次編輯者',
		               	   'last_updated_by_datetime as 上次編輯時間')
		          ->orderBy($column, $direction)
		          ->get();

		foreach ($rows as $key => $row) {
			$info = Info::findOrFail($row->Id);
			$row->ImgURL = $info->imgs()->whereTag('thumbnail_img')->first()->url;
		}

		return $rows;
	}

	public function filteredData($column, $direction, $keyword)
	{
		$rows = DB::table('infos')
				  ->select('id as Id',
		          		   'title as 標題',
		                   'sub_title as 副標題',
		                   'open_date as 發佈日期',
		                   'close_date as 有效日期',
		                   'order as 排序',
		                   'is_showing as 狀態',
		                   'last_updated_by_staff_name as 上次編輯者',
		               	   'last_updated_by_datetime as 上次編輯時間')
				  ->where('title', 'like binary', '%' . $keyword . '%')
				  ->orWhere('sub_title', 'like binary', '%' . $keyword . '%')
				  ->orWhere('open_date', 'like binary', '%' . $keyword . '%')
				  ->orWhere('close_date', 'like binary', '%' . $keyword . '%')
				  ->orderBy($column, $direction)
				  ->get();

		foreach ($rows as $key => $row) {
			$info = Info::findOrFail($row->Id);
			$row->ImgURL = $info->imgs()->whereTag('thumbnail_img')->first()->url;
		}

		return $rows;
	}
}