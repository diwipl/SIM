<?
set_time_limit(0);

require_once 'RiceHomomorfEstimation.php';
require_once 'Csv.php';

 if(!isset($_POST['ex_filter_type'])) {

     header('Content-Type: text/html; charset=utf-8');
     ?>
<form method="post" enctype="multipart/form-data">
    Plik MRI: <input type="file" name="input_filename"><br />
    Plik Szumu: <input type="file" name="input_snr"><br />
    Rodzaj filtra: <select name="ex_filter_type">
        <option value="1">Local mean</option>
        <option value="2">Expectation-maximization</option>
    </select><br />
    Rozmiar okna: <input type="text" name="ex_window_size" value="3"><br />
    Ilość iteracji: <input type="text" name="ex_iterations" value="10"><br />
    Sigma LPF: <input type="text" name="lpf_f" value="3.4"><br />
    Sigma LPF SNR: <input type="text" name="lpf_f_SNR" value="1.2"><br />
    Sigma LPF Rice: <input type="text" name="lpf_f_Rice" value="5.4"><br />
    <input type="submit" value="oblicz" />
</form>
<?

} else {

    $config = $_POST;

     if(!isset($config['ex_filter_type']) OR
        !isset($config['ex_window_size']) OR
        !isset($config['ex_iterations']) OR
        !isset($config['lpf_f']) OR
        !isset($config['lpf_f_SNR']) OR
        !isset($config['lpf_f_Rice'])
     ) {
         echo 'Nie podano wszystkich wymaganych parametrów '.PHP_EOL;
         die;
     }

    if(!file_exists($_FILES["input_filename"]["tmp_name"])) {
        echo 'Wgranie pliku nie powiodło się';
        die;
    }

    if(file_exists($_FILES["input_snr"]["tmp_name"])) {
         $snr = Csv::loadFileToArray($_FILES["input_snr"]["tmp_name"]);
    } else {
         $snr = 0;
    }


    $riceHomomorf = new RiceHomomorfEstimation();
    $riceHomomorf->estimate(
         Csv::loadFileToArray($_FILES["input_filename"]["tmp_name"]),
         $snr,
         $config['lpf_f'],
         $config['lpf_f_SNR'],
         $config['lpf_f_Rice'],
         $config['ex_filter_type'],
         $config['ex_iterations'],
         $config['ex_window_size']
     );

     $id = md5(rand(0,10000000));

     Csv::saveArrayToFile($riceHomomorf->mapag,$id.'_gaussian.csv');
     Csv::saveArrayToFile($riceHomomorf->mapar,$id.'_rician.csv');

     $files = array($id.'_gaussian.csv', $id.'_rician.csv');
     $tempZipname = $id.'_zip.zip';
     $zipname = 'homomorf_estimation.zip';
     $zip = new ZipArchive;
     $zip->open($tempZipname, ZipArchive::CREATE);
     foreach ($files as $file) {
         $zip->addFile($file);
     }
     $zip->close();

     header('Content-Type: application/zip');
     header('Content-disposition: attachment; filename='.$zipname);
     header('Content-Length: ' . filesize($tempZipname));
     readfile($tempZipname);

     unlink($id.'_gaussian.csv');
     unlink($id.'_rician.csv');
     unlink($tempZipname);
}

?>