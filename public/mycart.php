<?php

use app\library\Cart;

require '../vendor/autoload.php';

session_start();

$cart = new Cart();
$productInCart = $cart->getCart();
if (isset($_GET['id'])) {
    $id = strip_tags($_GET['id']);
    $cart->remove($id);
    header('Location:mycart.php');
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/estilo.css">
    <title>My Cart</title>

</head>

<body>
    <ul>
        <?php if(count($productInCart) <= 0): ?>
        <li>Nenhum produto adicionado ao carrinho <a href="/index.php">Adicionar produtos</a></li>
        <?php endif; ?>
        <?php foreach($productInCart as $product): ?>
        <li>
            <?= $product->getName();?>
            <input class="quantity" type="text" name="quantity" value="<?= $product->getQuantity() ?> ">
            Preço <b>R$<?php echo number_format($product->getPrice(), 2, ',', '.') ?> </b>|
            Subtotal: <b>R$<?= number_format($product->getPrice() * $product->getQuantity(), 2, ',', '.') ?></b> |
            <a href="?id=<?= $product->getId(); ?>">Remover produto</a>
        </li>
        <?php endforeach; ?>
        <li><b>Total R$<?php echo number_format($cart->getTotal(), 2, ',', '.'); ?></b> <a href="/">Continuar
                comprando</a></li>
    </ul>
    <hr>
    <?php
    if($_SESSION['cart']['total'] > 0) {
        echo '<a href="checkout.php"><button>Checkout</button></a>';
    } else {
        echo '<a href="checkout.php"><button disabled>Checkout</button></a>';
    }
?>
</body>

</html>