<?php
namespace App\Queries\GridQueries;

use DB;
use Illuminate\Http\Request;
use App\Queries\GridQueries\Contracts\DataQuery;
use App\Banner;

class BannersQuery implements DataQuery
{
	public function data($column, $direction)
	{
		$rows = DB::table('banners')
		          ->select('id as Id',
		          		   'title as Title',
		                   'sub_title as SubTitle',
		                   'open_date as OpenDate',
		                   'close_date as CloseDate',
		                   'is_showing as Status',
		                   'order as Order',
		                   'last_updated_by_staff_name as 上次編輯者',
		               	   'last_updated_by_datetime as 上次編輯時間')
		          ->orderBy($column, $direction)
		          ->get();

		foreach ($rows as $key => $row) {
			$banner = Banner::findOrFail($row->Id);
			$row->ImgURL = $banner->imgs[0]->url;
		}

		return $rows;
	}

	public function filteredData($column, $direction, $keyword)
	{
		$rows = DB::table('banners')
				  ->select('id as Id',
		          		   'title as Title',
		                   'sub_title as SubTitle',
		                   'open_date as OpenDate',
		                   'close_date as CloseDate',
		                   'is_showing as Status',
		                   'order as Order',
		                   'last_updated_by_staff_name as 上次編輯者',
		               	   'last_updated_by_datetime as 上次編輯時間')
				  ->where('title', 'like binary', '%' . $keyword . '%')
				  ->orWhere('sub_title', 'like binary', '%' . $keyword . '%')
				  ->orWhere('open_date', 'like binary', '%' . $keyword . '%')
				  ->orWhere('close_date', 'like binary', '%' . $keyword . '%')
				  ->orderBy($column, $direction)
				  ->get();

		foreach ($rows as $key => $row) {
			$banner = Banner::findOrFail($row->Id);
			$row->ImgURL = $banner->imgs[0]->url;
		}

		return $rows;
	}
}