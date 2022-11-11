<?php

    $firstname = '';
    $lastname = '';
    $username = '';
    $email = '';
    $phone = '';
    $password = '';

    if(count($_POST) > 0) {

        require "autoload.php";

        $User = new User();
        $errors = $User->signup($_POST);

        if(count($errors) == 0){
            header("Location: dashboard.php");
            die;

        }
        
        extract($_POST);
    }
      
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>signup</title>
    
    <link rel="stylesheet" href="style.css">
</head>
<body>   

<form method="post" style="padding: 10px;border: solid thin #aaa; border-radius: 10px;margin:auto;width: 500px;">

<?php if(isset($errors) && is_array($errors) && count($errors) > 0): ?>
        <div class="error">
            <?php foreach($errors as $error): ?>
                <?php echo $error ?><br>
            <?php endforeach; ?>
    </div>
        <?php endif; ?>

    <h4>Please fill out the form</h4>
    Firstname <input class="textbox" type="text" name="firstname" placeholder="Enter your firstname" autofocus value="<?php echo $firstname ?>">
    Lastname <input class="textbox" type="text" name="lastname" placeholder="Enter your lastname" value="<?php echo $lastname ?>"><br>
    Email <input class="textbox" type="text" name="email" placeholder="Enter your email address" value="<?php echo $email ?>"><br>
    Phone <input class="textbox"  type="text" name="phone" placeholder="Enter your phone number" value="<?php echo $phone ?>"><br>
    Password <input class="textbox" type="password" name="password" placeholder="Password">
    <br><br>
    <input class="button" type="submit" value="Signup">
    <br style="clear: both;">
    
</form>
   
</body>
</html>