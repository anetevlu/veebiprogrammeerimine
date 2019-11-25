<?php
    class Test{ //class sisu käib loogeliste sulgude vahele, faili nimi alati Nimi.class.phpjne
        //properties ehk muutujad ehk klassides = meetod
        //võivad olla privaatsed/avalikud
        private $secretNumber;//ütled kohe alguses ära kas avalik v mitte
        public $publicNumber;

        function __construct($sentValue){//tühik ja kaks alakriipsu
            $this->secretNumber = 10; //$this viitab sellele et selle klassi muutuja
            $this->publicNumber = $sentValue * $this->secretNumber;
            echo "Salajane: " .$this->secretNumber ." ja avalik:  " .$this->publicNumber;
        }//constructor lõppeb

        function __destruct(){//kui kogu töö klassiga lõpetatakse ss käivitatakse
            echo " Klass on valmis ja lõpetas";
        }//destructor lõppeb
//sisuliselt sarnane mis on $conn->prepare jnejne
        public function showValues(){
            echo "\n Salajane on " .$this->secretNumber;
            $this->tellSecret();
        }

        private function tellSecret(){
            echo "Näidisklass on peaaegu valmis!";
        }

    }//class lõppeb

