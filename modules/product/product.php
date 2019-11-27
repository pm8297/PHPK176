<?php
if(!defined('SECURITY')){
	die('Bạn không có quyền truy cập vào web này !');
}
 $prd_id   = $_GET['prd_id'];
 $sql ="SELECT * FROM product WHERE prd_id=$prd_id";
 $query = mysqli_query($conn,$sql);
 $row = mysqli_fetch_assoc($query);

 
 if(isset($_GET['page'])){
    $page = $_GET['page'];
}else{
    $page = 1;
}
//*----------- gán số trang cần hiển thị
$rows_per_page = 3;
//*-------------- dùng công thức
$per_row = $page*$rows_per_page-$rows_per_page;
//*-------------truy vấn
$total_rows = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM comment WHERE prd_id=$prd_id"));
$total_pages = ceil($total_rows/$rows_per_page);
//*------------ --code nút pre page
$list_pages = '';
$page_prev = $page -1;

if($page_prev <= 0){
    $page_prev = 1;
}
$list_pages .= ' <li class="page-item"><a class="page-link" href="index.php?page_layout=product&prd_id='.$prd_id.'&page='.$page_prev.'">&laquo;</a></li>';
//* ---------------tính toán số trang
for($i = 1; $i <= $total_pages; $i++){
    if($i == $page){
        $active = 'active';
    }else{
        $active = '';
    }
    $list_pages .= ' <li class="page-item '.$active.'"><a class="page-link" href="index.php?page_layout=product&prd_id='.$prd_id.'&page='.$i.'">'.$i.'</a></li>';
}
//*---------------- code nút next
$page_next = $page + 1;

if($page_next > $total_pages){
    $page_next = $total_pages;
}
$list_pages .= ' <li class="page-item"><a class="page-link" href="index.php?page_layout=product&page=prd_id='.$prd_id.'&'.$page_next.'">&raquo;</a></li>';

 
?>
<!--	List Product	-->
<div id="product">
    <div id="product-head" class="row">
        <div id="product-img" class="col-lg-6 col-md-6 col-sm-12">
            <img src="admin/img/products/<?php echo $row['prd_image']; ?>">
        </div>
        <div id="product-details" class="col-lg-6 col-md-6 col-sm-12">
            <h1><?php echo $row['prd_name']; ?></h1>
            <ul>
                <li><span>Bảo hành:</span> <?php echo $row['prd_warranty']; ?></li>
                <li><span>Đi kèm:</span> <?php echo $row['prd_accessories']; ?></li>
                <li><span>Tình trạng: </span><?php echo $row['prd_new']; ?></li>
                <li><span>Khuyến Mại:</span> <?php echo $row['prd_promotion']; ?></li>
                <li id="price">Giá Bán (chưa bao gồm VAT)</li>
                <li id="price-number"><?php echo $row['prd_price']; ?></li>
                <li id="status" class="<?php if($row['prd_status']==1){echo 'text-success';}else{echo 'text-danger';}?>"><?php if($row['prd_status']==1){echo 'Còn hàng'; }else{echo 'Hết hàng';} ?></li>
            </ul>
            <div id="add-cart"><a href="modules/cart/add_cart.php?prd_id=<?php echo $row['prd_id']; ?>">Mua ngay</a></div>
        </div>
    </div>
    <div id="product-body" class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <h3>Đánh giá về <?php echo $row['prd_name']; ?></h3>
            <p>
            <?php echo $row['prd_details']; ?>
            </p>
            
        </div>
    </div>
    <?php
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    if(isset($_POST['sbm'])){
     $comm_name = $_POST['comm_name'];
     $comm_mail = $_POST['comm_mail'];
     $comm_details = $_POST['comm_details'];
     $comm_date = date("Y-m-d H:i:s");
     
     $sql_insert = "INSERT INTO comment(prd_id,comm_name,comm_mail,comm_date,comm_details) VALUES ('$prd_id','$comm_name','$comm_mail','$comm_date','$comm_details')";
     $query_insert = mysqli_query($conn,$sql_insert);  
    }
?>
    <!--	Comment	-->
    <div id="comment" class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <h3>Bình luận sản phẩm</h3>
            <form method="post">
                <div class="form-group">
                    <label>Tên:</label>
                    <input name="comm_name" required type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label>Email:</label>
                    <input name="comm_mail" required type="email" class="form-control" id="pwd">
                </div>
                <div class="form-group">
                    <label>Nội dung:</label>
                    <textarea name="comm_details" required rows="8" class="form-control"></textarea>
                </div>
                <button type="submit" name="sbm" class="btn btn-primary">Gửi</button>
            </form>
        </div>
    </div>
    <!--	End Comment	-->
    <?php
    $sql_comm = "SELECT * FROM comment WHERE prd_id=$prd_id ORDER BY comm_id DESC LIMIT $per_row,$rows_per_page";
    $query_comm = mysqli_query($conn,$sql_comm);
    ?>
    <!--	Comments List	-->
    <div id="comments-list" class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <?php while ($row_comm = mysqli_fetch_assoc($query_comm)){ ?>
            <div class="comment-item">
                <ul>
                    <li><b><?php echo $row_comm['comm_name']; ?></b></li>
                    <li><?php echo $row_comm['comm_date']; ?></li>
                    <li>
                        <p><?php echo $row_comm['comm_details']; ?></p>
                    </li>
                </ul>
            </div>
            <?php } ?>
        </div>
    </div>
    <!--	End Comments List	-->
</div>
<!--	End Product	-->
<div id="pagination">
    <ul class="pagination">
    <?php echo $list_pages;?>
    </ul>
</div>
