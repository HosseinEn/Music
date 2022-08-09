<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private const PAGINATEDBY = 10;

    public function calculateCounter($page) {
        $pageNumber = max(1, (int) $page);
        return self::PAGINATEDBY * ($pageNumber - 1);
    }

    public function storeImageOnPublicDisk($imageFile, $name, $id) {
        $date = now()->format("Y-m-d");
        $extension = $imageFile->guessClientExtension();
        $path = $imageFile->storeAs("public/{$name}_images", "{$name}_{$id}_{$date}.{$extension}");
        return $path;
    }
}
