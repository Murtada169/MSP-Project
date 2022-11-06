<?php
//product_id and quantity are from the individual product page, they are POST'ed when the user click an 'Add to cart' button
if (isset($_POST['product_id'], $_POST['quantity']) && is_numeric($_POST['product_id']) && is_numeric($_POST['quantity'])) {
    // Set the post variables so we easily identify them, also make sure they are integer
    $product_id = (int)$_POST['product_id'];
    $quantity = (int)$_POST['quantity'];
    
    //Check if cart exists and if cart is an array
    if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
        //Check if the product_id is in cart
        if (array_key_exists($product_id, $_SESSION['cart'])) {
            // Product exists in cart so just update the quanity
            $_SESSION['cart'][$product_id] += $quantity;
        } else {
            // Product is not in cart so add it
            $_SESSION['cart'][$product_id] = $quantity;
        }
    //cart doesn't exist, so...
    } else {
        // Declare cart is an array with this product_id and quantity
        $_SESSION['cart'] = array($product_id => $quantity);
    }
?>