<?php
if(!defined('SECURITY')){
	die('Bạn không có quyền truy cập vào web này !');
}
?>
<div id="search" class="col-lg-6 col-md-6 col-sm-12">
    <form action="index.php" class="form-inline" method="get">
        <input type="hidden" name="page_layout" value="search">
        <input class="form-control mt-3" type="search" placeholder="Tìm kiếm" aria-label="Search" name="key">
        <button class="btn btn-danger mt-3" type="submit">Tìm kiếm</button>
    </form>
</div>
