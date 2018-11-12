<?php
namespace App\Queries\GridQueries;

use DB;
use Illuminate\Http\Request;
use App\Queries\GridQueries\Contracts\DataQuery;

class BackendProductsQuery implements DataQuery
{
	public function data($column, $direction)
	{
		$rows = DB::table('product_packs')
		          ->select('id as Id',
		          		   'code as Code',
		                   'name as Name')
		          ->orderBy($column, $direction)
		          ->get();

		return $rows;
	}

	public function filteredData($column, $direction, $keyword)
	{
		$rows = DB::table('product_packs')
				  ->select('id as Id',
				  		   'code as Code',
		                   'name as Name')
				  ->where('code', 'like binary', '%' . $keyword . '%')
				  ->orWhere('name', 'like binary', '%' . $keyword . '%')
				  ->orderBy($column, $direction)
				  ->get();
		
		return $rows;
	}
}