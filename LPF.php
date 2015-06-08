<?php

class LPF
{
    public static function calc($image, $sigma, $modo = 'DCT')
    {
        if ($modo == 'DFT') {/*
            $mx = count($i);
            $my = count($i[0]);


            $h = array(array());
            $cx = $mx/2;
            $cy = $my/2;
            for ($i = -$cx; $i <= $cx; $i++) {
                for ($j = -$cy; $j <= $cy; $j++) {
                    $h[$i][$j] = 1 / (2 * pi() * sigma * sigma) * exp( - ($i*$i + $j*$j)/2*sigma*sigma);
                }
            }
*/
            return null;
        } else {
            $mx = count($image);
            $my = count($image[0]);

            $h1 = array(array());
            for ($i = 0; $i < 2*$mx; $i++) {
                for ($j = 0; $j < 2*$my; $j++) {
                    $x = $i - $mx + 0.5;
                    $y = $j - $my + 0.5;
                    $h1[$i][$j] = 1 / (2 * pi() * 2*$sigma * 2*$sigma) * exp( - ($x*$x + $y*$y)/2*2*$sigma*2*$sigma);
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
            //real values?
            $r = LPF::idct2($lRnF2);
            return $r;
        }
    }

    public static function dct($data) {
        $out = array();
        $n = count($data);

        $out[0] = round(1/sqrt($n)*array_sum($data), 4);

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

    public static function idct($data) {
        $out = array();
        $n = count($data);

        for ($i = 0; $i < $n; $i++) {
            $sum = 0;
            for ($j = 1; $j < $n; $j++) {
                $sum += $data[$j]*cos(pi()*$j*(2*$i+1)/(2*$n));
            }
            $out[$i] = 1/sqrt($n)*$data[0] + sqrt(2/$n) * $sum;
        }

        return $out;
    }

    //TODO nie dziala
    public static function idct2($data) {
        $data_r = array(array());
        for ($row = 0; $row < count($data); $row++) {
            $data_r[$row] = LPF::idct($data[$row]);
        }
        $cols = count($data[0]);
        for ($col = 0; $col < $cols; $col++) {
            $afterDct = LPF::idct(Matrix::getColumn($data, $col));
            $data = Matrix::setColumn($data, $col, $afterDct);
        }
        return Matrix::multiplyMatrices($data_r, $data);
    }
}