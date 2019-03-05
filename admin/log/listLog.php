<link href="<?php echo $urlHomes . 'app/Plugin/kiosk/admin/style.css'; ?>" rel="stylesheet">
<?php
$breadcrumb = array('name' => 'Lịch sử hoạt động',
    'url' => $urlPlugins . 'admin/kiosk-admin-log-listLog.php',
    'sub' => array('name' => 'Tất cả')
);
addBreadcrumbAdmin($breadcrumb);
?> 

<!-- <div class="clear"></div>
<div class="table-responsive table1">
    <table class="table table-bordered">
        <tr>
            <td>
                <input type="text" value="" name="dateStorage" id="" placeholder="Thời gian" data-inputmask="'alias': 'date'" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" maxlength="50" class="input_date form-control">
            </td>
            <td>
                <input type="text" class="form-control" placeholder="Hành động" name="">
            </td>
            <td rowspan="3">
                <button class="add_p1">Tìm kiếm</button>
            </td>
        </tr>
    </table>
</div> -->


<div class="clear"></div>
<style type="text/css">
    .page
    {
        text-decoration: underline;
    }
</style>
<div id="content">
    <form action="" method="post" name="duan" class="taovienLimit">
        <table id="listTable" cellspacing="0" class="tableList">
            <thead> 
                <tr> 
                    <th style="text-align: center;" width="20">STT</th>
                    <th style="text-align: center;"; >Thời gian</th> 
                    <th style="text-align: center;">Hành động</th> 
                </tr> 
            </thead>
            <tbody> 
                <?php
                if (!empty($listData)) {
        $i=$limit*($page-1);
                    foreach ($listData as $tin) {
                        $i++;
                        $content= (isset($tin['Log']['content']))?$tin['Log']['content']:'Không có nội dung';
                        echo '  <tr> 
                        <td style="text-align: center;">'.$i.'</td>
                        <td class="break_word" style="width:5px;text-align: center;">'.date('d/m/Y H:i:s',$tin['Log']['time']).'</td> 
                        <td class="break_word">'.$content.'</td> 
                        </tr> ';
                    }
                } else {
                    ?>
                    <tr>
                        <td align="center" colspan="8">Chưa có hoạt động nào.</td>
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
    </div>