<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEpisodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('episodes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('show_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->integer('duration'); // in minutes
            $table->string('airing_time'); // e.g., "Monday @ 8:30 PM"
            $table->mediumText('thumbnail')->nullable();
            $table->mediumText('video_url')->nullable();
            $table->integer('likes')->default(0);
            $table->integer('dislikes')->default(0);
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
        Schema::dropIfExists('episodes');
    }
}
