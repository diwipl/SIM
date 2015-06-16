<?php
set_time_limit(0);

require_once 'RiceHomomorfEstimation.php';
require_once 'Csv.php';

if(!isset($argv[1])) {
    echo 'BŁĄD: Musi zostać podana nazwa pliku konfiguracyjnego'.PHP_EOL;
    die;
}


if(!file_exists($argv[1])) {
    echo 'BŁĄD: Podany plik konfiguracyjny nie istnieje'.PHP_EOL;
    die;
}

$config = parse_ini_file($argv[1]);

if(!isset($config['ex_filter_type']) OR
   !isset($config['ex_window_size']) OR
   !isset($config['ex_iterations']) OR
   !isset($config['lpf_f']) OR
   !isset($config['lpf_f_SNR']) OR
   !isset($config['lpf_f_Rice']) OR
   !isset($config['output_filename_Gaussian']) OR
   !isset($config['output_filename_Rician'])
) {
    echo 'Nie podano wszystkich wymaganych parametrów w pliku konfiguracyjnym'.PHP_EOL;
    die;
}

if(isset($config['input_snr']) AND file_exists($config['input_snr'])) {
    $snr = Csv::loadFileToArray($config['input_snr']);
} else {
    $snr = 0;
}

if(!file_exists($config['input_filename'])) {
    echo 'Podany plik z danymi wejściowymi nie istnieje'.PHP_EOL;
    die;
}

echo 'Trwa wykonywanie obliczeń'.PHP_EOL;

$start = microtime(true);

$riceHomomorf = new RiceHomomorfEstimation();
$riceHomomorf->estimate(
    Csv::loadFileToArray($config['input_filename']),
    $snr,
    $config['lpf_f'],
    $config['lpf_f_SNR'],
    $config['lpf_f_Rice'],
    $config['ex_filter_type'],
    $config['ex_iterations'],
    $config['ex_window_size']
);

Csv::saveArrayToFile($riceHomomorf->mapag,$config['output_filename_Gaussian']);
Csv::saveArrayToFile($riceHomomorf->mapar,$config['output_filename_Rician']);

echo 'Obliczenia zakończone, czas wykonania '.(microtime(true)-$start).'s'.PHP_EOL;

