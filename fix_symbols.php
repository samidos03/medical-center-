<?php
$dir = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('resources/views'));
$count = 0;
foreach ($dir as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $content = file_get_contents($file->getPathname());
        $original = $content;
        // Remove diamond symbol and variants
        $content = str_replace(['◆', '◇', '♦', "\xE2\x97\x86", "\xE2\x97\x87", "\xE2\x99\xA6"], ' - ', $content);
        // Remove replacement character
        $content = str_replace(["\xEF\xBF\xBD", '�'], ' - ', $content);
        // Clean double separators
        $content = str_replace(' -  - ', ' - ', $content);
        if ($content !== $original) {
            file_put_contents($file->getPathname(), $content);
            echo "FIXED: " . $file->getPathname() . "\n";
            $count++;
        }
    }
}
echo "\nTotal fixed: $count files\n";