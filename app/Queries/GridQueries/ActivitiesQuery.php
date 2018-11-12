<?php
namespace App\Queries\GridQueries;

use DB;
use Illuminate\Http\Request;
use App\Queries\GridQueries\Contracts\DataQuery;
use App\Activity;

class ActivitiesQuery implements DataQuery
{
	public function data($column, $direction)
	{
		$rows = DB::table('activities')
		          ->select('id as Id',
		          		   'applied_people as Applied',
		          		   'quota_of_people as Quota',
		          		   'title as 標題',
		                   'sub_title as 副標題',
		                   'apply_open_date as 報名開始',
		                   'apply_close_date as 報名截止',
		                   'order as 排序',
		                   'is_showing as 狀態',
		               	   'last_updated_by_staff_name as 上次編輯者',
		               	   'last_updated_by_datetime as 上次編輯時間')
		          ->orderBy($column, $direction)
		          ->get();

		foreach ($rows as $key => $row) {
			$activity = Activity::findOrFail($row->Id);
			$row->ImgURL = $activity->imgs()->whereTag('thumbnail_img')->first()->url;
		}

		return $rows;
	}

	public function filteredData($column, $direction, $keyword)
	{
		$rows = DB::table('activities')
				  ->select('id as Id',
		          		   'applied_people as Applied',
		          		   'quota_of_people as Quota',
		          		   'title as 標題',
		                   'sub_title as 副標題',
		                   'apply_open_date as 報名開始',
		                   'apply_close_date as 報名截止',
		                   'order as 排序',
		                   'is_showing as 狀態',
		                   'last_updated_by_staff_name as 上次編輯者',
		               	   'last_updated_by_datetime as 上次編輯時間')
				  ->where('title', 'like binary', '%' . $keyword . '%')
				  ->orWhere('sub_title', 'like binary', '%' . $keyword . '%')
				  ->orWhere('apply_open_date', 'like binary', '%' . $keyword . '%')
				  ->orWhere('apply_close_date', 'like binary', '%' . $keyword . '%')
				  ->orderBy($column, $direction)
				  ->get();

		foreach ($rows as $key => $row) {
			$activity = Activity::findOrFail($row->Id);
			$row->ImgURL = $activity->imgs()->whereTag('thumbnail_img')->first()->url;
		}

		return $rows;
	}
}