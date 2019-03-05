<link href="<?php echo $urlHomes . 'app/Plugin/kiosk/admin/style.css'; ?>" rel="stylesheet">

<?php
if(!empty($data)){
    $name='Chỉnh sửa nhà cung cấp';
}else{
    $name='Thêm mới nhà cung cấp';
}
$breadcrumb = array('name' => 'Nhà cung cấp',
    'url' => $urlPlugins . 'admin/kiosk-admin-supplier-listSupplier.php',
    'sub' => array('name' => $name)
);
addBreadcrumbAdmin($breadcrumb);
?> 

<div class="taovien row">
    <?php if (!empty($mess)) { ?>
    <p style="font-weight: bold; color: red;"> <?php echo $mess; ?></p>
    <?php } ?>
    <form action="" method="post" name="">
        <div class="taovien col-md-6 col-sm-12 col-xs-12" >
            <div class="form-group">
                <label for="">Mã nhà cung cấp<span class="color_red">*</span>:</label>
                <input type="text" name="code" class="form-control"  id="code" value="<?php echo @arrayMap($data['Supplier']['code']);?>" pattern="([a-zA-Z0-9-]+)" title="Nhập mã không chứa nội dung khoảng trắng, ký tự có dấu. Chỉ sử dụng chữ cái (a-z. A-Z), số, dấu gạch ngang " maxlength="50" placeholder="Mã nhà cung cấp" <?php if(isset($data['Supplier']['code'])){echo "disabled";}else{echo "required";}?> >
            </div>
            <div class="form-group">
                <label for="">Tên nhà cung cấp<span class="color_red">*</span>:</label>
                <input type="text" name="name" class="form-control" id="name" placeholder="Tên nhà cung cấp" value="<?php echo @arrayMap($data['Supplier']['name']);?>" required="">
            </div>
            <div class="form-group">
                <label for="">Email<span class="color_red">*</span>:</label>
                <input type="text" name="email" class="form-control" required="" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[a-zA-Z]{2,3}$" placeholder="Email" id="email" value="<?php echo @arrayMap($data['Supplier']['email']);?>" >
            </div>


        </div>
        <div class="taovien col-md-6 col-sm-12 col-xs-12" >

            <div class="form-group">
                <label for="">Địa chỉ<span class="color_red">*</span>:</label>
                <input type="text" name="address" placeholder="Địa chỉ" value="<?php echo @arrayMap($data['Supplier']['address']);?>" class="form-control" id="address" required style="word-break: break-word;">
            </div>
            <div class="form-group">
                <label for="">Điện thoại<span class="color_red">*</span>:</label>
                <input type="text" name="phone" placeholder="Điện thoại" class="form-control" id="phone" value="<?php echo @arrayMap($data['Supplier']['phone']);?>" required="">
            </div>
            
            <div class="form-group">
                <label for="">Trạng thái<span class="color_red">*</span>:</label>
                <select class="form-control" name="status" required="">
                    <option value="">Trạng thái</option>
                    <option value="active" <?php if(isset($data['Supplier']['status']) && $data['Supplier']['status']=='active') echo 'selected';?> >Kích hoạt</option>
                    <option value="lock" <?php if(isset($data['Supplier']['status']) && $data['Supplier']['status']=='lock') echo 'selected';?> >Khóa</option>
                </select>
            </div>
        </div>
        <div class="taovien col-md-12 col-sm-12 col-xs-12" >
            <div class="form-group">
                <label for="">Mô tả:</label>
                <textarea name="desc" placeholder="Mô tả" class="form-control" rows="6"><?php echo @arrayMap($data['Supplier']['desc']);?></textarea>
            </div>
            

        </div>
        <div class="col-md-12 col-sm-12 col-xs-12" style="text-align: center; margin-bottom: 15px;">
            <button type="submit"  class="btn btn-primary">Lưu</button>
        </form>
        <a href="<?php echo $urlPlugins.'admin/kiosk-admin-supplier-listSupplier.php';?>"  class="btn btn-primary">Quay lại</a>
    </div>

</div>

