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

    public static function multiplyMatrices($matrix, $matrix2) {
        $rows = count($matrix);
        $columns = count($matrix[0]);

        for($i=0;$i<$rows;$i++) {

            for($j = 0; $j < $columns; $j++) {
                $matrix[$i][$j] *= $matrix2[$i][$j];
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

    public static function power($matrix, $number) {
        $rows = count($matrix);

        for($i=0;$i<$rows;$i++) {
            $columns = count($matrix[$i]);

            for($j = 0; $j < $columns; $j++) {
                $matrix[$i][$j] = pow($matrix[$i][$j],$number);
            }
        }

        return $matrix;
    }

    public static function round($matrix, $decimalPlaces) {
        $rows = count($matrix);

        for($i=0;$i<$rows;$i++) {
            $columns = count($matrix[$i]);

            for($j = 0; $j < $columns; $j++) {
                $matrix[$i][$j] = round($matrix[$i][$j],$decimalPlaces);
            }
        }

        return $matrix;
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

    public static function sqrt($matrix) {
        $rows = count($matrix);

        for($i=0;$i<$rows;$i++) {
            $columns = count($matrix[$i]);

            for($j = 0; $j < $columns; $j++) {
                $matrix[$i][$j] = sqrt($matrix[$i][$j]);
            }
        }

        return $matrix;
    }

    public static function max($matrix, $number) {
        $rows = count($matrix);

        for($i=0;$i<$rows;$i++) {
            $columns = count($matrix[$i]);

            for($j = 0; $j < $columns; $j++) {
                if($matrix[$i][$j] < $number) {
                    $matrix[$i][$j] = $number;
                }
            }
        }

        return $matrix;
    }

    public static function subtractMatrices($a1, $a2) {
        $rowsA1 = count($a1);
        $rowsA2 = count($a2);

        if($rowsA1 !== $rowsA2) {
            throw new Exception('Number of rows must match');
        }


        for($i=0;$i<$rowsA1;$i++) {
            $columnsA1 = count($a1[$i]);
            $columnsA2 = count($a2[$i]);

            if($columnsA1 != $columnsA2) {
                throw new Exception('Number of columns must match');
            }

            for($j = 0; $j < $columnsA1; $j++) {
                $a1[$i][$j] = $a1[$i][$j]-$a2[$i][$j];
            }
        }

        return $a1;
    }

    public static function addMatrices($a1, $a2) {
        $rowsA1 = count($a1);
        $rowsA2 = count($a2);

        if($rowsA1 !== $rowsA2) {
            throw new Exception('Number of rows must match');
        }


        for($i=0;$i<$rowsA1;$i++) {
            $columnsA1 = count($a1[$i]);
            $columnsA2 = count($a2[$i]);

            if($columnsA1 != $columnsA2) {
                throw new Exception('Number of columns must match');
            }

            for($j = 0; $j < $columnsA1; $j++) {
                $a1[$i][$j] = $a1[$i][$j]+$a2[$i][$j];
            }
        }

        return $a1;
    }
}