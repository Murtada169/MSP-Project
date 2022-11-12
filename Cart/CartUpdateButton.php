<!-- 
    This button/link is on the end of cart view
    the user can change the quantity of the product in the cart view, and this button will run function that will re-calculate the price
    It will redirect to the cart view again with the updated quantity
 -->

<!--
    Change the cart.php part to the url of viewing cart page 
    Copy the content to view cart page, after the table that shows the list of the items
-->
<form action="cart.php" method="post">
    <div class="buttons">
        <input type="submit" value="Update" name="update">
    </div>
</form>