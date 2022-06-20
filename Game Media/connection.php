<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
<?php
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $gender = $_POST['gender'];
  $vote = $_POST['vote'];

  if (!empty($username) || !empty($email) || !empty($password) || !empty($gender) || !empty($vote)) {
    $host="localhost";
    $dbuser="root";
    $dbpassword="";
    $database="game_media";

    //create connection
    $conn = new mysqli($host, $dbuser, $dbpassword, $database);

    if (mysqli_connect_error()){
      die('Connect Error('.mysqli_connect_errno().')'. mysqli_connect_error());
    }
    else{
      $select = "select email from login_form where email = ? limit 1";
      $insert = "insert into login_form (username, email, password, gender, vote) values(?,?,?,?,?)";

      //prepare statement
      $stmt = $conn->prepare($select);
      $stmt-> bind_param("s", $email);
      $stmt-> execute();
      $stmt-> bind_result($email);
      $stmt-> store_result();
      $rnum = $stmt->num_rows;

      if ($rnum == 0){
        $stmt -> close();

        $stmt = $conn->prepare($insert);
        $stmt-> bind_param("sssss", $username, $email, $password, $gender, $vote);
        $stmt->execute();
        echo '
        <script type="text/javascript">
          alert("Thanks! Your vote has been recorded.")
        </script>';

        echo 'You can go back to Main Page now :)';
        
      }
      else{
        echo '
        <script type="text/javascript">
          alert("Your Email have been used")
        </script>';

        echo 'Please go back to main page :(';
        
      }

      $stmt -> close();
      $conn -> close();

    }

  }
  else{
    echo "All fields are required";
    die();
  }

?>
</body>
</html>

