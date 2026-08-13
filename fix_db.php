<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

Schema::table('users', function (Blueprint $table) {
    if (!Schema::hasColumn('users', 'user_type')) {
        $table->string('user_type')->nullable()->after('password');
        echo "Added user_type column\n";
    } else {
        echo "Column already exists\n";
    }
});
