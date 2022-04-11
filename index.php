<?php 

  include('Config/db_connect.php');
  session_start();

  if(empty($_SESSION)){
    header('Location: Login.php');
  }

  include('Config/logout.php');

  include('Config/session.php');


  //query untuk nama
  
 
  
  
  
  
  
  
  
  
  //Query untuk cards
  $sql_cards = "SELECT u.UserId AS 'id_user',w.WaifuName AS 'name',w.AnimeTitle AS 'anime',w.imgpath AS 'imgpath',w.WaifuId AS 'id_waifu' FROM waifu w JOIN header h ON w.WaifuId = h.WaifuId JOIN user u ON h.UserId = u.UserId WHERE u.UserEmail = '$email' AND u.UserPassword = '$password'";

  $result = mysqli_query($conn, $sql_cards); // (variable yang nampung database connection, querynya)

  //fetch the result rows as array

  $waifus = mysqli_fetch_all($result,MYSQLI_ASSOC); // ini nanti kek nge copas data yang kita dapet dari result ke assosiative array. Makanya nanti data yang ada di $result udh ga diperluin lagi makanya di next line kita clear datanya.

  mysqli_free_result($result); // jadi  yang kita lakuin disini basicly nge free memory yang dipake si variable $result buat nampung data dari database.

  mysqli_close($conn); // ya seperti namanya, ini nutup koneksi ke databse.

  //buat code di line 28 sama 30, itu cmn best practice dan ga wajib gitu. Ya mirip kek kita harus close file di C programming abis open file

  // print_r($pizzas);

  
  //print_r(explode(',', $pizzas[0]['Ingredients'])); //jadi fungsi ini cocok buat bikin array dari kalimat yang punya pemisah (pemisahnya harus konsisten jadi kek klo di case ini ya pemisahnya koma semua). Tbh ini cara language nya nge baca tuh mirip kek scanf di c tapi yang make [^,] ato yg semacemnya. Dan nanti outputnya itu bakal berupa array

  // print_r($waifus);
?>

<!DOCTYPE html>
<html>

  <!-- Disini kita bisa potong bagian dari html like bener2 random jadi bisa aja tag pembuka sama tah penutupnya itu beda file php -->
  <?php include('templates/header.php'); ?>

  <h4 class="center grey-text">Waifus!</h4>

  <div class="container">
    <div class="row">
      <?php foreach($waifus as $waifu): ?>
      
        <div class="col s6 md3">
          <div class="card z-depth-0">
            <img src="<?php echo htmlspecialchars($waifu['imgpath']); ?>" class="waifu_image">
            <div class="card-content center">
              <h6><?php echo htmlspecialchars($waifu['name']); ?></h6>
              <p><?php echo htmlspecialchars($waifu['anime']); ?></p>
            </div>

            <div class="card-action right-align">
              <a href="details.php?id=<?php echo $waifu['id_waifu'] ?>" class="brand-text">More Info</a>
              <!-- details.php?id=<?php //echo $waifu['id'] ?> -->
            </div>
          </div>
        </div>
      
      
        <?php endforeach; ?>

        <?php //if(count($pizzas) >= 2): ?>
          <!-- <p>There are 2 or more pizzas</p> -->
        <?php //else: ?>
          <!-- <p>There are less then 2 pizzas</p> -->
        <?php //endif; ?>  
    </div>
    
  </div>

  <?php include('templates/footer.php'); ?>


</html>