<?php
if(!isset($_REQUEST['id'])){
    header("Location: /DanaApp/shop.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Antojitos Dana</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
    .container{width: 100%;padding: 50px;}
    p{color: #34a853;font-size: 18px;}
    </style>
</head>
</head>
<body>
<div class="container">
    <h1>Orden Creada</h1>
    <p>Su orden ha sido creada correctamente. Su número de orden es: # <?php echo $_GET['id']; ?></p>
</div>
</body>
</html>
