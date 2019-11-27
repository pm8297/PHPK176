<?php
if(isset($_SESSION['cart'])){
    //cập nhật giỏ hàng
    if(isset($_POST['sbm'])){                      // foreach ($_POST['cart] as $key => $value){$_SESSION['cart'][$key]= $value;}
        $_SESSION['cart'] = $_POST['cart'];
        //print_r($_SESSION['cart']);
        //giá trị ô input
        //print_r($_POST['cart']);
    }   

    $cart = $_SESSION['cart'];
    $arr_key = array_keys($cart);
    $str_key = implode(',',$arr_key);
 
    $sql = "SELECT * FROM product WHERE prd_id IN($str_key)";
    $query = mysqli_query($conn,$sql);
    $total = 0;
?>

<!--	Cart	-->
<div id="my-cart">
    <div class="row">
        <div class="cart-nav-item col-lg-7 col-md-7 col-sm-12">Thông tin sản phẩm</div>
        <div class="cart-nav-item col-lg-2 col-md-2 col-sm-12">Tùy chọn</div>
        <div class="cart-nav-item col-lg-3 col-md-3 col-sm-12">Giá</div>
    </div>
    <form method="post">
        <?php  
        while($row = mysqli_fetch_assoc($query)){ 
        
            $total += $cart[$row['prd_id']]*$row['prd_price'];    
        ?>
        <div class="cart-item row">
          
            <div class="cart-thumb col-lg-7 col-md-7 col-sm-12">
                <img src="admin/img/products/<?php echo $row['prd_image']; ?>">
                <h4><?php echo $row['prd_name']; ?></h4>
            </div>
           
            <div class="cart-quantity col-lg-2 col-md-2 col-sm-12">
                <input type="number" name="cart[<?php echo $row['prd_id']; ?>]" id="quantity" class="form-control form-blue quantity" value="<?php echo $cart[$row['prd_id']]; ?>" min="1">
            </div>
            <div class="cart-price col-lg-3 col-md-3 col-sm-12"><b><?php echo $row['prd_price']*$cart[$row['prd_id']];  ?></b><a href="modules/cart/del_cart.php?prd_id=<?php echo $row['prd_id']; ?>">Xóa</a></div>
        </div>
        <?php } ?>

        <div class="row">
            <div class="cart-thumb col-lg-7 col-md-7 col-sm-12">
                <button id="update-cart" class="btn btn-success" type="submit" name="sbm">Cập nhật giỏ hàng</button>
            </div>
            <div class="cart-total col-lg-2 col-md-2 col-sm-12"><b>Tổng cộng:</b></div>
            <div class="cart-price col-lg-3 col-md-3 col-sm-12"><b>  <?php echo number_format($total,0,'','.'); ?></b></div>
        </div>
      
    </form>

</div>
<!--	End Cart	-->
<?php }else{ ?>
    <div class=" alert alert-danger mt-4">Khônng có sản phẩm nào !</div>
<?php } 

include_once('modules/customer/customer.php');
?>

