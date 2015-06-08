<?php

class ExpectationMaximization
{
    public function createMask($input, $N, $windowSize)
    {
        $mask = Matrix::initializeArray($windowSize, $windowSize, 1 / pow($windowSize, 2));


        $a_k = Matrix::sqrt(Matrix::sqrt(
            Matrix::max(
                Matrix::subtractMatrices(
                    Matrix::multiply(
                        Matrix::power(
                            Convolution::convolution2D(
                                Matrix::power($input, 2),
                                $mask
                            ),
                            2
                        ),
                        2
                    ),
                    Convolution::convolution2D(Matrix::power($input, 4), $mask)
                )
                , 0)
        ));


        $sigma_k2 = Matrix::multiply(
            Matrix::max(
                Matrix::subtractMatrices(
                    Convolution::convolution2D(
                        Matrix::power($input, 2),
                        $mask
                    ),
                    Matrix::power($a_k, 2)
                )
                , 0.01),
            0.5
        );



        for($i=0;$i<$N;$i++) {

            $a_k = Matrix::max(
                Convolution::convolution2D(
                    Matrix::multiplyMatrices(
                        $this->besseliApproximation(
                            Matrix::divideMatrices(
                                Matrix::multiplyMatrices($a_k,$input),
                                $sigma_k2
                            )
                    ),$input)
                    ,$mask
                )
                ,0
            );

            $sigma_k2 = Matrix::max(
                Matrix::subtractMatrices(
                    Matrix::multiply(
                        Convolution::convolution2D(
                            Matrix::power(Matrix::abs($input),2),
                            $mask
                        )
                    ,0.5)
                    ,
                    Matrix::divide(
                        Matrix::power($a_k,2),
                        2
                    )
                ),
                0.01
            );

        }


        return array('signal' => $a_k, 'sigma_n' => Matrix::sqrt($sigma_k2));
    }

    public function besseliApproximation($z) {
        $size = count($z);

        $z8 = Matrix::multiply($z, 8);



            $Mn1 =
            Matrix::subtractMatrices(
                Matrix::initializeArray($size, $size, 1),
                Matrix::divideMatrices(
                    Matrix::initializeArray($size, $size, 3),
                    $z8
                )
            );



        $Mn2 = Matrix::divideMatrices(
            Matrix::initializeArray($size,$size,7.5),
            Matrix::power($z8,2)
        );




        $Mn3 = Matrix::divideMatrices(
            Matrix::initializeArray($size, $size, 52.5),
            Matrix::power($z8, 3)
        );

        $Mn = Matrix::subtractMatrices(Matrix::subtractMatrices($Mn1, $Mn2), $Mn3);



        $Md1 = Matrix::divideMatrices(Matrix::initializeArray($size,$size,1),$z8);

        $Md2 = Matrix::divideMatrices(
            Matrix::initializeArray($size,$size,4.5),
            Matrix::power($z8, 2)
        );

        $Md3 = Matrix::divideMatrices(
            Matrix::initializeArray($size,$size,37.5),
            Matrix::power($z8, 3)
        );

        $Md = Matrix::addMatrices(
            Matrix::initializeArray($size,$size,1),
            Matrix::addMatrices(
                $Md1,
                Matrix::addMatrices($Md2, $Md3)
            )
        );

        $M = Matrix::divideMatrices($Mn, $Md);


        for($i=0;$i<$size;$i++) {
            for($j=0;$j<$size;$j++) {
                if($z[$i][$j] < 1.5) {
                    $M[$i][$j] = Bessel::besseli1($z[$i][$j])/Bessel::besseli0($z[$i][$j]);
                }
            }
        }

        for($i=0;$i<$size;$i++) {
            for($j=0;$j<$size;$j++) {
                if($z[$i][$j] == 0) {
                    $M[$i][$j] = 0;
                }
            }
        }

        return $M;
    }
}
