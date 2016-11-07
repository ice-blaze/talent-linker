<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProjectsTable extends Migration
{
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('short_description');
            $table->text('long_description')->nullable();
            $table->text('github_link')->nullable();
            $table->text('siteweb_link')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('projects');
    }
}
