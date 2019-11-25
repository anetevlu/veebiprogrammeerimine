<?php
    require("../../../config_vp.php");
    require("functions_main.php");
    require("functions_user.php");
    require("functions_pic.php");
    require("Classes/PicUpload.class.php");
    //require("Classes/Test.class.php"); //võtan kasutusele oma klassi
    $dataBase = "if19_anete_vp";
  
    //kui pole sisseloginud
    if(!isset($_SESSION["userID"])){
        header("Location: page.php");
        exit();
    }
    
    //väljalogimine
    if(isset($_GET["logout"])){
        session_destroy();
        header("Location: page.php");
        exit();
    }
    $userName = $_SESSION["userFirstname"] ." " .$_SESSION["userLastname"];
    
    $notice = null;
    $fileNamePrefix = "vp_";
    $maxPicW = 600;
    $maxPicH = 400;
    $fileSizeLimit = 2500000;
    $waterMarkLocation = mt_rand(1,4); //1- ülal vasakul, 2 - ülal paremal, 3 - all paremal, 4 - all vasakul, 5 - keskel
    $waterMarkFromEdge = 10;
    $thumbW = 100;
    $thumbH = 100;
    $waterMarkFile = "../vp_pics/vp_logo_w100_overlay.png";
    
    //$uploadOk = 1;

    if(isset($_POST["submitPic"])){
        // Check if file already exists
                /*if (file_exists($target_file)) {
                    echo "Sorry, file already exists.";
                    $uploadOk = 0;
                }*/
                
                //kasutame klassi (saadame kogu info üleslaetava faili kohta ja faili mahu piiri
                $myPic = new PicUpload($_FILES["fileToUpload"], $fileSizeLimit);
                if($myPic->error == null){
                    //loome failinime
                    $myPic->createFileName($fileNamePrefix);
                    //teeme pildi väiksemaks
                    $myPic->resizeImage($maxPicW, $maxPicH);
                    //lisame vesimärgi
                    $myPic->addWatermark($waterMarkFile, $waterMarkLocation, $waterMarkFromEdge);
                    //kirjutame vähendatud pildi faili
                    $notice .= $myPic->savePicFile($pic_upload_dir_w600 .$myPic->fileName);
                    //thumbnail
                    $myPic->resizeImage($thumbW, $thumbH);
                    $myPic->savePicFile($pic_upload_dir_thumb .$myPic->fileName);
                    //salvestan originaali
                    $notice .= " " .$myPic->saveOriginal($pic_upload_dir_orig .$myPic->fileName);
                                
                    //salvestan info andmebaasi
                    $notice .= addPicData($myPic->fileName, test_input($_POST["altText"]), $_POST["privacy"]);
                } else {
                    //1 - pole pildifail, 2 - liiga suur, pole lubatud tüüp
                    if($myPic->error == 1){
                        $notice = "Üleslaadimiseks valitud fail pole pilt!";
                    }
                    if($myPic->error == 2){
                        $notice = "Üleslaadimiseks valitud fail on liiga suure failimahuga!";
                    }
                    if($myPic->error == 3){
                        $notice = "Üleslaadimiseks valitud fail pole lubatud tüüpi (lubatakse vaid jpg, png ja gif)!";
                    }
                }
                unset($myPic);
            }//kas nuppu klikiti
          
          //pic upload lõppeb
    //ehk type on java keel, saad asjad failist checkfilesize; defer-ei lase javal kohe käima minna vaid peale lehe täielikku laadimist
    $toScript = "\t" .'<script type="text/javascript" src="javascript/checkFileSize.js" defer></script>' ."\n";
    require("header.php");
?>

<html>
    <body>
    <?php
        echo "<h1>" .$userName ." koolitöö leht</h1>";
    ?>
    <p>See leht on loodud koolis õppetöö raames
    ja ei sisalda tõsiseltvõetavat sisu!</p>
    <hr>
    <p><a href="?logout=1">Logi välja</a> / Tagasi <a href="home.php">avalehele</a></p>
    <hr>
    
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
        <label>Vali üleslaetav pilt</label>
        <input type="file" name="fileToUpload" id="fileToUpload">
        <br>
        <label>Pildi kirjeldus: </label><input type="text" name="altText">
        <br>
        <label>Pildi privaatsus</label>
        <br>
        <label><input type="radio" name="privacy" value="1">Avalik</label>&nbsp;
        <label><input type="radio" name="privacy" value="2">Sisseloginud kasutajale</label>&nbsp;
        <label><input type="radio" name="privacy" value="3" checked>Privaatne</label>&nbsp;
        <input name="submitPic" type="submit" value="Lae pilt üles"><span><?php echo $notice; ?></span>
        </form>
        <hr>
</body>
</html>