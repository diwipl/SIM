<?php
/**
 * Created by PhpStorm.
 * User: diwi
 * Date: 06.06.2015
 * Time: 17:44
 */
include 'Bessel.php';
include 'Convolution.php';

$input = array(
    [1,2,3],
    [4,5,6],
    [7,8,9]
);

$kernel = [
    [-1,-2,-1],
    [0,0,0],
    [1,2,1]
];


print_r(
    Convolution::convolution2D(
        Convolution::expandInput($input),
        $kernel
    )
);
