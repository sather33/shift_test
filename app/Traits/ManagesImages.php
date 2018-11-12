<?php
namespace App\Traits;

use Illuminate\Http\Request;
use App\Http\Requests;

use Image;
use File;
use App\Img;


trait ManagesImages
{
    protected $folderName = 'image';
    protected $file = null;
    protected $imageFullPathName;
    protected $imageProperties = [];
    protected $imageWidth = null;
    protected $imageHeight = null;



    protected function storeOrUpdateOneImage(Request $request, $model, $column_name = 'img', $tag = 'img', $width = null, $height = null)
    {
        if($this->NewFileIsUploaded($request, $column_name))
        {
            $this->getUploadedFile($request, $column_name);

            $this->saveImageFile($width, $height);
            

            $this->setImageProperties($request, $tag);

            $img = $this->getOriginalImgModel($model, $tag);
            if($img)
            {
                \File::Delete(public_path().$img->url);
                $img->update($this->imageProperties);
            }
            else
            {
                $model->imgs()->create($this->imageProperties);
            }

            return true;
        }

        return false;
    }

    private function NewFileIsUploaded(Request $request, $column_name)
    {
        return $request->hasFile($column_name);
    }

    private function getUploadedFile(Request $request, $column_name)
    {
        $this->file = $request->file($column_name);
    }


    private function getOriginalImgModel($model, $tag)
    {
        return $model->imgs()->whereTag($tag)->first();
    }

    private function setImageFilePath()
    {
        $imageName = uniqid() . '.' .$this->file->getClientOriginalExtension();
        
        $directory = substr(md5(mt_rand()), 0, 4);
        $directory_full_path = 'uploads/img/' . $this->folderName . '/' . $directory;

        File::exists($directory_full_path) or File::makeDirectory($directory_full_path, 0777, true, true);

        $this->imageFullPathName = $directory_full_path . '/' . $imageName;
    }

    private function saveImageFile($width, $height)
    {
        $this->setImageFilePath();
            
        if($width == null && $height == null)
        {
            $imagedetails = getimagesize($this->file);
            $this->imageWidth = $imagedetails[0];
            $this->imageHeight = $imagedetails[1];
            $width = $this->imageWidth;
        }

        $image = Image::make($this->file->getRealPath())->resize($width, $height, function ($constraint) { /* 250 * 180 */
            $constraint->aspectRatio();
        })->save(public_path($this->imageFullPathName));
    }

    private function setImageProperties(Request $request, $tag)
    {
        // for img property depends on project

        $this->imageProperties = [
            'url' => $this->imageFullPathName,
            'order' => $request->has('order') ? $request->order : 10,
            'title' => $request->has('title') ? $request->title : '',
            'description' => $request->has('description') ? $request->description : '',
            'tag' => $tag,
        ];
    }

    protected function sotreOrUpdateRedactorImage(Request $request, $model, $column = 'content')
    {
        $new_content_imgs = [];
        if(!empty($request->input($column)))
        {
            $content = $request->input($column);

            $doc = new \DOMDocument();
            libxml_use_internal_errors(true);
            $doc->loadHTML($content);
            libxml_clear_errors();
            
            $xpath = new \DOMXPath($doc);
            $nodelist = $xpath->query("//img"); // find image in redactor

            for ($i = 0; $i < $nodelist->length; $i ++) {
                $src = $nodelist->item($i)->attributes->getNamedItem('src')->nodeValue;
                $img = Img::where('url', $src)->first();  //find image in database
                
                if (isset($img)) {
                    $img->imgable()->associate($model);   //associate image to the model
                    $img->tag = 'redactor';
                    $img->save();

                    $new_content_imgs[] = $img;   //save redactor image
                }
            }
        }

        // $old_imgs = $model->imgs()->whereTag('redactor')->get();
        

        // if(!$old_imgs)
        // {
        //     $old_content_imgs = [];
        //     foreach ($old_imgs as $img) {
        //         $old_content_imgs[] = $img;
        //     }
        //     $del_imgs = array_diff($old_content_imgs, $new_content_imgs);

        //     foreach ($del_imgs as $img) {
        //         \File::Delete(public_path().$img->url);
        //         $img->delete();
        //     }
        // }

        $del_imgs = Img::where('tag', 'temp')->get();   //find image not exist in redactor
        foreach ($del_imgs as $key => $img) {
            \File::Delete(public_path().$img->url);    //delete unnecessary image
            $img->delete();
        }

        return $new_content_imgs;
    }

    

    // public function authorImg($news,$request)
    // {
    //     // var_dump($request->hasFile('author_img'));
    //     if($request->hasFile('author_img')){
    //         $img = $request->file('author_img');
    //         $imgName = uniqid('') . '.' . $img->getClientOriginalExtension();
    //         $img_origin_name = $img->getClientOriginalName();

    //         $img->move(base_path() . '/public/uploads/author_img/', $imgName);
    //         $img_path = '/uploads/author_img/'. $imgName;
    //         $img_model = $news->imgs()->where('order','author_img')->first();
    //         if(isset($img_model)){
    //             \File::Delete(public_path().$img_model->url);
    //             $img_model->url = $img_path;
    //         }else{
    //             $img_model = $news->imgs()->create(['url'=>$img_path,'order'=>'author_img']);
    //         }
    //         $img_model->save();
    //     }
    // }

    // public function addhttp($url) {
    //     if(!empty($url)){
    //         if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
    //             $url = "http://" . $url;
    //         }
    //     }
    //     return $url;
    // }
}