<?php
class RiceHomomorfEstimation {

    static $eulerGamma = 0.5772156649015328606;

    public $m1;
    public $m2;
    public $sigma_n;
    public $snr;
    public $psi1 = -0.57721566490153;

    public $Rn;
    public $lRn;

    public $lpf2;
    public $mapa2;
    public $mapag;
    public $localMean;
    public $fc1;
    public $lpf1;
    public $mapa1;
    public $mapar;

public $lpf1Sub;

    public function estimate($input,$snr=0,$lpf=4.8,$mode=2) {
        $readyLpf = true;

        $size = count($input);

        $em = new ExpectationMaximization();

        $result = $em->createMask($input,10,5);

        $this->m2 = $result['signal'];
        $this->sigma_n = $result['sigma_n'];

        $this->m1 = Convolution::convolution2D($input, Matrix::initializeArray(5,5,0.04));

        if($snr == 0) {
            $snr = $this->snr = Matrix::divideMatrices($this->m2,$this->sigma_n);
        }

        $this->Rn = Matrix::abs(Matrix::subtractMatrices($input,$this->m1));

        $this->lRn = $this->logRn($this->Rn);

        if($readyLpf) {
            $this->lpf2 = LPF::calc($this->lRn,$lpf);
        } else {
            $this->lpf2 = Csv::loadFileToArray('lpf2.csv');
        }

        echo 'Po lowpass1'.PHP_EOL;


        $this->mapa2 = Matrix::exp($this->lpf2);
        $this->mapag = $this->buildMap($this->mapa2);

        if($mode == 1) {
            $this->localMean = $this->m1;
        } else if($mode == 2) {
            $this->localMean = $this->m2;
        } else {
            $this->localMean = Matrix::initializeArray($size,$size,0);
        }


        $this->Rn = Matrix::abs(Matrix::subtractMatrices($input,$this->localMean));
        $this->lRn = $this->logRn($this->Rn);

        if($readyLpf) {
            $this->lpf2 = LPF::calc($this->lRn,$lpf);
        } else {
            $this->lpf2 = Csv::loadFileToArray('lpf2.csv');
        }

        echo 'Po lowpass2'.PHP_EOL;

        $this->fc1 = CorrectRiceGauss::correct($snr);
        $this->lpf1Sub = Matrix::divideMatrices($this->lpf2,$this->fc1);

        if($readyLpf) {
            $this->lpf1 = LPF::calc($this->lpf1Sub, $lpf+2);
        } else {
            $this->lpf1 = Csv::loadFileToArray('lpf1_sub.csv');
        }

        echo 'Po lowpass3'.PHP_EOL;

        $this->mapa1 = Matrix::exp($this->lpf1);
        $this->mapar = $this->buildMap($this->mapa1);
    }

    private function logRn($rn) {
        $size = count($rn);

        for($i=0;$i<$size;$i++) {
            for($j=0;$j<$size;$j++) {
                if($rn[$i][$j] == 0) {
                    $rn[$i][$j] = 0.001;
                }
            }
        }

        return Matrix::log($rn);
    }

    private function buildMap($map) {
        $map = Matrix::multiply($map,2);
        $map = Matrix::divide($map, sqrt(2));

        $map = Matrix::multiply(
            $map,
            exp(-$this->psi1/2)
        );

        return $map;
    }

}
