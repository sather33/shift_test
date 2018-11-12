<?php
namespace App\Queries\GridQueries;

use DB;
use Illuminate\Http\Request;
use App\Queries\GridQueries\Contracts\SecondLayerDataQuery;

class AppliesQuery implements SecondLayerDataQuery
{
	public function data($column, $direction, $belongs_to_id)
	{
		$rows = DB::table('applies')
		          ->select('id as Id',
		          		   'name as Name',
		          		   'email as Email',
		          		   'gender as Gender',
		                   'mobile as Mobile',
		                   'birthdate as BirthDate',
		                   'citizen_id as CitizenId',
		                   'created_at as AppliedTime',
		                   'cloth_size as ClothSize',
		                   'shoe_size as ShoeSize',
		                   'ice_name as ICEName',
		                   'ice_phone as ICEPhone',
		                   'last_updated_by_staff_name as 上次編輯者',
		               	   'last_updated_by_datetime as 上次編輯時間')
		          ->where('activity_id', $belongs_to_id)
		          ->orderBy($column, $direction)
		          ->get();

		return $rows;
	}

	public function filteredData($column, $direction, $keyword, $belongs_to_id)
	{
		$rows = DB::table('applies')
				  ->select('id as Id',
		          		   'name as Name',
		          		   'email as Email',
		          		   'gender as Gender',
		                   'mobile as Mobile',
		                   'birthdate as BirthDate',
		                   'citizen_id as CitizenId',
		                   'created_at as AppliedTime',
		                   'cloth_size as ClothSize',
		                   'shoe_size as ShoeSize',
		                   'ice_name as ICEName',
		                   'ice_phone as ICEPhone',
		                   'last_updated_by_staff_name as 上次編輯者',
		               	   'last_updated_by_datetime as 上次編輯時間')
				  ->where('activity_id', $belongs_to_id)
				  ->where(function($query) use($keyword)
			      {
			          $query
			          ->where('name', 'like binary', '%' . $keyword . '%')
					  ->orWhere('email', 'like binary', '%' . $keyword . '%')
					  ->orWhere('mobile', 'like binary', '%' . $keyword . '%')
					  ->orWhere('birthdate', 'like binary', '%' . $keyword . '%')
					  ->orWhere('citizen_id', 'like binary', '%' . $keyword . '%');
			      })
				  ->orderBy($column, $direction)
				  ->get();

		return $rows;
	}
}