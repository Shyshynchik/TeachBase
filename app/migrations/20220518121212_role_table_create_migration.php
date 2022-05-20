<?php
declare(strict_types=1);

use \App\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;

final class RoleTableCreateMigration extends Migration
{
    public function up()
    {

        $this->schema->create('roles', function (Blueprint $table) {

            $table->increments('id');

            $table->string('name');

            $table->integer('code');

        });
    }

    public function down()
    {
        $this->schema->drop('roles');
    }
}
