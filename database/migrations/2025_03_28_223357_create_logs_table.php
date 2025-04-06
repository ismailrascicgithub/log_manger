<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateLogsTable extends Migration
{
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            // Owner user of log will be connected by project
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->unsignedTinyInteger('severity_level');
            $table->text('message');
            //User who send the log by API
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            $table->timestamps();
        });

        DB::statement('
            ALTER TABLE logs 
            ADD CONSTRAINT chk_severity_level 
            CHECK (severity_level BETWEEN 0 AND 7)
        ');
    }

    public function down()
    {
        DB::statement('ALTER TABLE logs DROP CONSTRAINT chk_severity_level');
        Schema::dropIfExists('logs');
    }
}