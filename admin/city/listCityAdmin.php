<?php
$breadcrumb = array('name' => 'Danh sách Tình/Thành phố',
    'url' => $urlPlugins . 'admin/kiosk-admin-city-listCityAdmin.php',
    'sub' => array('name' => 'Tất cả')
);
addBreadcrumbAdmin($breadcrumb);
?>    

<link href="<?php echo $urlHomes . 'app/Plugin/kiosk/admin/style.css'; ?>" rel="stylesheet">
<div class="thanhcongcu">
    <div class="congcu add_p2" onclick="addDataNew();">
        <!-- <span>
            <input type="image"  src="<?php echo $webRoot; ?>images/add.png" />
        </span>
        <br/> -->
        Thêm
    </div>
    <!-- <form action="" method="get" accept-charset="utf-8">
        <div class="table-responsive table1">
            <table class="table table-bordered">
                <tr>
                    <td>
                        <div class="add_p">
                            <div class="congcu" onclick="addDataNew();">
                                <a href="jsvascript:void(0);">Thêm</a>
                            </div>
                        </div>
                    </td>
                    <td>
                        <table class="table table-bordered">
                            <tr>
                                <td>
                                    <input type="text" class="form-control" placeholder="Tỉnh/Thành phố" name="">
                                </td>
                                <td>
                                    <input type="text" class="form-control" placeholder="Quận" name="">
                                </td>
                            <td rowspan="3">
                                <button class="add_p1">Tìm kiếm</button>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</form> -->

</div>
<div class="clear"></div>

<div class="taovien" >
    <form action="" method="post" name="listForm">
        <div class="table-responsive">
            <table id="listTable" cellspacing="0" class="tableList">

                <tr>
                    <th align="center" width="30">STT</th>
                    <th align="center" width="150">Tỉnh/Thành phố</th>
                    <th align="center" width="150">Quận/Huyện</th>
                    <th align="center" width="30">Hành động</th>
                </tr>
                <?php
                if (!empty($listData['Option']['value']['allData'])) {
                    $i=0;
                    foreach ($listData['Option']['value']['allData'] as $components) {
                        $i++;
                        ?>
                        <tr id="trList">
                            <td align="center" ><?php echo $i; ?></td>
                            <td height="40" id="name<?php if (isset($components['id'])) echo $components['id']; ?>"><?php if (isset($components['id'])) echo arrayMap( $components['name']); ?></td>
                            <td><a href="<?php echo $urlPlugins; ?>admin/kiosk-admin-city-listDistrictAdmin.php?idCity=<?php echo $components['id']; ?>">Thêm Quận/Huyện</a></td>
                            <td align="center" width="165" >
                                <input class="input" type="button"  value="Sửa" onclick="changeName(<?php if (isset($components['id'])) echo $components['id']; ?>, '<?php echo $components['name']; ?>');">
                                &nbsp;
                                <input class="input" type="button" value="Xóa" onclick="deleteData('<?php if (isset($components['id'])) echo $components['id']; ?>');">
                            </td>
                        </tr>
                        <?php
                    }
                }else {
                    echo '<tr><td colspan="4" align="center">Chưa có dữ liệu Tỉnh/Thành phố</td></tr>';
                }
                ?>

            </table>
        </div>
    </form>
</div>

<div id="themData">
    <form method="post" action="">
        <input type="hidden" value="" name="id" id="idData" onkeyup="checkSpaceInKeyUp('idData');" required />
        Tên Tỉnh/Thành phố<br /><br /><input type='text' id='nameData' name="name" value='' />&nbsp;&nbsp;<input type='submit' value='Lưu' class='input' required/>
    </form>
</div>

<script type="text/javascript">
    var urlDeleteData = "<?php echo $urlPlugins . 'admin/kiosk-admin-city-deleteCityAdmin.php'; ?>";
    var urlNow = "<?php echo $urlNow; ?>";

    function changeName(id, name)
    {
        document.getElementById("idData").value = id;
        document.getElementById("nameData").value = name;

        $('#themData').lightbox_me({
            centered: true,
            onLoad: function () {
                $('#themData').find('input:first').focus()
            }
        });
    }

    function addDataNew()
    {
        document.getElementById("idData").value = '';
        document.getElementById("nameData").value = '';

        $('#themData').lightbox_me({
            centered: true,
            onLoad: function () {
                $('#themData').find('input:first').focus()
            }
        });
    }

    function deleteData(id)
    {
        var r = confirm("Bạn có chắc chắn muốn xóa không ?");
        if (r == true)
        {
            $.ajax({
                type: "POST",
                url: urlDeleteData,
                data: {id: id}
            }).done(function (msg) {
                window.location = urlNow;
            })
            .fail(function () {
                window.location = urlNow;
            });
        }

    }
</script>
