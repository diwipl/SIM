<?php

require_once 'Complex.class.php';
require_once 'FFT.class.php';

class iDCT
{
    public $ww;
    public $inds;

    public function __construct($rowsCount)
    {
        $this->computeIdct($rowsCount);

    }


    public function computeIdct($rowsCount) {
        $this->ww = array();
        $this->inds = array();


        for ($i = 0; $i < $rowsCount; $i++) {
            $baseComplex = new Complex(0, (-1 * pi() / (2 * $rowsCount)) * $i);
            $baseComplex = Complex::Cexp($baseComplex);
            $baseComplex = Complex::RCmul(2, $baseComplex);
            $baseComplex = Complex::RCdiv(sqrt(2 * $rowsCount), $baseComplex);

            $this->ww[] = $baseComplex;
        }

        $this->ww[0] = Complex::RCdiv(sqrt(2), $this->ww[0]);

        $tmp = array();

        $counter = 1;

        for($i=0;$i<$rowsCount;$i+=2) {
            $tmp[$i] = $counter;
            $counter++;
        }

        $counter = $rowsCount;

        for($i=1;$i<$rowsCount;$i+=2) {
            $tmp[$i] = $counter;
            $counter--;
        }

        $mul = array();
        $ind = array();

        for($i = 0; $i < $rowsCount; $i++) {
            $mul[] = $i*$rowsCount;
        }

        for($i=0;$i<$rowsCount;$i++) {
            $row = array();

            for($j=0;$j<$rowsCount;$j++) {
                $row[] = $tmp[$i]+$mul[$j];
            }

            $ind[] = $row;
        }

        $this->inds = $ind;
    }

    public function idct2d($data) {
        return Matrix::transpose(
            $this->idct1d(
                Matrix::transpose(
                    $this->idct1d($data)
                )
            )
        );
    }

    public function idct1d($data) {


        $size = count($data);

        $fft = new FFT($size);

        for($i=0;$i<$size;$i++) {
            for($j=0;$j<$size;$j++) {
                $data[$i][$j] = Complex::RCmul($data[$i][$j], $this->ww[$i]);
            }
        }

        $result = array();

        for($i=0;$i<$size;$i++) {
            $result[$i] = self::fft(Matrix::getColumn($data,$i));
        }

        $result = Matrix::transpose($result);

        $result = $this->reoder($result,$this->inds);

        for($i=0;$i<$size;$i++) {
            for($j=0;$j<$size;$j++) {
                $result[$i][$j] = $result[$i][$j]->getReal();
            }
        }

        return $result;
    }

    public static function fft($data) {
        $real = array();
        $imag = array();
        $size = count($data);

        $fft = new FFT($size);


        for($i=0;$i<$size;$i++) {
            $real[$i] = $data[$i]->getReal();
            $imag[$i] = -1*$data[$i]->getImag();
        }


        $real = $fft->fft($real);
        $imag = $fft->fft($imag);

        for($i=0;$i<$size;$i++) {
            $c = Complex::Cmul($imag[$i], new Complex(0, 1));
            $data[$i] = Complex::Cadd($real[$i], $c);
        }

        return $data;
    }

    public function reoder($data,$inds) {
        $size = count($data);
        $newData = Matrix::initializeArray($size,$size,0);

        for($i=0;$i<$size;$i++) {
            for($j=0;$j<$size;$j++) {
                $indice = $inds[$i][$j];
                $newData[$i][$j] = $data[$this->determineRow($indice,$size)][$this->determineColumn($indice,$size)];
            }
        }

        return $newData;
    }


    public function determineColumn($i, $n) {
        return ceil($i/$n)-1;
    }

    public function determineRow($i, $n) {
        return ($i-$this->determineColumn($i, $n)*$n)-1;
    }

}
