<?php

class Convolution
{
    public static function singlePixelConvolution($input, $x, $y, $k)
    {
        $output = 0;
        $kernelSize = count($k);
        for ($i = 0; $i < $kernelSize; ++$i) {
            for ($j = 0; $j < $kernelSize; ++$j) {
                $output = $output + ($input[$x + $i][$y + $j] * $k[$i][$j]);
            }
        }
        return $output;
    }

    public static function convolution2D($input, $kernel)
    {
        $kernel = self::flipKernel($kernel);

        $width = $height = count($input);


        $kernelWidth = count($kernel);
        $smallWidth = $width-$kernelWidth+1;
        $smallHeight = $height-$kernelWidth+1;

        $output = self::initializeArray($smallWidth, $smallHeight);


        for ($i = 0; $i < $smallWidth; ++$i) {
            for ($j = 0; $j < $smallHeight; ++$j) {
                $output[$i][$j] = self::singlePixelConvolution($input, $i, $j, $kernel);
            }
        }
        return $output;
    }

    public static function initializeArray($width, $height, $value = 0)
    {
        $output = array();

        for ($i = 0; $i < $width; $i++) {
            $output[$i] = array();

            for ($j = 0; $j < $height; $j++) {
                $output[$i][$j] = $value;
            }
        }

        return $output;
    }

    public static function flipKernel($kernel)
    {
        $kernel = array_reverse($kernel);

        foreach ($kernel as $key => $row) {
            $kernel[$key] = array_reverse($kernel[$key]);
        }

        return $kernel;
    }

    public static function expandInput($input) {
        $size = count($input);

        $output = array();

        $firstLastRow = array();
        for($i = 0; $i<$size+2; $i++) {
            $firstLastRow[$i] = 0;
        }

        $output[0] = $firstLastRow;

        for($i=0;$i<$size;$i++) {
            $output[$i+1] = array_merge([0], array_merge($input[$i],[0]));
        }

        $output[$size+2] = $firstLastRow;

        return $output;
    }
}
