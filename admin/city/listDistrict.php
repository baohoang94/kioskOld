<link href="<?php echo $urlHomes . 'app/Plugin/mantanHotel/style.css'; ?>" rel="stylesheet">

<?php
global $languageProduct;

$breadcrumb = array('name' => 'Quận/Huyện',
    'url' => $urlPlugins . 'admin/mantanHotel-admin-city-listDistrict.php',
    'sub' => array('name' => 'Danh sách Các Quận/Huyện')
);
addBreadcrumbAdmin($breadcrumb);
?>
<div class="thanhcongcu">
    <div class="congcu" onclick="addDataNew();">
        <span>
            <input type="image"  src="<?php echo $webRoot; ?>images/add.png" />
        </span>
        <br/>
        Thêm
    </div>
</div>
<div class="clear"></div>
<div class="taovien" >
    <form action="" method="post" name="listForm">
        <table id="listTable" cellspacing="0" class="tableList">

            <tr>
                <th align="center">STT</th>
                <th align="center" width="30">ID</th>
                <th align="center" width="150">Quận huyện</th>
                <th align="center" width="30">Chọn</th>
            </tr>
            <?php
            if (isset($_GET['idCity'])) {
                $idCity = $_GET['idCity'];
            }
            

            if (isset($listData['Option']['value']['allData'][$idCity]['allData']) && count($listData['Option']['value']['allData'][$idCity]['allData']) > 0) {
                $i=0;
                foreach ($listData['Option']['value']['allData'][$idCity]['allData'] as $components) {
                    $i++;
                    pr($listData['Option']['value']['allData']);
                    ?>
                    <tr>
                        <td align="center" ><?php echo $components['id']; ?></td>
                        <td><?php echo $components['name']; ?></td>
                        <td align="center" width="165" >
                            <input class="input" type="button" value="Sửa" onclick="changeName(<?php if (isset($components['id'])) echo $components['id']; ?>, '<?php echo $components['name']; ?>');">
                            &nbsp;
                            <input class="input" type="button" value="Xóa" onclick="deleteData('<?php if (isset($components['id'])) echo $components['id']; ?>');">
                        </td>
                    </tr>
                   <?php
                }
            }else{
                echo '<tr><td colspan="4">Chưa có dữ liệu Quận Huyện</td></tr>';
            }
            ?>
        </table>
    </form>
</div>
<div id="themData">
    <form method="post" action="">
        <input type="hidden" value="" name="id" id="idData" />
        Tên Quận Huyện:<br /><br /><input type='text' id='nameData' name="name" value='' />&nbsp;&nbsp;<input type='submit' value='Lưu' class='input' />
    </form>
</div>
<script type="text/javascript">
    var urlDeleteData = "<?php echo $urlPlugins . 'admin/mantanHotel-admin-city-deleteCityAdmin.php'; ?>";
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