<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/header.php'; ?>

<link href='https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic|Roboto+Slab:400,700|Inconsolata:400,700&subset=latin,cyrillic'
rel='stylesheet' type='text/css'>
<link href="<?php echo $urlHomes . 'app/Plugin/kiosk/view/manager/'; ?>css/jquery.contextMenu.css" rel="stylesheet" type="text/css" />
<script src="<?php echo $urlHomes . 'app/Plugin/kiosk/view/manager/'; ?>js/jquery.contextMenu.min.js" type="text/javascript"></script>
<script src="<?php echo $urlHomes . 'app/Plugin/kiosk/view/manager/'; ?>/js/contextMenu-main.js" type="text/javascript"></script>

<script type="text/javascript">
    var urlAdd = "<?php echo $urlHomes; ?>addTrench";
    var urlEdit = "<?php echo $urlHomes; ?>infoTrench";
    var urlDelete = "<?php echo $urlHomes; ?>deleteTrench";
    var urlDeleteFloor = "<?php echo $urlHomes; ?>deleteFloor";
    var urlSettingFloor = "<?php echo $urlHomes; ?>settingFloorMachine";

    $(function () {
        // lựa chọn chuột phải
        $.contextMenu({
            selector: '.context-menu-two',
            callback: function (key, options) {
                var idTrench= options.$trigger.attr("idTrench");
                var idMachine= options.$trigger.attr("idMachine");
                var idFloor= options.$trigger.attr("idFloor");

                switch (key) {
                    case 'edit':
                    url = urlEdit + '?idTrench='+idTrench+'&idMachine='+idMachine+'&idFloor='+idFloor;
                    window.location = url;
                    break;
                    case 'delete':
                    deleteData(idMachine,idFloor,idTrench);
                    break;
                }
            },
            items: {
                "edit": {name: "Cài đặt slot", icon: "edit"},
                "delete": {name: "Xóa slot", icon: "delete"},
            }
        });

        // lựa chọn chuột trái
        $.contextMenu({
            selector: '.context-menu-two',
            trigger: 'left',
            callback: function (key, options) {
                var idTrench= options.$trigger.attr("idTrench");
                var idMachine= options.$trigger.attr("idMachine");
                var idFloor= options.$trigger.attr("idFloor");

                switch (key) {
                    case 'edit':
                    url = urlEdit + '?idTrench='+idTrench+'&idMachine='+idMachine+'&idFloor='+idFloor;
                    window.location = url;
                    break;
                    case 'delete':
                    deleteData(idMachine,idFloor,idTrench);
                    break;
                }
            },
            items: {
                "edit": {name: "Cài đặt slot", icon: "edit"},
                "delete": {name: "Xóa slot", icon: "delete"},
            }
        });

        $.contextMenu({
            selector: '.context-menu-three',
            callback: function (key, options) {
                var idMachine= options.$trigger.attr("idMachine");
                var idFloor= options.$trigger.attr("idFloor");
                switch (key) {
                    case 'add':
                    url = urlAdd + '?idMachine='+idMachine+'&idFloor='+idFloor;
                    window.location = url;
                    break;
                    case 'edit':
                    url = urlSettingFloor + '?idMachine='+idMachine+'&idFloor='+idFloor;
                    window.location = url;
                    break;
                    case 'delete':
                    deleteDataFloor(idMachine,idFloor);
                    break;
                }
            },
            items: {
                "add": {name: "Thêm slot", icon: "add"},
                "edit": {name: "Cài đặt khay", icon: "edit"},
                "delete": {name: "Xóa khay", icon: "delete"},
            }
        });

        $.contextMenu({
            selector: '.context-menu-three',
            trigger: 'left',
            callback: function (key, options) {
                var idMachine= options.$trigger.attr("idMachine");
                var idFloor= options.$trigger.attr("idFloor");
                switch (key) {
                    case 'add':
                    url = urlAdd + '?idMachine='+idMachine+'&idFloor='+idFloor;
                    window.location = url;
                    break;
                    case 'edit':
                    url = urlSettingFloor + '?idMachine='+idMachine+'&idFloor='+idFloor;
                    window.location = url;
                    break;
                    case 'delete':
                    deleteDataFloor(idMachine,idFloor);
                    break;
                }
            },
            items: {
                "add": {name: "Thêm slot", icon: "add"},
                "edit": {name: "Cài đặt khay", icon: "edit"},
                "delete": {name: "Xóa khay", icon: "delete"},
            }
        });
    });
    

    function deleteData(idMachine,idFloor,idTrench)
    {
        var check = confirm('Bạn có chắc chắn muốn xóa slot này không ?');
        if (check)
        {
            url = urlDelete + '?idMachine='+idMachine+'&idFloor='+idFloor+'&idTrench='+idTrench;
            window.location = url;
        }
    }

    function deleteDataFloor(idMachine,idFloor)
    {
        var check = confirm('Bạn có chắc chắn muốn xóa khay này không ?');
        if (check)
        {
            url = urlDeleteFloor + '?idMachine='+idMachine+'&idFloor='+idFloor;
            window.location = url;
        }
    }

