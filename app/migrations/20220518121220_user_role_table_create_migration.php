<?php
declare(strict_types=1);

use \App\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;

final class UserRoleTableCreateMigration extends Migration
{
    public function up()
    {
        $this->schema->create('user_role', function(Blueprint $table){

            $table->increments('id');

            $table->integer('user_id');

            $table->integer('role_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');

        });
    }
    public function down()
    {
        $this->schema->drop('user_role');
    }
}
