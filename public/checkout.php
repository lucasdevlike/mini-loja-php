<?php

require '../vendor/autoload.php';

use app\library\Cart;
use Stripe\StripeClient;

session_start();

$stripe = new StripeClient('sk_test_51NcULxALyJYVjleyl9ALZ5i8c6Sk97lOCIbhpU53vathIqabiM6nFfRfRbcR0JuhDgsteZgMmrSYNl4bOW7tZNow004od1s8kl');

$cart = new Cart();
$productInCart = $cart->getCart();

$items = [
    'mode' => 'payment',
    'success_url' => 'http://localhost:8000/success.php',
    'cancel_url' => 'http://localhost:8000/cancel.php',
];

foreach ($productInCart as $product) {
    $items['line_items'][] = [
        'price_data' => [
            'currency' =>'brl',
            'product_data' => [
                'name' => $product->getName()
            ],
            'unit_amount' => $product->getPrice() * 100
        ],
        'quantity' => $product->getQuantity()

    ];
}

$checkout_session = $stripe->checkout->sessions->create($items);

header("HTTP/1.1 303 See Other");
header("Location: " . $checkout_session->url);
