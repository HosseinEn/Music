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
        Storage::fake('avatars');
        $user = $this->user();
        $this->actingAs($user);
        $image = UploadedFile::fake()->image('avatar.jpg');
        $artist = [
            "id"=>1,
            "name"=>"hozi",
            "slug"=>"hozi-slug",
            "user_id"=>$user->id,
            "image"=>$image
        ];
        $this->post(route("artists.store"), $artist);
        unset($artist["image"]);
        $this->assertDatabaseHas("artists", $artist);
        $artist = Artist::where('id', 1)->get()->first();
        $image = $artist->image;
        Storage::assertExists($image->path);
    }

    public function test_updateArtist()
    {
        $user = $this->user();
        $this->actingAs($user);
        $artist = $this->createDummyArtist($user);
        // updating
        $artist->name = "updated_name";
        $artist->save();
        $this->assertDatabaseHas("artists", ["name"=>"updated_name"]);
    }

    public function test_deleteArtist() {
        $user = $this->user();
        $this->actingAs($user);
        $artist = $this->createDummyArtist($user);
        $artist->delete();
        $this->assertDatabaseMissing("artists", $artist->toArray());
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

    public function createDummyArtist($user) {
        $artist = [
            "id"=>1,
            "name"=>"hozi",
            "slug"=>"hozi-slug",
            "user_id"=>$user->id
        ];
        $artist = Artist::create($artist);
        return $artist;
    }


}