</script>

<script type="text/javascript">
    function addFloor()
    {
        var trench= prompt('Nhập số slot cho khay mới');
        if($.isNumeric(trench)){
            $.ajax({
             method: "POST",
             url: "/addFloorMachine",
             data: { id: '<?php echo $_GET['id'];?>', trench: trench }
         })
            .done(function( msg ) {
               location.reload(); 
           });
        }
        return false;
    }
</script>

<script>
    $(document).ready(function () {
        $(".inner").hide();
        $("#txtrequire").keyup(function () {
            var txtmax = $('#txtmax').val();
            var txtrequire = $('#txtrequire').val();

            if (txtrequire === "" || txtmax === "") return false;
            
            if ( parseInt(txtmax) < parseInt(txtrequire) ) {
                $(".inner").show();
                $(".btn_ad").attr("disabled","");
            } else {
                $(".inner").hide();
                $(".btn_ad").removeAttr("disabled");
            }
        });
    });
</script>
<div class="container-fluid main-container">
    <div class="col-md-12 content">

        <div class="panel panel-default listDevice1">
            <div class="panel-heading">
                <ul class="list-inline">
                    <li class="page_prev"><a href="/dashboard"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
                    <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
                    <li class="page_prev"><a href="/listMachine"> Quản lý máy</a></li>
                    <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
                    <li class="page_prev"><a href="/addMachine?id=<?php echo $data['Machine']['id'];?>"> <?php echo $data['Machine']['code'];?></a></li>
                    <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
                    <li class="page_now">Sơ đồ máy</li>
                </ul>
            </div>

            <div class="main_list_p ">
                <div class="row">
                    <div class="col-sm-12 table-responsive table1">
                        <div class="add_p">
                            <form method="post">
                                <!-- <a href="" onclick="return addFloor();">Thêm khay</a>  -->
                                <a href="javascript:void(0);" class="themkhay" data-toggle="modal" data-target="#myModal">Thêm khay</a> 
                                <a href="/sendConfigToKiosk?id=<?php echo $_GET['id'];?>" onclick="return confirm('Bạn có chắc chắn muốn đồng bộ không ?');" style="background: #FAA61A;">Đồng bộ xuống Kiosk</a>
                                
                                <input type="submit" style="float:right;  
                                display: inline-block;
                                margin-right: 10px;
                                background: #226a94;
                                color: white;
                                padding: 10px 20px;" name="export" value="Export Excel">
                            </form>
                            <br/><br>
                            <form style="width: 25%">
                                <table>
                                    <tr>
                                        <td>
                                            <select class="form-control" id="min_product" onchange="getMinProduct()">
                                                <option value="">Số hàng tối thiểu</option>
                                                <option value=1>1</option>
                                                <option value=2>2</option>
                                                <option value=3>3</option>
                                                <option value=4>4</option>
                                                <option value=5>5</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select id="danger" class="form-control" onchange="getDanger()">
                                                <option value=0.5>Mức cảnh báo</option>
                                                <option value=0.5>1/2</option>
                                                <option value=1/3>1/3</option>
                                                <option value=0.25>1/4</option>
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                        <?php
                        if(isset($_GET['sendConfigToKiosk']) && $_GET['sendConfigToKiosk']==1){
                            echo '  <div style="margin-top: 20px">
                            <span style="color: red">Đồng bộ dữ liệu xuống máy thành công</span>
                            </div>';
                        }
                        ?>
                        <?php if (isset($_GET['mess'])&&$_GET['mess']==-1) {?>
                            <div style="margin-top: 20px">
                                <span style="color: red">Mã khay đã tồn tại</span>
                            </div>
                        <?php }
                        elseif(isset($_GET['mess'])&&$_GET['mess']==1) { ?>
                            <div style="margin-top: 20px">
                                <span style="color: red">Thêm khay mới thành công</span>
                            </div>
                            <?php 
                        }
                        elseif(isset($_GET['mess'])&&$_GET['mess']==2) {
                            echo '<div  style="margin-top: 20px">
                            <span style="color: red">Lưu thành công</span>
                            </div>';
                        }
                        elseif(isset($_GET['mess'])&&$_GET['mess']==3) {
                            echo '<div  style="margin-top: 20px">
                            <span style="color: red">Không đồng bộ dữ liệu thành công.Máy phải được cấu hình đầy đủ dữ liệu</span>
                            </div>';
                        }
                        ?>
                    </div>

                    <div id="myModal" class="modal fade" role="dialog">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <form action="/addFloorMachine" method="POST" accept-charset="utf-8">
                                   <input type="hidden" name="id" value="<?php echo isset($_GET['id'])?$_GET['id']:'' ?>">
                                   <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Mã khay<span class="color_red">*</span>: </label>
                                        <input type="number" title="" maxlength="50" id="" pattern="([a-zA-Z0-9-]+)" title="Nhập mã không chứa nội dung khoảng trắng, ký tự có dấu. Chỉ sử dụng chữ cái (a-z. A-Z), số, dấu gạch ngang " placeholder="Mã khay" class="form-control" name="codeFloor" required="" value="">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Nhập số slot cho khay mới<span class="color_red">*</span>: </label>
                                        <input type="text" title="" maxlength="19" id="" placeholder="Nhập số slot cho khay mới" class="input_money form-control" name="trench" required="" value="">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Số sản phẩm tối đa<span class="color_red">*</span>: </label>
                                        <input type="text" title="" maxlength="19" id="txtmax" class="input_money form-control" value="" name="numberLoxo" required="">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Sản phẩm<span class="color_red">*</span>: </label>
                                        <select name="idProduct" id="idProduct" class="form-control" required onchange="checkPrice(this)">
                                            <option value="">Chọn sản phẩm</option>
                                            <?php
                                            if(!empty($listPro)){
                                                foreach($listPro as $components){
                                                    if(empty($floor['idProduct']) || $floor['idProduct']!=$components['Product']['id']){
                                                        echo '<option price="'.$components['Product']['priceOutput'].'" value="'.$components['Product']['id'].'">'.$components['Product']['code'].' - '.$components['Product']['name'].'</option>';
                                                        
                                                    }else{
                                                        echo '<option price="'.$components['Product']['priceOutput'].'" selected value="'.$components['Product']['id'].'">'.$components['Product']['code'].' - '.$components['Product']['name'].'</option>';

                                                    }
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Số sản phẩm còn lại<span class="color_red">*</span>: </label>
                                        <input type="text" title="" maxlength="19" id="txtrequire" class="input_money form-control" value="" name="numberProduct" required="">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Giá bán sản phẩm<span class="color_red">*</span>: </label>
                                        <input maxlength="19" type="text" name="priceProduct" id="priceProduct" value="" maxlength="19" class="input_money form-control" required="">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <button class="btn_ad" style="display: inline-block !important;" type="submit" >Lưu</button><div class="inner" style="color: red">
                                            Số sản phẩm còn lại phải nhỏ hơn số sản phẩm tối đa
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <div class="col-sm-12 diagram table-responsive table1">
          <?php
          if(!empty($data['Machine']['floor'])){
            $i=0;
            foreach ($data['Machine']['floor'] as $key=>$floor) {
                $i++;
                                //$cua=$key+1;
                echo ' 
                <div class="col-md-12 col-sm-12">
                <div class="row">
                <div class="col-sm-4 col-md-2 clear-room  context-menu-three" idMachine="'.$data['Machine']['id'].'" idFloor="'.$key.'" style="background-color: red;"  >
                <br/>
                <center> Mã khay '.$key.'</center>
                </div>
                ';

                foreach ($floor as $trench) {
                                        //$hy=$trench['idTrench']+1;
                  $nameTrench=$i.'-'.$trench['idTrench'];
                  echo '        <div class="col-sm-4 col-md-2 clear-room  context-menu-two" idMachine="'.$data['Machine']['id'].'" idFloor="'.$key.'" idTrench="'.$trench['idTrench'].'" >
                  <br/>
                  <center>Slot số '.$nameTrench.'</center>
                  <div class="name-room">Số lò xo: ' . @number_format($trench['numberLoxo'], 0, ',', '.') . '</div>
                  <div class="name-room">Tên SP: ' . @$listProduct[$trench['idProduct']]['name'] . '</div>
                  <div class="name-room">Số SP còn: ' . @number_format($trench['numberProduct'], 0, ',', '.') . '</div>
                  <div class="name-room">Giá SP: ' . @number_format($trench['priceProduct'], 0, ',', '.') . '</div>
                  </div>
                  ';
              }
              echo '        </div>
              </div>';
          }
      }
      ?> 
  </div>
</div>
</div>
</div>
<script type="text/javascript">
    function checkPrice(product)
    {
        $('#priceProduct').val($('option:selected', product).attr('price'));
    }
</script>
<script>
    var min_product = 1;
    var danger = 1/2;
    var max_slot = <?php echo $sl; ?>;
     function faidColor(){
        for(var i =1; i<=max_slot; i++){
            var tag = document.getElementById('slot_'+i);
            var num_loxo = document.getElementById('num_loxo_'+i).getAttribute("value");
            var num_sp = document.getElementById('num_sp_'+i).getAttribute("value");
            if(num_loxo == 0){
                tag.style.background = "#222";
            } else 
                if(num_sp < min_product){
                    tag.style.background = "red";
                } else 
                    if(num_sp < num_loxo*danger){
                        tag.style.background = "orange";
                    }
                    else tag.style.background = "#2e8b57";
            }
        }  
    function getMinProduct(){
        min_product = document.getElementById('min_product').value;
        faidColor();
    }
    function getDanger(){
        danger = document.getElementById('danger').value;
        faidColor();
    }
    faidColor();
</script>
<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/footer.php'; ?>