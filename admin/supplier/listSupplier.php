<link href="<?php echo $urlHomes . 'app/Plugin/kiosk/admin/style.css'; ?>" rel="stylesheet">
<?php
$breadcrumb = array('name' => 'Nhà cung cấp',
    'url' => $urlPlugins . 'admin/kiosk-admin-supplier-listSupplier.php',
    'sub' => array('name' => 'Tất cả')
);
addBreadcrumbAdmin($breadcrumb);
?> 

<div class="clear"></div>

<div id="content">
    <?php
    if (isset($_GET['stt'])) {
        switch ($_GET['stt']) {
            case 1: echo '<p style="color:red;">Lưu thông tin thành công!</p>';
            break;
            case -1: echo '<p style="color:red;">Lưu thông tin không thành công!</p>';
            break;
            case 3: echo '<p style="color:red;">Sửa thông tin thành công!</p>';
            break;
            case -3: echo '<p style="color:red;">Sửa thông tin không thành công!</p>';
            break;
            case 4: echo '<p style="color:red;">Cập nhập trạng thái thông tin thành công!</p>';
            break;
        }
    }
    ?>
   <!--  <a style="padding: 4px 8px;" href="<?php echo $urlPlugins . 'admin/kiosk-admin-supplier-addSupplier.php'; ?>" class="input">
        <img src="<?php echo $webRoot; ?>images/add.png"> Thêm
    </a>   -->
    <div class="clear"></div>
    <!-- <form>
        Mã NCC <input type="text" name="code" value="<?php echo @$_GET['code'];?>" /> 
        Tên NCC <input type="text" name="name" value="<?php echo @$_GET['name'];?>" /> 
        <input type="submit" name="" value="Tìm kiếm">
    </form> -->
    <form action="" method="get" accept-charset="utf-8">
        <div class="table-responsive table1">
            <table class="table table-bordered">
                <tr>
                    <td>
                        <div class="add_p">
                            <a href="<?php echo $urlPlugins . 'admin/kiosk-admin-supplier-addSupplier.php'; ?>">Thêm</a>
                        </div>
                    </td>
                    <td>
                        <table class="table table-bordered" style="margin-bottom: 0;">
                            <tr>
                                <td>
                                    <input type="text" class="form-control" placeholder="Mã nhà cung cấp" name="code" value="<?php echo @arrayMap($_GET['code']);?>">
                                </td>
                                <td>
                                   <input type="text" class="form-control" placeholder="Tên nhà cung cấp" name="name" value="<?php echo @arrayMap($_GET['name']);?>">
                               </td>
                               <td>
                                <input type="text" class="form-control" placeholder="Điện thoại" name="phone" value="<?php echo @arrayMap($_GET['phone']);?>">
                            </td>

                            <td rowspan="3">
                                <button class="add_p1">Tìm kiếm</button>
                            </td>
                        </tr>
                        <tr>
                           <td>
                            <input type="text" class="form-control" placeholder="Email" name="email" value="<?php echo @arrayMap($_GET['email']);?>">
                        </td>
                        <td>
                            <select name="status" class="form-control">
                                <option value="">Trạng thái</option>
                                <option value="active" <?php if(!empty($_GET['status'])&&$_GET['status']=='active') echo'selected';?>>Kích hoạt</option>
                                <option value="lock" <?php if(!empty($_GET['status'])&&$_GET['status']=='lock') echo'selected';?>>Khóa</option>
                            </select>
                        </td>
                        <td colspan="" rowspan="" headers=""></td>
                        <!-- <td colspan="" rowspan="" headers=""></td> -->
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
</form>
<div class="clear"></div>
<br/>
<form action="" method="post" name="duan" class="taovienLimit">
    <table id="listTable" cellspacing="0" class="tableList">
        <thead> 
            <tr> 
                <th style="text-align: center; width: 40px;">STT</th>
                <th style="text-align: center;">Mã NCC</th> 
                <th style="text-align: center;">Tên NCC</th> 
                <th style="text-align: center;">Email</th> 
                <th style="text-align: center;">SĐT</th> 
                <th style="text-align: center;">Hành động</th>  
            </tr> 
        </thead>
        <tbody> 
            <?php
            if (!empty($listData)) {
                $i=$limit*($page-1);
                foreach ($listData as $tin) {
                    $i++;
                    if($tin['Supplier']['status']=='active'){
                        $action= '<button type=""><a style="padding: 4px 8px;color: black" href="'. $urlPlugins . 'admin/kiosk-admin-supplier-updateStatusSupplier.php?status=lock&id=' . $tin['Supplier']['id'] .'" class="input" onclick="return confirm(\'Bạn có chắc chắn muốn khóa không ?\');"  >Khóa</a></button>';
                    }else{
                        $action= '<button type=""><a style="padding: 4px 8px;color: black" href="'. $urlPlugins . 'admin/kiosk-admin-supplier-updateStatusSupplier.php?status=active&id=' . $tin['Supplier']['id'] .'" class="input" onclick="return confirm(\'Bạn có chắc chắn muốn kích hoạt không ?\');"  >Kích hoạt</a></button>';
                    }

                    ?>

                    <tr> 
                        <td style="text-align: center;"><?php echo $i;?></td>
                        <td class="break_word"><?php echo $tin['Supplier']['code']; ?></td> 
                        <td class="break_word"><?php echo $tin['Supplier']['name']; ?></td> 
                        <td class="break_word"><?php echo $tin['Supplier']['email']; ?></td> 
                        <td class="break_word"><?php echo $tin['Supplier']['phone']; ?></td> 
                        <td class="break_word" align="center">
                            <button type=""><a style="padding: 4px 8px;color: black" href="<?php echo $urlPlugins . 'admin/kiosk-admin-supplier-addSupplier.php?id=' . $tin['Supplier']['id']; ?>" class="input"   >Sửa</a></button>
<!--                             <button type="" onclick="location.href='<?php echo $urlPlugins . 'admin/kiosk-admin-supplier-addSupplier.php?id=' . $tin['Supplier']['id']; ?>';">Sửa</button>  
 -->                            <?php echo $action;?>
                        </td> 

                    </tr> 


                    <?php
                }
            } else {
                ?>
                <tr>
                    <td align="center" colspan="8">Chưa có nhà cung cấp nào.</td>
                </tr>
                <?php }
                ?>
            </tbody> 
        </table>
        <p>
            <?php

            if ($page > 5) {
                $startPage = $page - 5;
            } else {
                $startPage = 1;
            }

            if ($totalPage > $page + 5) {
                $endPage = $page + 5;
            } else {
                $endPage = $totalPage;
            }

            echo '<a href="' . $urlPage . $back . '">Trang trước</a> ';
                for ($i = $startPage; $i <= $endPage; $i++) {
                    echo ' <a href="' . $urlPage . $i . '" ';
                        if (!empty($_GET['page'])&&$_GET['page']==$i) {
                            echo 'class="page"';
                        }
                    echo '>' . $i . '</a> ';
                }
                echo ' <a href="' . $urlPage . $next . '">Trang sau</a> ';

                echo 'Tổng số trang: ' . $totalPage;
                ?>
        </p>
    </form>
    <style type="text/css">
    .page
    {
        text-decoration: underline;
    }
</style>
</div>