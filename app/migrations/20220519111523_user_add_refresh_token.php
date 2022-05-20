<?php
declare(strict_types=1);

use App\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;

final class UserAddRefreshToken extends Migration
{
    public function up()
    {

        $this->schema->table('users', function (Blueprint $table) {

            $table->string('refresh_token')->nullable();

        });
    }

    public function down()
    {
        $this->schema->table('users', function (Blueprint $table) {

            $table->dropColumn('refresh_token');

        });
    }
}
