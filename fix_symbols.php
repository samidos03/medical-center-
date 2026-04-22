<?php
$dirs = ['resources/views/medecin', 'resources/views/secretaire', 'resources/views/patient', 'resources/views/admin'];
$count = 0;
foreach ($dirs as $dirPath) {
    $dir = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dirPath));
    foreach ($dir as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $bytes = file_get_contents($file->getPathname());
            $original = $bytes;
            // Fix DeSign In -> Sign Out
            $bytes = str_replace('DeSign In', 'Sign Out', $bytes);
            // Fix diamond symbols (UTF-8 bytes for ◆)
            $bytes = str_replace("\xE2\x97\x86", '-', $bytes);
            // Fix replacement character
            $bytes = str_replace("\xEF\xBF\xBD", '-', $bytes);
            // Fix double dashes
            $bytes = str_replace(' - - ', ' - ', $bytes);
            if ($bytes !== $original) {
                file_put_contents($file->getPathname(), $bytes);
                echo "FIXED: " . $file->getPathname() . "\n";
                $count++;
            }
        }
    }
}
echo "\nTotal fixed: $count files\n";