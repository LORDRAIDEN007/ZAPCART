<?php include_once 'sub-views/header.php'; ?>
<?php
if(isset($_GET['pwd'])) {
    if($_GET['pwd']=='updated') {
        echo "<script>alert('Your password has been reset!!');</script>";
    }
}
?>
<link rel="stylesheet" href="assets/css/form.css">
<style>
  main {
  background-image: url('assets/images/bg.jpeg');
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  height: 100vh; /* Full viewport height */
  margin: 0; /* Remove default margin */
  display: flex; /* Optional: Center content inside the main */
  align-items: center; /* Optional: Center content vertically */
  justify-content: center; /* Optional: Center content horizontally */
}
    
  input {
    border :0px !important;
    border-bottom: 2px solid #424242 !important;
    color :#424242 !important;
    border-radius: 0px !important;
    font-weight: bold !important;
    background-color: whitesmoke !important;    
  }
  *:focus {
    outline: none !important;
  }
  label {
    color : #828282 !important;
    font-size: 19px;
  }
  h5.form-name {
    color: #424242;
    font-family: 'Courier New', Courier, monospace;
    font-weight: 50;
    margin-bottom: 0px !important;
    margin-top: 10px;
  }
  h1 {
    font-size: 45px !important;
    margin-bottom: 20px;  
    font-family :'product sans';
    font-weight: bolder;
  }
  div.form-out {
    /* border-radius: 40px; */
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);  
    background-color: whitesmoke !important;
    padding: 40px;
    margin-top: 80px;
  }
  .input-group {
  position: relative;
  display: inline-block;
  width: 100%;
}
  select {
    float: right;
    font-weight: bold !important;
    color :#424242 !important;
  }
  @media screen and (max-width: 900px){
    body {
      background-color: lightblue;
      background-image: none;
    }
    div.form-out {
    padding: 20px;
    background-color: none !important;
    margin-top: 20px;
  }  
}  

</style>
<main style="background-image: url('assets/images/bg.jpeg'); " >
<?php
if(isset($_GET['error'])) {
    if($_GET['error'] === 'invalidcred') {
        echo '<script>alert("Invalid Credentials")</script>';
    } else if($_GET['error'] === 'wrongpwd') {
        echo '<script>alert("Wrong Password")</script>';
    } else if($_GET['error'] === 'sqlerror') {
        echo"<script>alert('Database error')</script>";
    }
}
?>
<div class="container mt-0" >
  <div class="row">
    <?php
    if(isset($_GET['error'])) {
        if($_GET['error'] === 'destless') {
            echo "<script>alert('Dest. date/time is less than src.');</script>";
        } else if($_GET['error'] === 'sqlerr') {
          echo "<script>alert('Database error');</script>";
        }
    }
    ?>
    <div class="col-md-3"></div>
      <div class="bg-light form-out col-md-6">
      <h1 class="text-secondary text-center">ADMIN LOGIN</h1>
      
      <form method="POST" class=" text-center" 
        action="includes/login.inc.php">

        <div class="form-row">  
            <div class="col-1 p-0 mr-1">
                <i class="fa fa-user text-secondary" 
                    style="float: right;margin-top:35px;"></i>
            </div> 
          <div class="col-10 mb-2">              
            <div class="input-group">
                <label for="user_id">Username/ Email</label>
                <input type="text" name="user_id" id="user_id" required
                   >
              </div>              
          </div>       
          <div class="col-1 p-0 mr-1">
                <i class="fa fa-lock text-secondary" 
                    style="float: right;margin-top:35px;"></i>
          </div>                
          <div class="col-10">
            <div class="input-group">
                <label for="user_pass">Password</label>
                <input type="password" name="user_pass" id="user_pass"
                      required>
              </div>            
          </div>          
        </div>              

        <button name="login_but" type="submit" 
          class="btn btn-primary rounded-pill mt-5">
          <div>
          <i class="fa fa-lg fa-arrow-right"></i> Login 
          </div>
        </button>
      </form>
    </div>
    <div class="col-md-3"></div>
    </div>
</div>    
</main>

<?php include_once 'sub-views/footer2.php'; ?>

<script>
$(document).ready(function(){
  $('.input-group input').focus(function(){
    me = $(this) ;
    $("label[for='"+me.attr('id')+"']").addClass("animate-label");
  }) ;
  $('.input-group input').blur(function(){
    me = $(this) ;
    if ( me.val() == ""){
      $("label[for='"+me.attr('id')+"']").removeClass("animate-label");
    }
  }) ;
  // $('#test-form').submit(function(e){
  //   e.preventDefault() ;
  //   alert("Thank you") ;
  // })
});
</script>
