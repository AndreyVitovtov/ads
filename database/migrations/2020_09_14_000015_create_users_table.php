<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'users';

    /**
     * Run the migrations.
     * @table users
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('chat');
            $table->string('username');
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->date('date');
            $table->time('time');
            $table->integer('count_ref')->default('0');
            $table->string('country')->nullable();
            $table->string('messenger');
            $table->integer('access')->nullable()->default('0');
            $table->integer('active')->nullable();
            $table->integer('start')->nullable()->default('0');
            $table->integer('access_free')->nullable()->default('0');
            $table->unsignedInteger('languages_id')->nullable();

            $table->index(["languages_id"], 'fk_users_languages1_idx');


            $table->foreign('languages_id', 'fk_users_languages1_idx')
                ->references('id')->on('languages')
                ->onDelete('no action')
                ->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->tableName);
     }
}
