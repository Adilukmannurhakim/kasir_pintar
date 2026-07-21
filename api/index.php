<?php

// Tentukan direktori temporer khusus untuk Vercel
$storagePath = '/tmp/storage';
$cachePath = '/tmp/bootstrap/cache';

// Buat direktori jika belum ada
if (!is_dir($storagePath)) {
    mkdir($storagePath . '/framework/views', 0755, true);
    mkdir($storagePath . '/framework/sessions', 0755, true);
    mkdir($storagePath . '/framework/cache', 0755, true);
    mkdir($storagePath . '/logs', 0755, true);
}

if (!is_dir($cachePath)) {
    mkdir($cachePath, 0755, true);
}

// Set environment variable untuk storage & cache
putenv('APP_STORAGE=' . $storagePath);
$_ENV['APP_STORAGE'] = $storagePath;

// Forward ke index.php Laravel bawaan
require __DIR__ . '/../public/index.php';