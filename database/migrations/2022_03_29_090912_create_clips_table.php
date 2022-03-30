<?php

use App\Enums\ClipStates;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clips', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('creator_id');
            $table->unsignedBigInteger('game_id');
            $table->string('tracking_id');
            $table->string('state')->default(ClipStates::Active->value);
            $table->string('url');
            $table->string('title');
            $table->string('thumbnail_url');
            $table->integer('duration');
            $table->integer('views')->nullable();
            $table->timestamp('freshed_at');
            $table->timestamp('published_at');
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
        Schema::dropIfExists('clips');
    }
};
