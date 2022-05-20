<?php
declare(strict_types=1);

use App\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;

final class UserRefactorMigration extends Migration
{
    public function up()
    {

        $this->schema->table('users', function (Blueprint $table) {

            $table->string('token')->nullable();

        });
    }

    public function down()
    {
        $this->schema->table('users', function (Blueprint $table) {

            $table->dropColumn('token');

        });
    }
}
