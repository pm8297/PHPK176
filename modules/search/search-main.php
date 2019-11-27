<?php
if(!defined('SECURITY')){
	die('Bạn không có quyền truy cập vào web này !');
}
if(isset($_GET['key'])){  //get sử dụng ô input search
    $key  = $_GET['key'];
}else{
    $key ='';
}
//key là Iphone 11 Gold
//hàm explode('Iphone','11','Gold');
//implode chèn %
$arr_key = explode(" ",$key);
$key_end = '%'.implode("%",$arr_key).'%';

if(isset($_GET['page'])){
    $page = $_GET['page'];
}else{
    $page = 1;
}
//*----------- gán số trang cần hiển thị
$rows_per_page = 4;
//*-------------- dùng công thức
$per_row = $page*$rows_per_page-$rows_per_page;
//*-------------truy vấn
$total_rows = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM product WHERE prd_name LIKE '$key_end'"));
$total_pages = ceil($total_rows/$rows_per_page);
//*------------ --code nút pre page
$list_pages = '';
$page_prev = $page -1;

if($page_prev <= 0){
    $page_prev = 1;
}
$list_pages .= ' <li class="page-item"><a class="page-link" href="index.php?page_layout=search&key='.$key.'&page='.$page_prev.'">&laquo;</a></li>';
//* ---------------tính toán số trang
for($i = 1; $i <= $total_pages; $i++){
    if($i == $page){
        $active = 'active';
    }else{
        $active = '';
    }
    $list_pages .= ' <li class="page-item '.$active.'"><a class="page-link" href="index.php?page_layout=search&key='.$key.'&page='.$i.'">'.$i.'</a></li>';
}
//*---------------- code nút next
$page_next = $page + 1;

if($page_next > $total_pages){
    $page_next = $total_pages;
}
$list_pages .= ' <li class="page-item"><a class="page-link" href="index.php?page_layout=search&key='.$key.'&'.$page_next.'">&raquo;</a></li>';
?>
<!--	List Product	-->
<div class="products">
    <div id="search-result">Kết quả tìm kiếm với sản phẩm <span><?php echo $key; ?></span></div>
    <div class="product-list row">
        <?php
        $sql= "SELECT * FROM product WHERE prd_name LIKE '$key_end' LIMIT $per_row,$rows_per_page";
        $query = mysqli_query($conn,$sql);
         while ($row = mysqli_fetch_assoc($query)){ ?>
        <div class="col-lg-4 col-md-6 col-sm-12 mx-product">
            <div class="product-item card text-center">
                <a href="index.php?page_layout=product&prd_id=<?php echo $row['prd_id'] ?>"><img src="admin/img/products/<?php echo $row['prd_image']; ?>"></a>
                <h4><a href="index.php?page_layout=product&prd_id=<?php echo $row['prd_id'] ?>"><?php echo $row['prd_name']; ?></a></h4>
                <p>Giá Bán: <span><?php echo $row['prd_price']; ?></span></p>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
<!--	End List Product	-->

<div id="pagination">
    <ul class="pagination">
    <?php echo $list_pages; ?>
    </ul>
</div>

