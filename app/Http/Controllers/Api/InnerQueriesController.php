<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;

use App\Queries\GridQueries\GridQuery;
// use App\Queries\GridQueries\BannersQuery;
// use App\Queries\GridQueries\DmsQuery;
// use App\Queries\GridQueries\ActivitiesQuery;
// use App\Queries\GridQueries\AppliesQuery;
// use App\Queries\GridQueries\CsrsQuery;
// use App\Queries\GridQueries\BrandCategoriesQuery;
// use App\Queries\GridQueries\NewsCategoriesQuery;
// use App\Queries\GridQueries\BrandsQuery;
// use App\Queries\GridQueries\StoresQuery;
// use App\Queries\GridQueries\InfosQuery;
// use App\Queries\GridQueries\ProductCategoriesQuery;
use App\Queries\GridQueries\ProductsQuery;
use App\Queries\GridQueries\AboutsQuery;
use App\Queries\GridQueries\LinksQuery;
use App\Queries\GridQueries\TagsQuery;
use App\Queries\GridQueries\NewsQuery;
use App\Queries\GridQueries\ProjectsQuery;
use App\Queries\GridQueries\FaqsQuery;
use App\Queries\GridQueries\VideosQuery;
use App\Queries\GridQueries\IndustriesQuery;

class InnerQueriesController extends Controller
{
    public function toggleOnShowing($table_name, $id)
    {
    	if($table_name == 'news-en')
    		$table_name = 'news';

        $model = DB::table($table_name)->where('id', $id)->first();
        DB::table($table_name)->where('id', $id)->update(['is_showing' => !$model->is_showing]);

        // $model->is_showing = !$model->is_showing;
        // return var_dump($model);
        // $model->update(['is_showing', !$model->is_showing]);

        return response()->json('toggle done.');
    }

    public function toggleIsRecommended($table_name, $id)
    {
        $model = DB::table($table_name)->where('id', $id)->first();

        $recommended_models = DB::table($table_name)->where('is_recommended', 1)->first();

        if(count($recommended_models) < 10)
        {
        	DB::table($table_name)->where('id', $id)->update(['is_recommended' => !$model->is_recommended]);
        	return response()->json('toggle done.');
        }
        else
        {
        	return response()->json('recommended item full');
        }
    }

    public function toggleIsDone($table_name, $id)
    {
        $model = DB::table($table_name)->where('id', $id)->first();
		DB::table($table_name)->where('id', $id)->update(['is_done' => !$model->is_done]);

		return response()->json('toggle done.');
    }

    // public function bannersData(Request $request)
    // {
    //     return GridQuery::sendData($request, new BannersQuery);
    // }

    // public function dmsData(Request $request)
    // {
    //     return GridQuery::sendData($request, new DmsQuery);
    // }

    // public function activitiesData(Request $request)
    // {
    //     return GridQuery::sendData($request, new ActivitiesQuery);
    // }

    // public function appliesData(Request $request)
    // {
    //     return GridQuery::sendSecondLayerData($request, new AppliesQuery);
    // }

    // public function csrsData(Request $request)
    // {
    //     return GridQuery::sendData($request, new CsrsQuery);
    // }

    // public function brandCategoriesData(Request $request)
    // {
    //     return GridQuery::sendData($request, new BrandCategoriesQuery);
    // }

    // public function newsCategoriesData(Request $request)
    // {
    //     return GridQuery::sendData($request, new NewsCategoriesQuery);
    // }

    // public function brandsData(Request $request)
    // {
    //     return GridQuery::sendData($request, new BrandsQuery);
    // }

    // public function storesData(Request $request)
    // {
    //     return GridQuery::sendData($request, new StoresQuery);
    // }

    // public function infosData(Request $request)
    // {
    //     return GridQuery::sendData($request, new InfosQuery);
    // }

    // public function productCategoriesData(Request $request)
    // {
    //     return GridQuery::sendData($request, new ProductCategoriesQuery);
    // }

    public function productsData(Request $request)
    {
        return GridQuery::sendData($request, new ProductsQuery);
    }

    public function aboutsData(Request $request)
    {
        return GridQuery::sendData($request, new AboutsQuery);
    }

    public function linksData(Request $request)
    {
        return GridQuery::sendData($request, new LinksQuery);
    }

    public function tagsData(Request $request)
    {
        return GridQuery::sendData($request, new TagsQuery);
    }

    public function newsData(Request $request)
    {
        return GridQuery::sendData($request, new NewsQuery);
    }

    public function projectsData(Request $request)
    {
        return GridQuery::sendData($request, new ProjectsQuery);
    }

    public function faqsData(Request $request)
    {
        return GridQuery::sendData($request, new FaqsQuery);
    }

    public function videosData(Request $request)
    {
        return GridQuery::sendData($request, new VideosQuery);
    }

    public function industriesData(Request $request)
    {
        return GridQuery::sendData($request, new IndustriesQuery);
    }
}
