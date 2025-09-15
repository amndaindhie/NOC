<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\NocNotification;

echo "Checking notifications...\n";
echo "Total notifications: " . NocNotification::count() . "\n";
echo "Installation notifications: " . NocNotification::where('type', 'instalasi')->count() . "\n";
echo "Maintenance notifications: " . NocNotification::where('type', 'maintenance')->count() . "\n";
echo "Keluhan notifications: " . NocNotification::where('type', 'keluhan')->count() . "\n";
echo "Terminasi notifications: " . NocNotification::where('type', 'terminasi')->count() . "\n";

echo "\nRecent 5 notifications:\n";
$notifications = NocNotification::latest()->take(5)->get();
foreach ($notifications as $n) {
    echo $n->type . ' - ' . $n->title . ' - ID: ' . $n->id . ' - Request ID: ' . ($n->request_id ?? 'null') . ' - Read: ' . ($n->is_read ? 'Yes' : 'No') . "\n";
}
