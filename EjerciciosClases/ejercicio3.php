<?php
class CuentaBancaria{
    private $saldo = 1000;


    public function comprobarSaldo(){
        echo "Tienes :" . $this->saldo . "euros, tieso";
    }
    public function depositar($cantidad){
        $this->saldo += $cantidad;
        $this->comprobarSaldo();
    }

    public function retirar($cantidad){
        if ($this->saldo - $cantidad < 0) {
            echo "NO PUEDES RETIRAR MAS DE LO QUE TIENES MELON TIENES " .  $this->saldo . "euros";
        }else{
            $this->saldo -= $cantidad;
        }

        $this->comprobarSaldo();
    }
}

$miCuenta = new CuentaBancaria();
$miCuenta->depositar(1000);
echo PHP_EOL;
$miCuenta->retirar(3000);