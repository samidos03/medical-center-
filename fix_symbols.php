<?php
$dir = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('resources/views'));
$count = 0;
foreach ($dir as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $bytes = file_get_contents($file->getPathname());
        $original = $bytes;
        // Fix diamond symbol UTF-8
        $bytes = str_replace("\xE2\x97\x86", '-', $bytes);
        $bytes = str_replace("\xEF\xBF\xBD", '-', $bytes);
        // Fix DeSign In
        $bytes = str_replace('DeSign In', 'Sign Out', $bytes);
        if ($bytes !== $original) {
            file_put_contents($file->getPathname(), $bytes);
            echo "FIXED: " . $file->getPathname() . "\n";
            $count++;
        }
    }
}
echo "Total: $count files\n";