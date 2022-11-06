<!--
    this button is on individual product page
    $product is a result from SELECT query FROM product table in database
    $product['id'] will be passed using POST method to CartAddProductLogic.php
 -->

<form action="index.php?page=cart" method="post">
    <input type="number" name="quantity" value="1" min="1" placeholder="Quantity" required>
    <input type="hidden" name="product_id" value="<?=$product['id']?>">
    <input type="submit" value="Add To Cart">
</form>