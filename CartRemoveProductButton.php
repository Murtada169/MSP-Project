<!-- 
    This button/link is on every product on the cart view
    It will redirect/refresh to the cart view again with added product id to be removed
    using GET, the product id will be accessed and the product will be removed
 -->

<!--
    Change the cart.php part to the url of viewing cart page 
    Copy the content to the view cart page, on the part where each product name/price is displayed
-->
<a href="cart.php&remove=<?=$product['id']?>" class="remove">Remove</a>