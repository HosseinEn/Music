<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private const PAGINATEDBY = 10;

    public function calculateCounter($page) {
        $pageNumber = max(1, (int) $page);
        return self::PAGINATEDBY * ($pageNumber - 1);
    }

    public function storeImageOnPublicDisk($imageFile, $name) {
        $path = $imageFile->store("public/{$name}_images");
        return $path;
    }

    public function slugBasedOnNameOrUserInputIfNotNull($request) {
        if($request->slug_based_on_name) {
            $slugBase = $request->name;
        }
        else {
            $slugBase = $request->slug;
            // slug input is null so proceed with name
            $slugBase = $slugBase ?? $request->name;
        }
        return $slugBase;
    }

    public function addImageToModelAndStore($model, $modelName, $imageFileName) {
        if(request()->has($imageFileName)) {
            $imageFile = request()->file($imageFileName);
            $path = $this->storeImageOnPublicDisk($imageFile, $modelName);
            $image = Image::make(["path" => $path]);
            $model->image()->save($image);
        }
    }

    public function uniqueSlugOnUpdate($request, $model, $tableName) {
        $request->validate([
            'slug' => [
                Rule::unique($tableName)->ignore($model->id),
            ],
        ], $this->slugMessage());
    }

    public function slugMessage() {
        return [
            'slug.unique' => 'اسلاگ قبلا استفاده شده است!'
        ];
    }

    public function handleImageOnUpdate($request, $model, $modelName, $imageFileName) {
        if($request->has($imageFileName)) {
            if(!$model->image) {
                $this->addImageToModelAndStore($model, $modelName, $imageFileName);
            }
            else {
                $imageFile = $request->file($imageFileName);
                $this->replaceOldImage($model, $imageFile, $modelName);
            }
        }
    }

    public function replaceOldImage($model, $imageFile, $modelName) {
        $oldImagePath = $model->image->path;
        Storage::delete($oldImagePath);
        $path = $this->storeImageOnPublicDisk($imageFile, $modelName);
        $model->image()->update(["path"=>$path]);
    }

    public function createSlug($request, $model) {
        if(!isset($request->slug)) {
            $slugBase = $request->name;
        }
        else {
            $slugBase = $request->slug;
        }
        $slug = SlugService::createSlug($model, 'slug', strtolower($slugBase));
        if(empty($slug)) {
            $this->slugIsNotValid();
        }
        $request->merge([
            "slug"=>$slug
        ]);
    }

    public function createDuration() {
        $seconds = request()->duration_seconds;
        $minutes = request()->duration_minutes;
        $hours   = request()->duration_hours;
        $duration =  $hours . ':' . $minutes . ':' . $seconds;
        return $duration;
    }

    public function slugIsNotValid() {
        $error = \Illuminate\Validation\ValidationException::withMessages([
            'slug' => ['اسلاگ معتبر نمی باشد!'],
         ]);
         throw $error;
    }
}
