<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSuperadminFieldsToUsersTable extends Migration
{
    /**
     * user_type values:
     *   0 = Super Admin (can toggle leave window, reset employee locks)
     *   1 = Admin / HR
     *   2 = Employee (portal user)
     *
     * user_type column already exists on the users table.
     * This migration is a no-op schema change; it exists to document
     * the new user_type = 0 convention and is safe to run.
     */
    public function up()
    {
        // No schema change required — user_type INT column already exists.
        // If you need to create a super admin account manually, run:
        // INSERT INTO users (name, email, password, user_type, created_at, updated_at)
        // VALUES ('Super Admin', 'superadmin@sgpayroll.com', bcrypt('yourPassword'), 0, NOW(), NOW());
    }

    public function down()
    {
        // Nothing to revert
    }
}
