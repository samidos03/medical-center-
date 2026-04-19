<?php
$dirs = ['app', 'routes', 'config', 'bootstrap', 'public', 'database'];
foreach ($dirs as $dir) {
    $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($it as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $content = file_get_contents($file->getPathname());
            if (substr($content, 0, 3) === "\xEF\xBB\xBF") {
                echo "BOM: " . $file->getPathname() . "\n";
                file_put_contents($file->getPathname(), substr($content, 3));
                echo "FIXED: " . $file->getPathname() . "\n";
            }
        }
    }
}
echo "Done!\n";