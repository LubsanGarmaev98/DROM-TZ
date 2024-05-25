<?php

declare(strict_types=1);

/**
 * @param string $directory Исходная директория.
 * @param string $targetFile Наименование искомого файла.
 *
 * @return float
 */
function countSum(string $directory, string $targetFile = 'count'): float
{
    $sum = 0;

    if (!is_dir($directory)) {
        return $sum;
    }

    foreach (scandir($directory) as $file) {

        if (in_array($file, ['.', '..'])) {
            continue;
        }

        if (is_dir( $directory . '/' . $file)) {
            $sum += countSum($directory . '/' . $file);

            continue;
        }

        if ($file !== $targetFile) {
            continue;
        }

        $fileId = fopen($directory . '/' . $file, 'r');

        if (isset($fileId)) {
            while (($fileResouce = fgets($fileId)) !== false) {
                $out = [];
                
                preg_match_all('/-?\d+(\.\d+)?/', $fileResouce, $out);

                $sum += array_sum($out['0']);
            }

            if (!feof($fileId)) {
                throw new Exception("Ошибка: fgets() неожиданно потерпел неудачу\n");
            }
        }

        fclose($fileId);
    }

    return $sum;
}

$start = microtime(true);

print_r('Сумма: ' . countSum('./../directory') . "\n");

print_r('Время выполнения: ' . microtime(true) - $start);