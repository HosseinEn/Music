<?php

namespace Tests\Feature;

use App\Models\Artist;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ArtistTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_artistIndexRoute()
    {
        $user = $this->user();
        $this->actingAs($user);
        $response = $this->get('/admin/artists');
        $response->assertStatus(200);
    }

    public function test_createArtistAndStoringImage()
    {
        Storage::fake();
        $user = $this->user();
        $this->actingAs($user);
        $artist = $this->createDummyArtistThroughPostRequest($user);
        unset($artist["image"]);
        $this->assertDatabaseHas("artists", $artist);
        $artist = Artist::where('id', 1)->get()->first();
        $image = $artist->image;
        Storage::assertExists($image->path);
    }

    public function test_updateArtistThroughMassAssignment()
    {
        $user = $this->user();
        $this->actingAs($user);
        $artist = $this->createDummyArtist($user);
        $artist->name = "updated_name";
        $artist->save();
        $this->assertDatabaseHas("artists", ["name"=>"updated_name"]);
    }

    public function test_updateArtistThroughPutRequest() {
        Storage::fake();
        $user = $this->user();
        $this->actingAs($user);
        $this->createDummyArtistThroughPostRequest($user);
        $artist = Artist::where('slug', 'hozi-slug')->get()->first();
        $imagePathNameBeforeUpdate = $artist->image->path;
        $artistAfterUpdateArray = $this->createArtistPutRequest($user, $artist);
        $updatedArtist = Artist::where('slug', $artistAfterUpdateArray["slug"])->get()->first();
        $updatedImagePathAndName = $updatedArtist->image->path;
        $this->checkingImageReplace($imagePathNameBeforeUpdate, $updatedImagePathAndName);
    }

    public function checkingImageReplace($oldImagePath, $newImagePath) {
        $this->assertDatabaseMissing("images", ["path"=>$oldImagePath]);
        $this->assertDatabaseHas("images", ["path"=>$newImagePath]);
        Storage::assertMissing($oldImagePath);
        Storage::assertExists($newImagePath);
    }

    public function test_deleteArtist() {
        Storage::fake();
        $user = $this->user();
        $this->actingAs($user);
        $artist = $this->createDummyArtistThroughPostRequest($user);
        $artistModel = Artist::where('slug', $artist["slug"])->get()->first();
        $imagePath = $artistModel->image->path;
        $this->delete(route('artists.destroy', $artistModel->slug));
        unset($artist["image"]);
        $this->assertDatabaseMissing("artists", $artist);
        $this->assertDatabaseMissing('images', ["path"=>$imagePath]);
        Storage::assertMissing($imagePath);
    }

    public function test_thereExistArtistOnAdminArtistIndexPage() {
        $user = $this->user();
        $this->actingAs($user);
        $artist = $this->createDummyArtist($user);
        $response = $this->get('/admin/artists');
        $response->assertSeeText("hozi");
    }

    public function test_thereExistArtistOnAdminArtistShowPage() {
        $user = $this->user();
        $this->actingAs($user);
        $artist = $this->createDummyArtist($user);
        $response = $this->get(route("artists.show", $artist->slug));
        $response->assertSeeText("hozi");
    }

    // public function test_slugCreatedByName() {

    // }

    public function createDummyArtist($user) {
        $artist = [
            "name"=>"hozi",
            "slug"=>"hozi-slug",
            "user_id"=>$user->id
        ];
        $artist = Artist::create($artist);
        return $artist;
    }

    public function createDummyArtistThroughPostRequest($user) {
        $image = UploadedFile::fake()->image('avatar.jpg');
        $artist = [
            "name"=>"hozi",
            "slug"=>"hozi-slug",
            "user_id"=>$user->id,
            "image"=>$image
        ];
        $this->post(route("artists.store"), $artist);
        return $artist;
    }

    public function createArtistPutRequest($user, $artist) {
        $image = UploadedFile::fake()->image('updated_avatar.jpg');
        $artistWithPhoto = [
            "name"=>"hozi",
            "slug"=>"updated-hozi",
            "user_id"=>$user->id,
            "image" => $image
        ];
        $this->put(route('artists.update', $artist->slug), $artistWithPhoto);
        return $artistWithPhoto;
    }

}
