<?php
/**
 * Bootstrap storage setup for development
 * This ensures the storage directories and symlink are created
 */

$baseDir = __DIR__;
$publicDir = $baseDir . '/public';
$storageDir = $baseDir . '/storage/app/public';
$uploadsDir = $storageDir . '/uploads/players';
$storageLinkPath = $publicDir . '/storage';

// Create directories if they don't exist
if (!is_dir($uploadsDir)) {
    @mkdir($uploadsDir, 0755, true);
    echo "✓ Created uploads directory: $uploadsDir\n";
}

// Create symlink if it doesn't exist
if (!is_link($storageLinkPath)) {
    if (PHP_OS_FAMILY === 'Windows') {
        // On Windows, use junction instead of symlink
        $command = "mklink /J \"$storageLinkPath\" \"$storageDir\"";
        exec($command, $output, $returnCode);
        if ($returnCode === 0) {
            echo "✓ Created storage junction (Windows): $storageLinkPath -> $storageDir\n";
        } else {
            echo "✗ Failed to create storage junction\n";
            echo "  Run this command as Administrator:\n";
            echo "  mklink /J \"$storageLinkPath\" \"$storageDir\"\n";
        }
    } else {
        // On Unix/Linux, use symlink
        if (symlink($storageDir, $storageLinkPath)) {
            echo "✓ Created storage symlink: $storageLinkPath -> $storageDir\n";
        } else {
            echo "✗ Failed to create storage symlink\n";
        }
    }
} else {
    echo "✓ Storage link already exists\n";
}

echo "\nStorage setup complete!\n";
