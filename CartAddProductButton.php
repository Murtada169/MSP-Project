<!--
    this button is on individual product page
    $product is a result from SELECT query FROM product table in database
    $product['id'] will be passed using POST method to CartAddProductLogic.php
 -->

<!-- 
    Change the cart.php to the url of the viewing cart page 
    Copy the content of this script to the product page
-->
<form action="cart.php" method="post">
    <input type="number" name="quantity" value="1" min="1" placeholder="Quantity" required>
    <input type="hidden" name="product_id" value="<?=$product['id']?>">
    <input type="submit" value="Add To Cart">
</form>