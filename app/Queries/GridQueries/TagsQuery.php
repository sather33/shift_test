<?php
namespace App\Queries\GridQueries;

use DB;
use Illuminate\Http\Request;
use App\Queries\GridQueries\Contracts\DataQuery;

class TagsQuery implements DataQuery
{
	public function data($column, $direction)
	{
		$rows = DB::table('tags')
		          ->select('id as Id',
		          		   'name as 標籤名稱')
		          ->orderBy($column, $direction)
		          ->get();

		$headers = ['標籤名稱'];

		$data['headers'] = $headers;
		$data['data'] = $rows;

		return $data;

		// return $rows;
	}

	public function filteredData($column, $direction, $keyword)
	{
		$rows = DB::table('tags')
				  ->select('id as Id',
		          		   'name as 標籤名稱')
				  ->where('name', 'like binary', '%' . $keyword . '%')
				  // ->orWhere('content', 'like binary', '%' . $keyword . '%')
				  // ->orWhere('zipcode', 'like binary', '%' . $keyword . '%')
				  // ->orWhere('county', 'like binary', '%' . $keyword . '%')
				  // ->orWhere('district', 'like binary', '%' . $keyword . '%')
				  // ->orWhere('address', 'like binary', '%' . $keyword . '%')
				  // ->orWhere('created_at', 'like binary', '%' . $keyword . '%')
				  ->orderBy($column, $direction)
				  ->get();

		$headers = ['標籤名稱'];

		$data['headers'] = $headers;
		$data['data'] = $rows;

		return $data;

		// return $rows;
	}
}