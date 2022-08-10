<?php

namespace App\Http\Controllers;

use App\Models\Image;
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

    public function storeImageOnPublicDisk($imageFile, $name, $id) {
        $dateAndTime = now()->format("Y-m-d_hmsu");
        $extension = $imageFile->guessClientExtension();
        $path = $imageFile->storeAs("public/{$name}_images", "{$name}_{$id}_{$dateAndTime}.{$extension}");
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

    public function addImageToModelAndStore($request, $model, $modelName, $imageFileName) {
        $imageFile = $request->file($imageFileName);
        $path = $this->storeImageOnPublicDisk($imageFile, $modelName, $model->id);
        $image = Image::make(["path" => $path]);
        $model->image()->save($image);
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
                $this->addImageToModelAndStore($request, $model, $modelName, $imageFileName);
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
        $path = $this->storeImageOnPublicDisk($imageFile, $modelName, $model->id);
        $model->image()->update(["path"=>$path]);
    }


}
