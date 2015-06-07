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
        $kernelWidth = count($kernel);

        $input = self::expandInput($input, floor($kernelWidth/2));

        $kernel = self::flipKernel($kernel);

        $width = $height = count($input);

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

    public static function expandInput($input,$number=1) {
        $size = count($input);


        $output = array();

        $firstRow = array();

        for($i =0; $i<$number;$i++) {
            $firstRow[$i] = $input[0][0];
        }

        for($i=0;$i<$size;$i++) {
            $firstRow[$i+$number] = $input[0][$i];
        }

        for($i=0;$i<$number;$i++) {
            $firstRow[$size+$number+$i] = $input[0][$size-1];
        }

        for($i =0; $i<$number;$i++) {
            $output[$i] = $firstRow;
        }


        for($i=0;$i<$size;$i++) {
            $output[$i+$number] = array_merge(array_fill(0,$number,$input[$i][0]), array_merge($input[$i],array_fill(0,$number,$input[$i][$size-1])));
        }

        for($i =0; $i<$number;$i++) {
            $lastRow[$i] = $input[$size-1][0];
        }

        for($i=0;$i<$size;$i++) {
            $lastRow[$i+$number] = $input[$size-1][$i];
        }

        for($i=0;$i<$number;$i++) {
            $lastRow[$size+$number+$i] = $input[$size-1][$size-1];
        }

        for($i =0; $i<$number;$i++) {
            $output[$size+$number+$i] = $lastRow;
        }


        return $output;
    }


}
