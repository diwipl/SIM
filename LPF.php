<?php

require_once 'Matrix.php';
require_once 'iDCT.php';

class LPF
{
    public static function calc($image, $sigma)
    {
        $mx = count($image);
        $my = count($image[0]);
        $h1 = array(array());
        for ($i = 0; $i < 2*$mx; $i++) {
            for ($j = 0; $j < 2*$my; $j++) {
                $x = $i - $mx + 0.5;
                $y = $j - $my + 0.5;
                $h1[$i][$j] = 1 / (2 * pi() * 2*$sigma * 2*$sigma) * exp( - ($x*$x + $y*$y)/(2*2*$sigma*2*$sigma));
            }
        }
        $h1 = Matrix::divide($h1, max(max($h1)));
        $h = array(array());
        for ($i = 0; $i < $mx; $i++) {
            for ($j = 0; $j < $my; $j++) {
                $h[$i][$j] = $h1[$i+$mx][$j+$my];
            }
        }

        $lRnF=LPF::dct2($image);
        $lRnF2=Matrix::multiplyMatrices($lRnF, $h);
        $r = LPF::idct2($lRnF2);


        return $r;
    }



    public static function dct($data) {
        $out = array();
        $n = count($data);
        $out[0] = 1/sqrt($n)*array_sum($data);
        for ($i = 1; $i < $n; $i++) {
            $sum = 0;
            for ($j = 0; $j < $n; $j++) {
                $sum += $data[$j]*cos(pi()*$i*(2*$j+1)/(2*$n));
            }
            $out[$i] = sqrt(2/$n)*$sum;
        }
        return $out;
    }
    public static function dct2($data) {
        for ($row = 0; $row < count($data); $row++) {
            $data[$row] = LPF::dct($data[$row]);
        }
        $cols = count($data[0]);
        for ($col = 0; $col < $cols; $col++) {
            $afterDct = LPF::dct(Matrix::getColumn($data, $col));
            $data = Matrix::setColumn($data, $col, $afterDct);
        }
        return $data;
    }

    public static function idct2($data) {
        $size = count($data);
        $idct = new iDCT($size);

        return $idct->idct2d($data);
    }
}