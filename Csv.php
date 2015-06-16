<?php

/**
 * Created by PhpStorm.
 * User: diwi
 * Date: 07.06.2015
 * Time: 17:17
 */
class Csv
{
    public static function loadFileToArray($file)
    {
        $output = array();

        $file = file($file);

        foreach ($file as $line) {
            $row = explode(',', $line);
            foreach ($row as $key => $value) {
                if ($value == 'Inf') {
                    $row[$key] = INF;
                } else if ($value == '-Inf') {
                    $row[$key] = -INF;
                } else {
                    $row[$key] = floatval($value);
                }
            }

            $output[] = $row;
        }

        return $output;
    }

    public static function saveArrayToFile($data, $file)
    {
        $stream = fopen('data://text/plain,' . "", 'w+');

        foreach ($data as $val) {
            fputcsv($stream, $val);
        }

        rewind($stream);

        file_put_contents($file, stream_get_contents($stream));

        fclose($stream);
    }
}