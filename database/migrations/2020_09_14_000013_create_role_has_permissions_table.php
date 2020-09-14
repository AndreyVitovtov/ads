<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleHasPermissionsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'role_has_permissions';

    /**
     * Run the migrations.
     * @table role_has_permissions
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('role_id');
            $table->unsignedInteger('permissions_id');

            $table->index(["permissions_id"], 'fk_role_has_permissions_permissions1_idx');

            $table->index(["role_id"], 'fk_role_has_permissions_role1_idx');


            $table->foreign('role_id', 'fk_role_has_permissions_role1_idx')
                ->references('id')->on('roles')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('permissions_id', 'fk_role_has_permissions_permissions1_idx')
                ->references('id')->on('permissions')
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
