<?php

  include('Config/db_connect.php');
  session_start();

  if(empty($_SESSION)){
    header('Location: Login.php');
  }

  include('Config/logout.php');
  
  include('Config/session.php');

  

  


  // if(isset($_GET['submit'])){ // jadi ini cara bacanya itu, jika ada aktivitas dari key submit ini (atau mungkin gampangnya ada yang klik tombol submit di page html) maka kita akan ngejalanin code yg ada di dalem if

  //   echo $_GET['email'];
  //   echo $_GET['title'];
  //   echo $_GET['ingredients'];

  
  // // $_GET ini adalah global assosiative array, jadi data yang kita kirim dari web page saat submit form akan masuk ke assosiative array ini. Jadi jangan kek merasa $_GET ini tuh semacam function yang rumit. itu cmn kek assosiative array biasa yang buat nampung item2 dari form yang kita isi di halaman html

  // // bahkan untuk yang sekedar tombol submit, dia juga mengirim sebuah value ke assosiative array $_GET ini, dan kita bisa pakai valuenya
  // }


  // if(isset($_POST['submit'])){
  //     echo $_POST['email']; 
  //     echo $_POST['title'];
  //     echo $_POST['ingredients'];


  //     // Jadi apa yang dilakuan GET sama seperti POST cmn bedanya hasil dari inputan ngak di tunjukin di URL
  // }

//   if(isset($_POST['submit'])){
//     echo htmlspecialchars($_POST['email']); 
//     echo htmlspecialchars($_POST['title']);
//     echo htmlspecialchars($_POST['ingredients']);


//     // Jadi apa yang dilakukan sama htmlspecialchars, mereka mengubah script dari html/javascript yang dapat mengubah process dari html aslinya. Contohnya kita masukin inputan berupa line code dari java script yang bisa nge direct kita ke website lain. java script kan make bentukan <script> kode <script>, nah function ini akan ngedetect open tage dan closing tagnya sehingga nanti saat kita masukin kode java script dia cmn bakal berubah jadi semacam tulisan biasa yang tidak akan mengubah jalan code
// }

// FORM VALIDATION

$name = $anime = $waifutype = $image = ''; //inisialisasi disini tuh gunanya untuk menghindari error yg panjang gitu waktu website pertama kali dibuka dan nge load value di input box nya yg dimana isi valuenya itu ya 3 variable ini.

// Nah di inisialisasi ini, di juga berlaku sebagai reset-er, jadi saat kita submit lagi data yang baru, nanti sis variable2 nya bakal kosong lagi sehingga nanti itu nge bantu saat inputan udh gaada yang error berarti ya harusnya array $errrors itu kosong

// 


