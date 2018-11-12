<?php
namespace App\Queries\GridQueries;

use DB;
use Illuminate\Http\Request;
use App\Queries\GridQueries\Contracts\DataQuery;
use App\Brand;

class BrandsQuery implements DataQuery
{
	public function data($column, $direction)
	{
		$rows = DB::table('brands')
		          ->select('id as Id',
		          		   'name as 品牌名稱',
		                   'order as 排序',
		                   'is_showing as 狀態',
		                   'last_updated_by_staff_name as 上次編輯者',
		               	   'last_updated_by_datetime as 上次編輯時間')
		          ->orderBy($column, $direction)
		          ->get();

		foreach ($rows as $key => $row) {
			$brand = Brand::findOrFail($row->Id);
			
			if(count($brand->imgs) > 0)
				$url = $brand->imgs()->whereTag('cover_img')->first()->url;
			else
				$url = 'assets/img/back/img-default.gif';

			$row->ImgURL = $url;
		}

		// $header = collect(['header' => ['a', 'b', 'c']]);
		// $data = $header->merge($rows);
		// $rows->header = $header;

		// $data['header'] = $header;
		// $data['data'] = $rows;

		// return $data;
		return $rows;
	}

	public function filteredData($column, $direction, $keyword)
	{
		$rows = DB::table('brands')
				  ->select('id as Id',
		          		   'name as 品牌名稱',
		                   'order as 排序',
		                   'is_showing as 狀態',
		                   'last_updated_by_staff_name as 上次編輯者',
		               	   'last_updated_by_datetime as 上次編輯時間')
				  ->where('name', 'like binary', '%' . $keyword . '%')
				  ->orderBy($column, $direction)
				  ->get();

		foreach ($rows as $key => $row) {
			$brand = Brand::findOrFail($row->Id);

			if(count($brand->imgs) > 0)
				$url = $brand->imgs()->whereTag('cover_img')->first()->url;
			else
				$url = 'assets/img/back/img-default.gif';

			$row->ImgURL = $url;
		}

		return $rows;
	}
}