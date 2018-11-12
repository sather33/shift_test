<?php
namespace App\Queries\GridQueries;

use DB;
use Illuminate\Http\Request;
use App\Queries\GridQueries\Contracts\DataQuery;

class IndustriesQuery implements DataQuery
{
	public function data($column, $direction)
	{
		$rows = DB::table('industries')
		          ->select('id as Id',
		          		   'name as 產業名稱',
		          		   'name_en as 英文名稱',
		          		   'slug as 代號',
		               	   'is_showing as 顯示於前台')
		          ->orderBy($column, $direction)
		          ->get();

		$headers = ['產業名稱', '英文名稱', '代號', '顯示於前台'];

		$data['headers'] = $headers;
		$data['data'] = $rows;

		return $data;

		// return $rows;
	}

	public function filteredData($column, $direction, $keyword)
	{
		$rows = DB::table('industries')
				  ->select('id as Id',
		          		   'name as 產業名稱',
		          		   'name_en as 英文名稱',
		          		   'slug as 代號',
		               	   'is_showing as 顯示於前台')
				  ->where('name', 'like binary', '%' . $keyword . '%')
				  ->orWhere('name_en', 'like binary', '%' . $keyword . '%')
				  ->orWhere('intro', 'like binary', '%' . $keyword . '%')
				  // ->orWhere('county', 'like binary', '%' . $keyword . '%')
				  // ->orWhere('district', 'like binary', '%' . $keyword . '%')
				  // ->orWhere('address', 'like binary', '%' . $keyword . '%')
				  // ->orWhere('created_at', 'like binary', '%' . $keyword . '%')
				  ->orderBy($column, $direction)
				  ->get();

		$headers = ['產業名稱', '英文名稱', '代號', '顯示於前台'];

		$data['headers'] = $headers;
		$data['data'] = $rows;

		return $data;

		// return $rows;
	}
}