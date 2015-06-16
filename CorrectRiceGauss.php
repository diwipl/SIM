<?php

class CorrectRiceGauss {

    private static $coefs = [
        -0.289549906258443,
        -0.0388922575606332,
        0.409867108141953,
        -0.355237628488567,
        0.149328280945610,
        -0.035786111794209,
        0.004979528938591,
        -3.747563744775917e-04,
        1.180202291400923e-05
    ];

    public static function correct($snr) {

        $size = count($snr);

        $Fc = Matrix::addMatrices(
            Matrix::initializeArray($size,$size,self::$coefs[0]),
            Matrix::multiplyMatrices(
                Matrix::initializeArray($size,$size,self::$coefs[1]),
                $snr
            )
        );

        for($i=2;$i<9;$i++) {
            $Fc = Matrix::addMatrices(
                $Fc,
                Matrix::multiplyMatrices(
                    Matrix::initializeArray($size,$size,self::$coefs[$i]),
                    Matrix::power($snr,$i)
                )
            );
        }

        for($i=0;$i<$size;$i++) {
            for($j=0;$j<$size;$j++) {
                if($snr[$i][$j] <= 7) {
                    $snr[$i][$j] = $Fc[$i][$j];
                } else {
                    $snr[$i][$j] = 0;
                }
            }
        }

        return $snr;
    }

}
