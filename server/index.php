<?php
// server/index.php

// Set default min and max delay in seconds
$minDelay = isset($_GET['min_delay']) ? (float)$_GET['min_delay'] : 0.1;
$maxDelay = isset($_GET['max_delay']) ? (float)$_GET['max_delay'] : 1.0;

// Generate a random delay
$delay = mt_rand($minDelay * 1000000, $maxDelay * 1000000) / 1000000;

// Wait for the random delay
usleep($delay * 1000000);

// Prepare a simple JSON response
header('Content-Type: application/json');
echo json_encode([
    'status' => 'success',
    'message' => 'Response after ' . round($delay, 3) . ' seconds',
    'delay_seconds' => $delay,
    'timestamp' => (new DateTime())->format('Y-m-d\TH:i:s.vP')
]);
?>
