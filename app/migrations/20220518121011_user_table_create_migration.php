<?php
declare(strict_types=1);

use \App\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;

final class UserTableCreateMigration extends Migration
{
    public function up()
    {
        $this->schema->create('users', function (Blueprint $table) {

            $table->increments('id');

            $table->string('name');

            $table->string('email')->unique();

            $table->string('password');

            $table->string('token')->nullable();

            $table->string('refresh_token')->nullable();

        });
    }

    public function down()
    {
        $this->schema->drop('users');
    }
}
