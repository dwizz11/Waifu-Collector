<?php 

include('Config/db_connect.php'); // nanti ini kita bakal pake buat ambil details dari database
session_start();
include('Config/logout.php');
include('Config/session.php');

if(isset($_POST['delete'])){// ini buat nagkep aksi kalau submit buttonnya di klik

  $idtoDelete = mysqli_real_escape_string($conn, $_POST['id_to_delete']); // ini buat nerima value berupa id yang mau di delete. Kita kan soalnya udh dapet data2 dari database di isset yang dibawah, makanya kita bisa punya Id dari pizzanya.

  // $alter_sql = "ALTER TABLE header DROP FOREIGN KEY WaifuId";

  // if(mysqli_query($conn, $alter_sql)){
  //   // success
  //   // header('Location: index.php');
  // }else{
  //   echo 'query error : ' . mysqli_error($conn);

  // }

  // $alter_sql = "ALTER TABLE header DROP FOREIGN KEY UserId";

  // if(mysqli_query($conn, $delete_sql)){
  //   // success
  //   // header('Location: index.php');
  // }else{
  //   echo 'query error : ' . mysqli_error($conn);

  // }

  $delete_sql = "DELETE FROM header WHERE WaifuId = $idtoDelete";
  // $delete_sql2 = "DELETE FROM header WHERE WaifuId = $idtoDelete";

  //klo untuk yg manipulasi data, kita gaperlu pake "result" karena kita ga berusaha nerima data apa2. Jadi cukup mysqli_query aja

  if(mysqli_query($conn, $delete_sql)){

    $delete_sql = "DELETE FROM waifu WHERE WaifuId = $idtoDelete";

    if(mysqli_query($conn,$delete_sql)){
      header('Location: index.php');
    }else{
      echo 'query error : ' . mysqli_error($conn);
    }
    // success
    // $alter_sql = "ALTER TABLE header ADD CONSTRAINT UserId FOREIGN KEY (UserId) REFERENCES user";

    // if(mysqli_query($conn, $alter_sql)){
    //   // success
    //   echo "Alter Table success";
    //   // header('Location: index.php');
    // }else{
    //   echo 'query error : ' . mysqli_error($conn);
  
    // }

    // $alter_sql = "ALTER TABLE header ADD CONSTRAINT WaifuId FOREIGN KEY (WaifuId) REFERENCES waifu";

    // if(mysqli_query($conn, $alter_sql)){
    //   echo "Alter Table success";
    //   // success
    //   // header('Location: index.php');
    // }else{
    //   echo 'query error : ' . mysqli_error($conn);
  
    // }


    
  }else{
    echo 'query error : ' . mysqli_error($conn);

  }

  mysqli_close($conn);

}

//check GET request 'id' parameter
if(isset($_GET['id'])){// jangan lupa, nama key yg ada di dalem bracket harus sesuai yang ama di url. jadi kek misalnya ...?id=2 berarti ya nulisnya $_GET['id']. 'i' nya kecil jan kapital, case sensitive soalnya

  $id = mysqli_real_escape_string($conn, $_GET['id']);

  //make sql
  $select_sql = "SELECT * FROM waifu WHERE WaifuId = $id";

  //get query result

  $result = mysqli_query($conn, $select_sql);

  //fetch result

  $waifu_details = mysqli_fetch_assoc($result); //ini buat nyimpen hasil query ke array

  mysqli_free_result($result);

  mysqli_close($conn);


  // print_r($pizza_details);

}

  


?>

<!DOCTYPE html>
<html lang="en">
   <?php include('templates/header.php'); ?>

      <div class="container center grey-text">
      <?php if($waifu_details): // cara cek array kek gini itu cocok kalo array yang kita check cmn punya 2 opsi, kosong semua ato ada isinya semua ?>
        <img src="<?php echo htmlspecialchars($waifu_details['imgpath']); ?>" class="waifu_image">
          <h4><?php echo htmlspecialchars($waifu_details['WaifuName']); ?></h4>
          <p><?php echo $waifu_details['AnimeTitle']; ?></p>
          <p>Type : <?php echo htmlspecialchars($waifu_details['WaifuType']); ?></p>
         

          <!-- Delete Form -->
          <!-- action itu gunanya untuk pilih mana file yang akan dijalanin saat formnya di subumit -->
          <!-- Method tu untuk nentuin gimana caranya kita mengirim sebuah data di website, klo POST berarti hidden klo GET ya keliatan data yg lagi dikirm, di URL nya -->
          <form action="details.php" method="post">
            <input type="hidden" name="id_to_delete" value="<?php echo $waifu_details['WaifuId']; ?>">
            <!-- Jadi disini untuk bisa ngelakuin delete data dari php, kita butuh namanya hidden form sehingga kita bisa tau mana id pizza yang harus di delete. -->
            <input type="submit" name ="delete" value="Delete" class="btn brand z-depth-0">
          </form>

      <?php else: ?>
        <h5>There are no such waifu exist</h5>
      <?php endif; ?>  


      </div>


    <?php include('templates/footer.php'); ?>
</html>