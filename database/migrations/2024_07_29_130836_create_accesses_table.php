<?php

// database/migrations/xxxx_xx_xx_create_accesses_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccessesTable extends Migration
{
    public function up()
    {
        Schema::create('accesses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('request_id')->constrained('video_requests')->onDelete('cascade');
            $table->timestamp('access_start_time');
            $table->timestamp('access_end_time');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('accesses');
    }
}

