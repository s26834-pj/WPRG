<?php

class NoweAuto {
    protected $model;
    protected $cenaEuro;
    protected $kursEuroPLN;

    public function __construct($model, $cenaEuro, $kursEuroPLN) {
        $this->model = $model;
        $this->cenaEuro = $cenaEuro;
        $this->kursEuroPLN = $kursEuroPLN;
    }

    public function obliczCene() {
        return $this->cenaEuro * $this->kursEuroPLN;
    }

    public function getModel() {
        return $this->model;
    }

    public function getCenaEuro() {
        return $this->cenaEuro;
    }

    public function getKursEuroPLN() {
        return $this->kursEuroPLN;
    }
}

class AutoZDodatkami extends NoweAuto {
    private $alarm;
    private $radio;
    private $klimatyzacja;

    public function __construct($model, $cenaEuro, $kursEuroPLN, $alarm, $radio, $klimatyzacja) {
        parent::__construct($model, $cenaEuro, $kursEuroPLN);
        $this->alarm = $alarm;
        $this->radio = $radio;
        $this->klimatyzacja = $klimatyzacja;
    }

    public function obliczCene() {
        $cenaBazowaPLN = parent::obliczCene();
        $cenaDodatkow = $this->alarm + $this->radio + $this->klimatyzacja;
        return $cenaBazowaPLN + $cenaDodatkow;
    }

    public function getAlarm() {
        return $this->alarm;
    }

    public function getRadio() {
        return $this->radio;
    }

    public function getKlimatyzacja() {
        return $this->klimatyzacja;
    }
}

class Ubezpieczenie extends AutoZDodatkami {
    private $procentUbezpieczenia;
    private $liczbaLat;

    public function __construct($model, $cenaEuro, $kursEuroPLN, $alarm, $radio, $klimatyzacja, $procentUbezpieczenia, $liczbaLat) {
        parent::__construct($model, $cenaEuro, $kursEuroPLN, $alarm, $radio, $klimatyzacja);
        $this->procentUbezpieczenia = $procentUbezpieczenia;
        $this->liczbaLat = $liczbaLat;
    }

    public function obliczCene() {
        $cenaAutaZDodatkami = parent::obliczCene();
        $wartoscUbezpieczenia = $this->procentUbezpieczenia * ($cenaAutaZDodatkami * ((100 - $this->liczbaLat) / 100));
        return $cenaAutaZDodatkami + $wartoscUbezpieczenia;
    }


    public function getProcentUbezpieczenia() {
        return $this->procentUbezpieczenia;
    }

    public function getLiczbaLat() {
        return $this->liczbaLat;
    }
}

$auto = new Ubezpieczenie("Volvo", 3000, 4.5, 500, 300, 1000, 0.05, 3);
$auto2 = new Ubezpieczenie("Vw", 320, 5, 50, 100, 3200, 0.05, 3);
echo "Model: " . $auto->getModel() . "\n";
echo "Cena w PLN: " . $auto->obliczCene() . " PLN\n";
echo "</br>";
echo "Model: " . $auto2->getModel() . "\n";
echo "Cena w PLN: " . $auto2->obliczCene() . " PLN\n";
?>