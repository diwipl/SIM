<?php

require_once 'FFT.class.php';

class LPF
{
    public static function calc($image, $sigma)
    {

        $mx = count($image);
        $my = count($image[0]);

        $h = array(array());
        for ($i = 0; $i < $mx; $i++) {
            for ($j = 0; $j < $my; $j++) {
                $x = abs($i - ($mx-1) / 2);
                $y = abs($j - ($my-1) / 2);
                $h[$i][$j] = 1 / (2 * pi() * $sigma * $sigma) * exp( - ($x*$x + $y*$y)/(2*$sigma*$sigma));
            }
        }

        $h = Matrix::divide($h, max(max($h)));
        $lRnF=LPF::fftshift(LPF::fft2($image));
        $lRnF2=Matrix::multiplyComplexMatrixByRealMatrix($lRnF, $h);

        $ir = LPF::ifft2(LPF::fftshift($lRnF2));
        for ($i = 0; $i < $mx; $i++) {
            for ($j = 0; $j < $my; $j++) {
                $ir[$i][$j] = $ir[$i][$j]->getReal();
            }
        }
        return $ir;
    }



    public static function fft2($data) {
        $rows = count($data);
        $cols = count($data[0]);

        $fft1 = new FFT($rows);
        $fft2 = new FFT($cols);

        $complex = array();

        function imag($complex) {
            return $complex->getImag();
        }

        for ($i = 0; $i < $rows; $i++) {
            $f = $fft1->fft($data[$i]);
            $data[$i] = $fft2->complexToDouble($f);
            $complex[$i] = array_map('imag', $f);
        }
        for ($i = 0; $i < $cols; $i++) {
            $data = Matrix::setColumn($data, $i, $fft2->fft(Matrix::getColumn($data, $i)));
            $complex = Matrix::setColumn($complex, $i, $fft2->fft(Matrix::getColumn($complex, $i)));
        }
        for ($i = 0; $i < $rows; $i++) {
            for ($j = 0; $j < $cols; $j++) {
                $c = Complex::Cmul($complex[$i][$j], new Complex(0, 1));
                $data[$i][$j] = Complex::Cadd($data[$i][$j], $c);
            }
        }
        return $data;
    }

    public static function ifft2($data) {
        $rows = count($data);
        $cols = count($data[0]);

        $fft1 = new FFT($rows);
        $fft2 = new FFT($cols);

        for ($i = 0; $i < $cols; $i++) {
            $f = $fft2->ifft(Matrix::getColumn($data, $i));
            for ($j = 0; $j < count($f); $j++) {
                $f[$j] = Complex::Cinv($f[$j]);
            }
            $data = Matrix::setColumn($data, $i, $f);
        }
        for ($i = 0; $i < $rows; $i++) {
            $data[$i] = $fft1->ifft($data[$i]);
        }
        return $data;
    }

    public static function fftshift($data) {
        $rows = count($data);
        $cols = count($data[0]);

        $offsetx = ceil($cols/2);
        $offsety = ceil($rows/2);

        $new = array(array());
        for ($i = 0; $i < $rows; $i++) {
            for ($j = 0; $j < $cols; $j++) {
                $x = ($i+$offsetx)%$cols;
                $y = ($j+$offsety)%$rows;

                $new[$i][$j] = $data[$x][$y];
            }
        }

        return $new;
    }
}