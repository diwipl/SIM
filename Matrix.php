<?php
/**
 * Created by PhpStorm.
 * User: diwi
 * Date: 07.06.2015
 * Time: 17:32
 */
class Matrix {
    public static function compare($m1, $m2, $precision=4) {
        if(count($m1) != count($m2)) {
            return false;
        }

        $size = count($m1);

        for($i=0;$i<$size;$i++) {
            for($j=0;$j<$size;$j++) {
                if($m1[$i][$j] == INF OR $m1[$i][$j] == -INF OR $m2[$i][$j] == INF OR $m2[$i][$j] == -INF )
                {
                    if($m1[$i][$j] != $m2[$i][$j]) {
                        echo 'Wiersz: '.$i.PHP_EOL;
                        echo 'Kolumna: '.$j.PHP_EOL;
                        echo 'Pierwsza wartość: '.$m1[$i][$j].PHP_EOL;
                        echo 'Druga wartość: '.$m2[$i][$j].PHP_EOL;
                        return false;
                    }
                }
                else {
                    if(round($m1[$i][$j],$precision) != round($m2[$i][$j],$precision)) {
                        echo 'Wiersz: '.$i.PHP_EOL;
                        echo 'Kolumna: '.$j.PHP_EOL;
                        echo 'Pierwsza wartość: '.round($m1[$i][$j],$precision).PHP_EOL;
                        echo 'Druga wartość: '.round($m2[$i][$j],$precision).PHP_EOL;
                        return false;
                    }
                }
            }
        }

        return true;
    }

    public static function maxError($m1, $m2) {
        $size = count($m1);

        $max = $x = $y = 0;

        for($i=0;$i<$size;$i++) {
            for($j=0;$j<$size;$j++) {
                $difference = abs($m1[$i][$j]-$m2[$i][$j]);
                if($difference > $max) {
                    $max = $difference;
                    $x = $i;
                    $y = $j;
                }
            }
        }

        return [
            'max' => $max,
            'x' => $x,
            'y' => $y
        ];
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

    public static function abs($matrix) {
        $rows = count($matrix);

        for($i=0;$i<$rows;$i++) {
            $columns = count($matrix[$i]);

            for($j = 0; $j < $columns; $j++) {
                $matrix[$i][$j] = abs($matrix[$i][$j]);
            }
        }

        return $matrix;
    }

    public static function exp($matrix) {
        $rows = count($matrix);

        for($i=0;$i<$rows;$i++) {
            $columns = count($matrix[$i]);

            for($j = 0; $j < $columns; $j++) {
                $matrix[$i][$j] = exp($matrix[$i][$j]);
            }
        }

        return $matrix;
    }

    public static function log($matrix) {
        $rows = count($matrix);

        for($i=0;$i<$rows;$i++) {
            $columns = count($matrix[$i]);

            for($j = 0; $j < $columns; $j++) {
                $matrix[$i][$j] = log($matrix[$i][$j]);
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

    public static function divideMatrices($a1, $a2) {
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
                if($a2[$i][$j] != 0) {
                    $a1[$i][$j] = $a1[$i][$j]/$a2[$i][$j];
                }
                else if($a2[$i][$j] == 0) {
                    if($a1[$i][$j] > 0) {
                        $a1[$i][$j] = INF;
                    } else {
                        $a1[$i][$j] = -INF;
                    }
                }
            }
        }

        return $a1;
    }

    public static function multiplyMatrices($a1, $a2) {
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
                $a1[$i][$j] = $a1[$i][$j]*$a2[$i][$j];
            }
        }

        return $a1;
    }

    public static function multiplyComplexMatrixByRealMatrix($a1, $a2) {
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
                $a1[$i][$j] = Complex::Cmul($a1[$i][$j], new Complex($a2[$i][$j], 0));
            }
        }

        return $a1;
    }


    public static function getColumn($array, $idx) {
        $column = array();
        for ($i = 0; $i < count($array); $i++) {
            $column[$i] = $array[$i][$idx];
        }
        return $column;
    }

    public static function setColumn($array, $idx, $column) {
        for ($i = 0; $i < count($array); $i++) {
            $array[$i][$idx] = $column[$i];
        }
        return $array;
    }

    public static function transpose($data) {
        array_unshift($data, null);
        return call_user_func_array('array_map', $data);
    }
}