<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::create('/login', 'POST', [
    'email' => 'admin@gmail.com',
    'password' => 'admin123',
]);
$response = $kernel->handle($request);

echo "Status: " . $response->getStatusCode() . "\n";
echo "Location: " . $response->headers->get('Location') . "\n";
echo "Errors: " . json_encode(session('errors') ? session('errors')->getBag('default')->getMessages() : []) . "\n";
