<?php
declare(strict_types=1);

use App\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;

final class RoleRefactorMigration extends Migration
{
    public function up()
    {

        $this->schema->table('roles', function (Blueprint $table) {

            $table->renameColumn('role', 'name');

            $table->integer('code');

        });
    }

    public function down()
    {
        $this->schema->table('roles', function (Blueprint $table) {

            $table->renameColumn('name', 'role');

            $table->dropColumn('code');

        });
    }
}
