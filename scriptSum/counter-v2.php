<?php

/**
 * @param string $directory Исходная директория.
 * @param string $targetFile Наименование искомого файла.
 * 
 * @return float
 */
function countSum(string $directory, string $targetFile = 'count'): float
{
    $sum = 0;
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));

    /** @var SplFileInfo $file */
    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getFilename() === $targetFile) {

            $content = file_get_contents($file->getPathname());

            preg_match_all('/-?\d+(\.\d+)?/', $content, $out);

            $sum += array_sum($out['0']);
        }
    }

    return $sum;
}

$start = microtime(true);

print_r('Сумма: ' . countSum('./../directory') . "\n");

print_r('Время выполнения: ' . microtime(true) - $start);