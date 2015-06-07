<?php
/**
 * Created by PhpStorm.
 * User: diwi
 * Date: 07.06.2015
 * Time: 17:32
 */
class Matrix {
    public static function compare($m1, $m2) {
        if(count($m1) != count($m2)) {
            return false;
        }

        $size = count($m1);

        for($i=0;$i<$size;$i++) {
            for($j=0;$j<$size;$j++) {
                if(round($m1,4) != round($m2,4)) {
                    return false;
                }
            }
        }

        return true;
    }

    public static function add($matrix, $number) {
        $rows = count($matrix);

        for($i=0;$i<$rows;$i++) {
            $columns = count($matrix[$i]);

            for($j = 0; $j < $columns; $j++) {
                $matrix[$i][$j] = $matrix[$i][$j]+$number;
            }
        }

        return $matrix;
    }

    public static function subtract($matrix, $number) {
        $rows = count($matrix);

        for($i=0;$i<$rows;$i++) {
            $columns = count($matrix[$i]);

            for($j = 0; $j < $columns; $j++) {
                $matrix[$i][$j] = $matrix[$i][$j]-$number;
            }
        }

        return $matrix;
    }

    public static function multiply($matrix, $number) {
        $rows = count($matrix);

        for($i=0;$i<$rows;$i++) {
            $columns = count($matrix[$i]);

            for($j = 0; $j < $columns; $j++) {
                $matrix[$i][$j] = $matrix[$i][$j]*$number;
            }
        }

        return $matrix;
    }

    public static function divide($matrix, $number) {
        $rows = count($matrix);

        for($i=0;$i<$rows;$i++) {
            $columns = count($matrix[$i]);

            for($j = 0; $j < $columns; $j++) {
                $matrix[$i][$j] = $matrix[$i][$j]/$number;
            }
        }

        return $matrix;
    }
}