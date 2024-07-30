<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExpiredToVideoRequestsTable extends Migration
{
    public function up()
    {
        Schema::table('video_requests', function (Blueprint $table) {
            $table->enum('status', ['pending', 'approved', 'rejected', 'expired'])->default('pending')->change();
        });
    }

    public function down()
    {
        Schema::table('video_requests', function (Blueprint $table) {
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->change();
        });
    }
}
