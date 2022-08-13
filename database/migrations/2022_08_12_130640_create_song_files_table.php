<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSongFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('song_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("song_id");
            $table->foreign("song_id")->references("id")->on("songs")->onDelete("cascade");
            $table->string("quality");
            $table->string("duration");
            $table->string("path");
            $table->string("extension");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('song_files');
    }
}
