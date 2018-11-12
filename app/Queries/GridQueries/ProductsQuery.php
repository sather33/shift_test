<?php
namespace App\Queries\GridQueries;

use DB;
use Illuminate\Http\Request;
use App\Queries\GridQueries\Contracts\DataQuery;
use App\Product;
use App\Category;

class ProductsQuery implements DataQuery
{
	public function data($column, $direction)
	{
		$rows = DB::table('products')
		          ->select('id as Id',
		          		   'name as 商品名稱',
		                   'is_recommended as 設為推薦',
		               	   'is_showing as 顯示於前台',
		               	   'updated_at as 上次編輯')
		          ->orderBy($column, $direction)
		          ->get();

		// foreach ($rows as $key => $row) {
		// 	$link = Link::findOrFail($row->Id);
			
		// 	if($link->imgs()->whereTag('img')->first())
		// 		$url = asset($link->imgs()->whereTag('img')->first()->url);
		// 	else
		// 		$url = 'http://fakeimg.pl/200x67/';

		// 	$row->ImgURL = $url;

		// 	if($row->連結類型 == 0)
		// 	{
		// 		$row->連結類型 = '常用資料庫';
		// 	}
		// 	else
		// 	{
		// 		$row->連結類型 = '友站連結';
		// 	}
		// }

		$categories = Category::productCategories()->where('is_showing', 1)->orderBy('order', 'asc')->get()->pluck('id', 'name')->toArray();
        $series = Category::productSeries()->where('is_showing', 1)->orderBy('order', 'asc')->get()->pluck('id', 'name')->toArray();
        $styles = Category::productStyles()->where('is_showing', 1)->orderBy('order', 'asc')->get()->pluck('id', 'name')->toArray();

		$headers = ['商品名稱', '設為推薦', '顯示於前台', '上次編輯'];

		$data['headers'] = $headers;
		$data['data'] = $rows;
		$data['selects']['categories'] = $categories;
		$data['selects']['series'] = $series;
		$data['selects']['styles'] = $styles;

		return $data;
	}

	public function filteredData($column, $direction, $keyword)
	{
		$category = Category::whereName($keyword)->first() ?? null;
		if($category)
		{
			$rows = $category
				  ->products()
				  ->select('id as Id',
		          		   'name as 商品名稱',
		                   'is_recommended as 設為推薦',
		               	   'is_showing as 顯示於前台',
		               	   'updated_at as 上次編輯')
				  ->orderBy($column, $direction)
				  ->get();
		}
		else
		{
			$rows = DB::table('products')
					  ->select('id as Id',
			          		   'name as 商品名稱',
			                   'is_recommended as 設為推薦',
			               	   'is_showing as 顯示於前台',
			               	   'updated_at as 上次編輯')
					  ->where('name', 'like binary', '%' . $keyword . '%')
					  ->orWhere('name_en', 'like binary', '%' . $keyword . '%')
					  ->orderBy($column, $direction)
				  	  ->get();
		}
		// $rows = DB::table('products')
		// 		  ->select('id as Id',
		//           		   'name as 商品名稱',
		//                    'is_recommended as 設為推薦',
		//                	   'is_showing as 顯示於前台',
		//                	   'updated_at as 上次編輯')
		// 		  ->where('name', 'like binary', '%' . $keyword . '%')
		// 		  ->orWhere('name_en', 'like binary', '%' . $keyword . '%')
		// 		  ->orWhere(function($query) use($keyword)
		// 	      {
		// 	          $query
		// 	          ->join('categorables', 'categorables.categorable_id', '=', 'products.id')
		// 	          ->join('categorables', function ($join) {
		// 		          $join->on('categorables.categorable_id', '=', 'products.id')
		// 		               ->where('categorables.categorable_type', '=', 'App\Product');
		// 		      })
		// 	          ->join('categories', function ($join) use ($keyword){
		// 		          $join->on('categorables.categorables.category_id', '=', 'categories.id')
		// 		               ->where('categories.name', 'like binary', '%' . $keyword . '%');
		// 		      })
		// 	          ;
		// 	    //       ->where('name', 'like binary', '%' . $keyword . '%')
		// 			  // ->orWhere('mobile', 'like binary', '%' . $keyword . '%')
		// 			  // ->orWhere('email', 'like binary', '%' . $keyword . '%');
		// 	      })
		// 		  ->orderBy($column, $direction)
		// 		  ->get();

		// foreach ($rows as $key => $row) {
		// 	$link = Link::findOrFail($row->Id);
			
		// 	if($link->imgs()->whereTag('img')->first())
		// 		$url = asset($link->imgs()->whereTag('img')->first()->url);
		// 	else
		// 		$url = 'http://fakeimg.pl/200x67/';

		// 	$row->ImgURL = $url;

		// 	if($row->連結類型 == 0)
		// 	{
		// 		$row->連結類型 = '常用資料庫';
		// 	}
		// 	else
		// 	{
		// 		$row->連結類型 = '友站連結';
		// 	}
		// }

		$categories = Category::productCategories()->where('is_showing', 1)->orderBy('order', 'asc')->get()->pluck('id', 'name')->toArray();
        $series = Category::productSeries()->where('is_showing', 1)->orderBy('order', 'asc')->get()->pluck('id', 'name')->toArray();
        $styles = Category::productStyles()->where('is_showing', 1)->orderBy('order', 'asc')->get()->pluck('id', 'name')->toArray();

		$headers = ['商品名稱', '設為推薦', '顯示於前台', '上次編輯'];

		$data['headers'] = $headers;
		$data['data'] = $rows;
		$data['selects']['categories'] = $categories;
		$data['selects']['series'] = $series;
		$data['selects']['styles'] = $styles;

		return $data;
	}
}