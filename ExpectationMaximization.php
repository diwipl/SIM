<?php

class ExpectationMaximization {
    public function createMask($windowSize, $input) {
        $mask = Matrix::initializeArray($windowSize, $windowSize, 1/pow($windowSize,2));

        return Matrix::sqrt(Matrix::sqrt(
            Matrix::max(
               Matrix::subtractMatrices(
                   Matrix::multiply(
                       Matrix::power(
                           Convolution::convolution2D(
                               Matrix::power($input,2),
                               $mask
                           ),
                           2
                       ),
                       2
                   ),
                   Convolution::convolution2D(Matrix::power($input,4), $mask)
               )
            , 0)
        ));
    }
}
