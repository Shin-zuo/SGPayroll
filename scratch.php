<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$employee = \SGpayroll\Employee::first();
echo "ID: " . $employee->id . "\n";
echo "Name: " . $employee->full_name . "\n";
echo "Phic Status: " . $employee->phic_status . " (" . gettype($employee->phic_status) . ")\n";
echo "Pag-ibig Contribution: " . $employee->pag_ibig_contribution . " (" . gettype($employee->pag_ibig_contribution) . ")\n";
echo "Pagibig Amount: " . $employee->pagibig_amount . "\n";
