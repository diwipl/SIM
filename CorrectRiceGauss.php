<?php

class CorrectRiceGauss {

    private static $coefs = [
        -0.28955,-0.038892,0.40987,-0.35524,0.14933,-0.035786,0.0049795,-0.00037476,1.1802e-05
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
