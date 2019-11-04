<?php
    class PicUpload {
        private $tempName; //kui ei tea kas private v public muutuja ss alati private
        private $imageFileType;
        private $myTempImage;
        private $myNewImage;

        function __construct($tempName, $imageFileType){
            $this->tempName = $tempName;
            $this->imageFileType = $imageFileType;
            $this->createImageFromFile();
        }//constructor lõppeb

        function __destruct(){
            imagedestroy($this->myTempImage);
            imagedestroy($this->myNewImage);
        }

        private function createImageFromFile(){
            if($this->imageFileType == "jpg" or $this->imageFileType == "jpeg"){
                $this->myTempImage = imagecreatefromjpeg($this->tempName);
            }
            if($this->imageFileType == "png"){
                $this->myTempImage = imagecreatefrompng($this->tempName);
            }
            if($this->imageFileType == "gif"){
                $this->myTempImage = imagecreatefromgif($this->tempName);
            }
        }//createImageFromFile lõppeb

        public function resizeImage($picMaxW, $picMaxH){ //public sellep et vaja välja kutsuda mujal äkki
            //pildi originaalmõõt
            $imageW = imagesx($this->myTempImage);
            $imageH = imagesy($this->myTempImage);
            //kui on liiga suur
            if($imageW > $picMaxW or $imageH > $picMaxH){ //muutujaid picmaxw ja picmaxh saad ju saata siia klassi põhiprogrammist
                //muudamegi suurust
                if($imageW / $picMaxW > $imageH / $picMaxH){
                    $picSizeRatio = $imageW / $picMaxW;
                } else {
                    $picSizeRatio = $imageH / $picMaxH;
                }
                //loome uue "pildiobjekti" juba uute mõõtudega
                $newW = round($imageW / $picSizeRatio, 0);
                $newH = round($imageH / $picSizeRatio, 0);
                $this->myNewImage = $this->setPicSize($this->myTempImage, $imageW, $imageH, $newW, $newH);
                
            }//kui liiga suur lõppeb

        }//resize image lõpp

        private function setPicSize($myTempImage, $imageW, $imageH, $newW, $newH){
            $newImage = imagecreatetruecolor($newW, $newH);
            imagecopyresampled($newImage, $myTempImage, 0, 0, 0, 0, $newW, $newH, $imageW, $imageH);
            return $newImage;//newImage läheb tänu returnile this->mynewimageks
        }//pildi suuruse lõpp

        public function addWatermark($waterMark){
            $waterMark = imagecreatefrompng($waterMarkFile);
            $waterMarkW = imagesx($waterMark);
            $waterMarkH = imagesy($waterMark);
            $waterMarkX = imagesx($this->myNewImage) - $waterMarkW - 10;
            $waterMarkY = imagesx($this->myNewImage) - $waterMarkH - 10;
            //kopeerin vesimärgi pikslid pildile; mis pildile ja mida copyd sinna, x kordinaat ja y kordinaat, kus kohast alustan ja lõpetan
            imagecopy($this->myNewImage, $waterMark, $waterMarkX, $waterMarkY, 0, 0, $waterMarkW, $waterMarkH);
            imagedestroy($waterMark);
        }

        public function saveImage($targetFile){
            $notice = null;
            //salvestan vähendatud pildi faili
            if($this->imageFileType == "jpg" or $this->imageFileType == "jpeg"){
                if(imagejpeg($this->myNewImage, $targetFile, 90)){
                    $notice = "Vähendatud pildi salvestamine õnnestus! ";
                } else {
                    $notice = "Vähendatud pildi salvestamine ebaõnnestus! ";
                }
            }
            if($this->imageFileType == "png"){
                if(imagepng($this->myNewImage, $targetFile, 6)){
                    $notice = "Vähendatud pildi salvestamine õnnestus! ";
                } else {
                    $notice = "Vähendatud pildi salvestamine ebaõnnestus! ";
                }
            }
            if($this->imageFileType == "gif"){
                if(imagegif($this->myNewImage, $targetFile)){
                    $notice = "Vähendatud pildi salvestamine õnnestus! ";
                } else {
                    $notice = "Vähendatud pildi salvestamine ebaõnnestus! ";
                }
            }
            return $notice;//notice ei ole klassi funktsioon, teda korra lihtsalt vaja 
        }//saveimage lõpp
        
    }//class lõppeb
//kui failis ainult php siis pole lõppu vaja sisuliselt?>