<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\NocNotification;

echo "Checking unread notifications...\n";
echo "Total unread notifications: " . NocNotification::where('is_read', false)->count() . "\n";
echo "Unread installation notifications: " . NocNotification::where('type', 'instalasi')->where('is_read', false)->count() . "\n";
echo "Unread maintenance notifications: " . NocNotification::where('type', 'maintenance')->where('is_read', false)->count() . "\n";
echo "Unread keluhan notifications: " . NocNotification::where('type', 'keluhan')->where('is_read', false)->count() . "\n";
echo "Unread terminasi notifications: " . NocNotification::where('type', 'terminasi')->where('is_read', false)->count() . "\n";

echo "\nUnread notifications:\n";
$unreadNotifications = NocNotification::where('is_read', false)->latest()->get();
if ($unreadNotifications->count() > 0) {
    foreach ($unreadNotifications as $n) {
        echo $n->type . ' - ' . $n->title . ' - ID: ' . $n->id . ' - Request ID: ' . ($n->request_id ?? 'null') . ' - Created: ' . $n->created_at . "\n";
    }
} else {
    echo "No unread notifications found.\n";
}

echo "\nMost recent notifications (last 10):\n";
$recentNotifications = NocNotification::latest()->take(10)->get();
foreach ($recentNotifications as $n) {
    echo $n->type . ' - ' . $n->title . ' - ID: ' . $n->id . ' - Request ID: ' . ($n->request_id ?? 'null') . ' - Read: ' . ($n->is_read ? 'Yes' : 'No') . ' - Created: ' . $n->created_at . "\n";
}