$errors = array('name'=>'','anime'=>'','waifutype'=>'','image'=>'');

  if(isset($_POST['submit'])){
    // echo htmlspecialchars($_POST['email']); 
    // echo htmlspecialchars($_POST['title']);
    // echo htmlspecialchars($_POST['ingredients']);

    

     //check name
     if(empty($_POST['name'])){
      $errors['name'] = 'a name is required <br>';
    }else{
      // echo htmlspecialchars($_POST['title']);
      $name = $_POST['name'];
      
      if(!preg_match('/^[a-zA-Z\s]+$/', $name)){ // argumen yg pertama itu regex, nanti bisa coba liat di playlist yg udh di save
        $errors['name'] = 'name must be letters and spaces only';

      }
    }

     //check anime
     if(empty($_POST['anime'])){
      $errors['anime'] = "please input the anime title <br>";
    }else{
      $anime = $_POST['anime'];
    }


    if(empty($_POST['waifutype'])){
      $errors['waifutype'] = "please input the waifu type <br>";
    }else{
      $waifutype = $_POST['waifutype'];
      if($waifutype != "Kuudere" && $waifutype != "Dandere" && $waifutype != "Tsundere" && $waifutype != "Yandere"){
        $errors['waifutype'] = "only kuudere, dandere, tsundere, and yandere available <br>";
      }
    }

    

    //check image
    
    if(!array_filter($errors)){
      $target_dir = "img/";
      $target_file = $target_dir . basename($_FILES["image"]["name"]);
      $uploadOk = 1;
      $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
     
      
        // Check if image file is a actual image or fake image
  
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check !== false) {
      // echo "File is an image - " . $check["mime"] . ".";
      $uploadOk = 1;
    } else {
      $errors['image'] = "File is not an image.";
      $uploadOk = 0;
    }
  
  
  // Check if file already exists
  if (file_exists($target_file)) {
    $errors['image'] = "Sorry, file already exists.";
    $uploadOk = 0;
  }
  
  // // Check file size
  // if ($_FILES["image"]["size"] > 500000) {
  //   echo "Sorry, your file is too large.";
  //   $uploadOk = 0;
  // }
  
  // Allow certain file formats
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
    $errors['image'] = "Sorry, only JPG, JPEG, & PNG files are allowed.";
    $uploadOk = 0;
  }
  
  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
    $errors['image'] = "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
  } else {
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
      // echo "The file ". htmlspecialchars( basename( $_FILES["image"]["name"])). " has been uploaded.";
    } else {
      $errors['image'] = "Sorry, there was an error uploading your file.";
    }
  }
    }
    
    
    
    
    


    // if(array_filter($errors)){ // jadi function ini nge check apakah arraynya itu ada isinya ato empty (disini emptynya itu bisa berupa empty string yang kita gunain buat inisialisasi ama reset array $errors)
    //   echo "there are errors in the form";
    // }else{
    //   echo "Form is valid";
    // }

    if(!array_filter($errors)){ //gimana ni kondisi dibaca ? Jadi kalau kita mau ngecek suatu array itu kosong atau ngak, KALAU array_filter() ini kita negasi jadi kek !array_filter() dia bakal return 1 kalau arraynya kosong , tapi kalo ada isinya dia gabakal return apa2. klo ada return yang dibalikin makanya jalan kodingan di dalem if nya tapi kalo ga return apa2 ya ga jalan atuh kodingannya WKWKKWKW

    // jadi ya kurang lebih gitu sih gimana ni function kerja pas dikasi negasi, waktu dikasi negasi dia seakan2 jadi berubah fungsi, yang tadinya buat nge filter isi array yang sama sekrang jadi bisa buat check array kosong ato ngak.

    // Sedikit ralat, mungkni cara gampang bacanya, kalo setelah arraynya di filter malah jadi gada isi, baru dia jalanin kodingan dalem if nya
    
    
      //saving to database
      


      $name = mysqli_real_escape_string($conn, $_POST['name']);
      // echo "Test " . $name;
      $anime = mysqli_real_escape_string($conn, $_POST['anime']);
      $waifutype = mysqli_real_escape_string($conn, $_POST['waifutype']);
      $image = mysqli_real_escape_string($conn, $target_file);


      $insert_sql = "INSERT INTO waifu(WaifuName, AnimeTitle, WaifuType, imgpath) VALUES ('$name','$anime','$waifutype','$image')";
      
      //save to DB and check

      if(mysqli_query($conn, $insert_sql)){
        // success
        
        // select UserId & Select WaifuID
        $select_sql_User = "SELECT UserId FROM user WHERE UserEmail = '$email' AND UserPassword = '$password'";

        $result = mysqli_query($conn, $select_sql_User);

        $temp_user = mysqli_fetch_assoc($result);
        $User_Id = $temp_user['UserId'];

        // echo $temp_user['UserId'] . "<br>";


        $select_sql_Waifu = "SELECT WaifuId FROM waifu WHERE WaifuName = '$name' AND AnimeTitle = '$anime' AND WaifuType = '$waifutype' AND imgpath = '$image'";

        $result = mysqli_query($conn, $select_sql_Waifu);

        $temp_waifu = mysqli_fetch_assoc($result);

        $Waifu_Id = $temp_waifu['WaifuId'];


        $insert_sql = "INSERT INTO header(UserId, WaifuId) VALUES ('$User_Id','$Waifu_Id')";
        
        if(mysqli_query($conn, $insert_sql)){
          mysqli_free_result($result);

          header('Location: index.php');
        }
        // echo $temp_waifu['WaifuId'];

        
        // echo "success";
      }else{
        echo 'query error : ' . mysqli_error($conn);
      }

      //header('Location: index.php'); // ini buat redirect ke halam tertentu yang source filenya satu folder sama file ini
    
    }

}// end of POST check


?>


<!DOCTYPE html>
<html lang="en">
<?php include('templates/header.php'); ?>

  <section class="container grey-text">
    <h4 class="center"> Add Your Waifu </h4>
    
    <form class="white" action="add.php" method="POST" enctype="multipart/form-data">
      <label>Your waifu's name</label>
      <input type="text" name="name" id="" value="<?php echo htmlspecialchars($name) ?>">
      <div class="red-text">
        <?php echo $errors['name']; ?>
      </div>
      <label>Anime name</label>
      <input type="text" name="anime" id="" value="<?php echo htmlspecialchars($anime) ?>">
      <div class="red-text">
        <?php echo $errors['anime']; ?>
      </div>
      <label>Your Waifu's Type</label>
      <input type="text" name="waifutype" id="" value="<?php echo htmlspecialchars($waifutype) ?>">
      <div class="red-text">
        <?php echo $errors['waifutype']; ?>
      </div>

      <label>Upload Your Waifu's Image <br><br></label>
      <div class="red-text">
        <?php echo $errors['image']; ?>
      </div>
      <input type="file" name="image" id="image" required>
      
      <br>

      <div class="center">
        <input type="submit" value="submit" name="submit" class="btn brand z-depth-0">
      </div>
    </form>
  </section>


  <?php include('templates/footer.php'); ?>
</html>