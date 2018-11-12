<?php
namespace App\Queries\GridQueries;


use Illuminate\Http\Request;
use App\Queries\GridQueries\Contracts\DataQuery;
use App\Queries\GridQueries\Contracts\SecondLayerDataQuery;
use DB;

class GridQuery
{
    public static function sendData(Request $request, DataQuery $query)
    {
        // set sort by column and direction
        list($column, $direction) = static::setSort($request, $query);

        // search by keyword with column sort
        if ($request->has('keyword') && !empty($request->keyword)) 
        {
            return static::keywordFilter($request, $query, $column, $direction);
        }
        
        // return data
        return static::getData($query, $column, $direction);
    }

    public static function sendSecondLayerData(Request $request, SecondLayerDataQuery $query)
    {
        // set sort by column and direction
        list($column, $direction) = static::setSort($request, $query);

        // second layer model       
        $belongs_to_id = $request->belongs_to_id;
        
        // search by keyword with column sort
        if ($request->has('keyword')) 
        {
            return static::keywordFilter($request, $query, $column, $direction, $belongs_to_id);
        }
        
        // return data
        return static::getData($query, $column, $direction, $belongs_to_id);
    }

    public static function setSort(Request $request, $query)
    {
        // set sort by column with default
        list($column, $direction) = static::setDefaults($query);

        if ($request->has('column') && !empty($request->column)) 
        {
            $column = $request->get('column');
        
            if ($column == 'Id') {
                $direction = $request->get('direction') == 1 ? 'asc' : 'desc';
                return [$column, $direction];
            } else {
                $direction = $request->get('direction') == 1 ? 'desc' : 'asc';
                return [$column, $direction];
            }
        }

        return [$column, $direction];
    }

    public static function setDefaults($query)
    {
        switch ($query)
        {
            case $query instanceof BannersQuery :
                $column = 'order';
                $direction = 'asc';
                break;

            case $query instanceof DmsQuery :
                $column = 'order';
                $direction = 'asc';
                break;

            case $query instanceof ActivitiesQuery :
                $column = 'order';
                $direction = 'asc';
                break;

            case $query instanceof BrandCategoriesQuery :
                $column = 'order';
                $direction = 'asc';
                break;

            case $query instanceof NewsCategoriesQuery :
                $column = 'order';
                $direction = 'asc';
                break;

            default:
                $column = 'id';
                $direction = 'asc';
                break;
        }

        return list($column, $direction) = [$column, $direction];
    }
    
    public static function keywordFilter(Request $request, $query, $column, $direction, $belongs_to_id = 0)
    {
        $keyword = $request->get('keyword');
        
        if($belongs_to_id != 0)
        {
            return response()->json($query->filteredData($column,
                                                         $direction,
                                                         $keyword,
                                                         $belongs_to_id));
        }

        return response()->json($query->filteredData($column,
                                                     $direction,
                                                     $keyword));
    }
    
    public static function getData($query, $column, $direction, $belongs_to_id = 0)
    {
        if($belongs_to_id != 0)
        {
            return response()->json($query->data($column, $direction, $belongs_to_id));
        }

        return response()->json($query->data($column, $direction));
    }
}