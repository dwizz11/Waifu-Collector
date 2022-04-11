<?php

  include('Config/db_connect.php');
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

$username = $email = $password = $confirmpassword = ''; //inisialisasi disini tuh gunanya untuk menghindari error yg panjang gitu waktu website pertama kali dibuka dan nge load value di input box nya yg dimana isi valuenya itu ya 3 variable ini.

// Nah di inisialisasi ini, di juga berlaku sebagai reset-er, jadi saat kita submit lagi data yang baru, nanti sis variable2 nya bakal kosong lagi sehingga nanti itu nge bantu saat inputan udh gaada yang error berarti ya harusnya array $errrors itu kosong

// 


$errors = array('username'=>'','email'=>'','password'=>'','confirmpassword'=>'');

  if(isset($_POST['submit'])){
    // echo htmlspecialchars($_POST['email']); 
    // echo htmlspecialchars($_POST['title']);
    // echo htmlspecialchars($_POST['ingredients']);

    

     //check name
     if(empty($_POST['username'])){
      $errors['username'] = 'a username is required <br>';
    }else{
      // echo htmlspecialchars($_POST['title']);
      $username = $_POST['username'];
      
      if(!preg_match('/^[a-zA-Z\s]+$/', $username)){ // argumen yg pertama itu regex, nanti bisa coba liat di playlist yg udh di save
        $errors['username'] = 'userame must be letters and spaces only <br>';

      }
    }


    //check email
    if(empty($_POST['email'])){
      $errors['email'] = 'an email is required <br>';
    }else{
      // echo htmlspecialchars($_POST['email']); 
      $email = $_POST['email'];
      if(!filter_var($email, FILTER_VALIDATE_EMAIL)){ // jadi ya ini semacam function buat nge check apakah inputannya itu email ato bukan. Dan ini emg udh built in di php jadi kalem aja bisa langsung pake
        $errors['email'] = 'email must be a valid email address <br>';
      }else if(filter_var($email, FILTER_VALIDATE_EMAIL)){
        $sql = "SELECT UserEmail FROM user WHERE UserEmail = '$email'";

        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) > 0){
          $errors['email'] = 'email already exist <br>';
        }
      }
    }

    //check Password
    if(empty($_POST['password'])){
      $errors['password'] = 'a password is required <br>';
    }else{
      // echo htmlspecialchars($_POST['title']);
      $password = $_POST['password'];
      
      if(strlen($password) < 8){ // argumen yg pertama itu regex, nanti bisa coba liat di playlist yg udh di save
        $errors['password'] = 'password minimal consist of 8 characters <br>';

      }
    }

    //Confirm Password
    if(empty($_POST['confirmpassword'])){
      $errors['confirmpassword'] = 'you need to confirm password <br>';
    }else{
      // echo htmlspecialchars($_POST['title']);
      $confirmpassword = $_POST['confirmpassword'];
      
      if($password !== $confirmpassword){ // argumen yg pertama itu regex, nanti bisa coba liat di playlist yg udh di save
        $errors['confirmpassword'] = 'password not matched';

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
      


      $username = mysqli_real_escape_string($conn, $_POST['username']);
      $email = mysqli_real_escape_string($conn, $_POST['email']);
      $password = mysqli_real_escape_string($conn, $_POST['password']);


      $insert_sql = "INSERT INTO user(UserName, UserPassword, UserEmail) VALUES ('$username','$password','$email')";
      
      //save to DB and check

      if(mysqli_query($conn, $insert_sql)){
        // success
        header('Location: Login.php');
      }else{
        echo 'query error : ' . mysqli_error($conn);
      }

      //header('Location: Login.php'); // ini buat redirect ke halam tertentu yang source filenya satu folder sama file ini
    
    }

}// end of POST check

if(isset($_POST['btl'])){
  header('Location: Login.php');
}


?>


<!DOCTYPE html>
<html lang="en">
<?php include('templates/headerGuest.php'); ?>

  <section class="container grey-text">
    <h4 class="center"> Register </h4>
    
    <form class="white" action="Register.php" method="POST" >
      <label>Username</label>
      <input type="text" name="username" id="" value="<?php echo htmlspecialchars($username) ?>">
      <div class="red-text">
        <?php echo $errors['username']; ?>
      </div>
      <label>Email</label>
      <input type="text" name="email" id="" value="<?php echo htmlspecialchars($email) ?>">
      <div class="red-text">
        <?php echo $errors['email']; ?>
      </div>
      <label>Password</label>
      <input type="password" name="password" id="" value="<?php echo htmlspecialchars($password) ?>">
      <div class="red-text">
        <?php echo $errors['password']; ?>
      </div>

      <label>Confirm Password</label>
      <input type="password" name="confirmpassword" id="" value="<?php echo htmlspecialchars($confirmpassword) ?>">
      <div class="red-text">
        <?php echo $errors['confirmpassword']; ?>
      </div>
     
      
      <br>

      <div class="center">
        <input type="submit" value="submit" name="submit" class="btn brand z-depth-0">
        <input type="submit" value="Back to Login" name="btl" class="btn brand z-depth-0">
      </div>
    </form>
  </section>


  <?php include('templates/footerGuest.php'); ?>
</html>