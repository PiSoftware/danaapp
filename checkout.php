<?php
session_start();
include 'partials/appGestor.php';
// include database conection function (de la librería appGestor)
$conexion = conexion2('localhost','root','','danaapp');

// initializ shopping cart class
include 'Cart.php';
$cart = new Cart;

// redirect to home if cart is empty
if($cart->total_items() <= 0){
    header("Location: /DanaApp/shop.php");
}

// get customer details by session customer ID
$query = $conexion->query("SELECT * FROM users WHERE id = ".$_SESSION['user_id']);
$custRow = $query->fetch_assoc();
$direccion = $conexion->query('SELECT direccion FROM direcciones WHERE user_id = '.$_SESSION['user_id']);
$dir = "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Antojitos Dana</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
    .container{width: 100%;padding: 50px;}
    .table{width: 65%;float: left;}
    .shipAddr{width: 30%;float: left;margin-left: 30px;}
    .footBtn{width: 95%;float: left;}
    .orderBtn {float: right;}
    </style>
</head>
<body>
<div class="container">
    <h1>Vista previa</h1>
    <table class="table">
    <thead>
        <tr>
            <th>Producto</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if($cart->total_items() > 0){
            //get cart items from session
            $cartItems = $cart->contents();
            foreach($cartItems as $item){
        ?>
        <tr>
            <td><?php echo $item["name"]; ?></td>
            <td><?php echo 'Q'.$item["price"].' GTQ'; ?></td>
            <td><?php echo $item["qty"]; ?></td>
            <td><?php echo 'Q'.$item["subtotal"].' GTQ'; ?></td>
        </tr>
        <?php } }else{ ?>
        <tr><td colspan="4"><p>No existen productos agregados.</p></td>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3"></td>
            <?php if($cart->total_items() > 0){ ?>
            <td class="text-center"><strong>Total <?php echo 'Q'.$cart->total().' GTQ'; ?></strong></td>
            <?php } ?>
        </tr>
    </tfoot>
    </table>
    <div class="shipAddr">
        <h4>Shipping Details</h4>
        <p><?php echo $custRow['nombre']; ?></p>
        <p><?php echo $custRow['email']; ?></p>
        <p><?php echo $custRow['tel']; ?></p>
        <p><?php echo $dir; ?></p>
    </div>
    <div class="footBtn">
        <a href="shop.php" class="btn btn-warning"><i class="glyphicon glyphicon-menu-left"></i> Continuar Comprando</a>
        <a href="cartAction.php?action=placeOrder" class="btn btn-success orderBtn">Ordenar <i class="glyphicon glyphicon-menu-right"></i></a>
    </div>
</div>
</body>
</html>
