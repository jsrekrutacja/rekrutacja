<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

class AlterTableUserAddColumnRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('users', function ($table) {
            $table->enum('role', [User::ROLE_USER, User::ROLE_ADMIN, User::ROLE_EDITOR])->default(User::ROLE_USER);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('users', function ($table) {
            $table->dropColumn('role');
        });
    }
}
