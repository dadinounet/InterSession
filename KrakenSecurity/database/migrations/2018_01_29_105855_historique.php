<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Historique extends Migration
{


    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function(Blueprint $table) {
            $table->increments('id');
            $table->string('repoGit', 255);
            $table->string('name', 100);
            $table->integer('user_id');
            $table->timestamps();

        });


        Schema::create('tests', function(Blueprint $table) {
            $table->increments('id');
            $table->string('source', 255);
            $table->integer('projectId');
            $table->timestamps();
        });



        Schema::create('reports', function(Blueprint $table) {
            $table->increments('id');
            $table->longText('report');
            $table->integer('testId');
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
        Schema::dropIfExists('projects');
        Schema::dropIfExists('tests');
        Schema::dropIfExists('reports');
    }
}
