<?php
/**
 * Created by PhpStorm.
 * User: diwi
 * Date: 06.06.2015
 * Time: 17:44
 */
include 'Complex.class.php';
include 'DCT.php';
require_once 'Csv.php';
require_once 'FFT.class.php';
require_once 'LPF.php';
require_once 'Matrix.php';
 $array = [
    [1,2,3,4],
    [4,5,6,4],
    [7,8,9,4],
    [4,4,4,4] ];

print_R( LPF::dct2($array) );
