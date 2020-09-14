<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'ads';

    /**
     * Run the migrations.
     * @table ads
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title');
            $table->text('description');
            $table->string('photo')->nullable();
            $table->string('phone');
            $table->unsignedInteger('cities_id');
            $table->unsignedInteger('users_id');
            $table->unsignedInteger('subsection_id');
            $table->integer('active')->default('0');
            $table->date('date');
            $table->time('time');
            $table->unsignedInteger('admin_id')->nullable();
            $table->integer('grabber')->default('0');

            $table->index(["users_id"], 'fk_ads_users1_idx');

            $table->index(["cities_id"], 'fk_ads_cities1_idx');

            $table->index(["admin_id"], 'fk_ads_admin1_idx');

            $table->index(["subsection_id"], 'fk_ads_subsection1_idx');


            $table->foreign('cities_id', 'fk_ads_cities1_idx')
                ->references('id')->on('cities')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('users_id', 'fk_ads_users1_idx')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('subsection_id', 'fk_ads_subsection1_idx')
                ->references('id')->on('subsections')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('admin_id', 'fk_ads_admin1_idx')
                ->references('id')->on('admin')
                ->onDelete('cascade')
                ->onUpdate('cascade');
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
