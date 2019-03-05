<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/header.php';  ?>
<div class="container-fluid main-container">
	<div class="col-md-12 content">
    <div class="panel panel-default listDevice1">
      <div class="panel-heading">
        <ul class="list-inline">
          <li class="page_prev"><a href="/dashboard"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
          <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
		  		<li class="page_prev"><a href="/syncTransfer"></i> Đối soát dữ liệu</a></li>
          <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
          <li class="page_now">Chi tiết đối soát</li>
        </ul>
      </div>
      <div class="main_list_p ">
          <div class="row">
            <div class="col-sm-12">
              <div class="table-responsive table1">
                <table class="table table-bordered">
                  <tr>
                    <td>
                      <form method="get">
												<?php
												if(!empty($mess)) echo '<br><div class="col-sm-12" style="color:red">'.$mess.'</div>';
						 						if(!empty($mess1)) echo '<div class="col-sm-12" style="color:red">'.$mess1.'</div><br>';
												if(!empty($mess2)) echo '<br><div class="col-sm-12" style="color:red">'.$mess2.'</div>';
												if(!empty($mess3)) echo '<br><div class="col-sm-12" style="color:red">'.$mess3.'</div>';
												if(!empty($mess4)) echo '<br><div class="col-sm-12" style="color:red">'.$mess4.'</div>';
						 							?>
                        <table class="table table-bordered">
                          <tr>
                            <td>
                              <input type="text" value="<?php echo @$_GET['dateStart']; ?>" name="dateStart" id="" placeholder="Từ ngày" class="datetimepicker form-control">
                            </td>
                            <td>
                              <input type="text" value="<?php echo @$_GET['dateEnd'];?>" name="dateEnd" id="" placeholder="Đến ngày" class="datetimepicker form-control">
                            </td>
                            <td>
															<select name="idPlace" class="form-control" placeholder="Chọn điểm đặt" id="idPlace">
                                <option value="1">Chọn điểm đặt</option>
                                <?php
                                if(!empty($listPlace)){
                                  foreach ($listPlace as $key => $value) {

                                    ?>
                                    <option value="<?php echo $value['Place']['id'];?>" <?php if(!empty($_GET['idPlace'])&&$_GET['idPlace']==$value['Place']['id']) echo'selected';?>><?php echo $value['Place']['name'];?></option>
                                    <?php
                                  }
                                }

                                ?>
                              </select>
                            </td>
                            <td>
															<select class="form-control" name="codeMachine" id="codeMachine">
                                <option value="1" >Mã máy</option>
                                <?php
                                  if(!empty($listMachine)){
                                    foreach ($listMachine as $valueMachine) {
                                      ?>
                                      <option value="<?php echo $valueMachine['Machine']['code'];?>" <?php if(!empty($_GET['codeMachine'])&&$_GET['codeMachine']==$valueMachine['Machine']['code']) echo'selected';?>><?php echo $valueMachine['Machine']['code'];?></option>
                                      <?php
                                    }
                                  }
                                 ?>
                              </select>
                            </td>

                            <td >
                              <button class="add_p1">Tìm kiếm</button>
                            </td>
                          </tr>
                          <tr>

                            <td>
															<select name="typedateEndPay" class="form-control" placeholder="Xã">
																<option value="">Hình thức thanh toán</option>
																<?php
																global $listTypePay;
																if(!empty($listTypePay)){
																	foreach ($listTypePay as $key => $value) {

																		?>
																		<option value="<?php echo $value['id']?>" <?php if(!empty($_GET['typedateEndPay'])&&$_GET['typedateEndPay']==$value['id']) echo'selected';?>><?php echo $value['name']?></option>
																		<?php
																	}
																}
																?>
															</select>
                            </td>
                            <td>
															<select name="status" class="form-control" placeholder="Trạng thái thanh toán">
																<option value="">Trạng thái giao dịch</option>
																<?php
																global $listStatusPay;
																if(!empty($listStatusPay)){
																	foreach ($listStatusPay as $key => $value) {

																		if($key==0){
																			?>
																			<option value="00" <?php if(isset($_GET['status'])&&$_GET['status']!=''&&$_GET['status']==$value['id']) echo'selected';?>><?php echo $value['name']?></option>
																			<?php
																		}else{
																			?>
																			<option value="<?php echo $value['id']?>" <?php if(isset($_GET['status'])&&$_GET['status']!=''&&$_GET['status']==$value['id']) echo'selected';?>><?php echo $value['name']?></option>
																			<?php
																		}

																	}
																}
																?>
															</select>
                            </td>
                            <td>
															<select class="form-control" name="statusRecord">
																<option value="">Trạng thái bản ghi</option>
																<?php
																$record=array(
																	'0'=>array('id'=>0,'name'=>'Chưa đồng bộ'),
															    '1'=>array('id'=>1,'name'=>'Đồng bộ thành công'),
															    '2'=>array('id'=>2,'name'=>'Đồng bộ thất bại'),
																);
																	foreach ($record as $key => $value) {
																		?>
																		<option value="<?php echo $value['id']?>" <?php if(!empty($_GET['statusRecord'])&&$_GET['statusRecord']==$value['id']) echo'selected';?>><?php echo $value['name']?></option>
																		<?php
																	}

																 ?>
															</select>
                            </td>
														</form>
                            <td>
															<form action="" method="POST">
                                  <td>
                                    <input type="" name="inport" value="1" class="hidden">
                                    <button class="add_p1" type="submit">Xuất file excel</button>
                                </td>
                              </form>
                            </td>
                          </tr>
                        </table>

                    </td>
                  </tr>
                  <tr>
                    <div class="">
                        <form action="" method="POST">
                          <td rowspan="2">
                            <button class="add_p1" name="sync"id="sync">Đồng bộ</button>
														<label for="sync">Nguồn: Các giao dịch có tại máy kiosk nhưng chưa được gửi lên server.</label>
                          </td>

                    </div>
                  </tr>
                </table>
                <div class="col-sm-12">
      						<div class="table-responsive table1">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
													<th class="text_table">STT</th>
                          <th class="text_table">Thời gian</th>
                          <th class="text_table">Mã máy</th>
													<th class="text_table">Điểm đặt</th>
                          <th class="text_table">Mã sản phẩm</th>
                          <th class="text_table">Số tiền khách nạp</th>
                          <th class="text_table">Số dư tài khoản</th>
                          <th class="text_table">Doanh thu</th>
                          <th class="text_table">Hình thức Thanh toán</th>
                          <th class="text_table">Trạng thái</th>
													<th class="text_table">
														<input type="checkbox" name="checkAll" id="ckeckAll" value="checkAll">
													</th>
                        </tr>
                      </thead>
                      <tbody>
												<?php
												if(!empty($listSync2)){
													$count=count($listSync2);
													global $listStatusPay; // Trạng thái thanh toán.
													global $listTypePay; // Hình thức thanh toán.
													//for($x=0;$x<$count;++$x){
													$i=0;
													foreach ($listSync2 as $valueSync) {
														$i++;

														echo '<tr>
														<td class="text_table">'.$i.'</td>
														<td class="text_table">'.date('d/m/Y H:i:s',$valueSync['Sync']['timeClient']).'</td>
														<td class="text_table"><a href="infoMachine?id='.$valueSync['Sync']['idMachine'].'">'.$valueSync['Sync']['codeMachine'].'</a></td>
														<td class="text_table"><a href="infoPlace?id='.$valueSync['Sync']['idPlace'].'">'.$valueSync['Sync']['namePlace'].'</a></td>
														<td class="text_table"><a href="infoProduct?id='.$valueSync['Sync']['idProduct'].'">'.$valueSync['Sync']['codeProduct'].'</a></td>
														<td class="text_table">'.$valueSync['Sync']['moneyInput'].'</td>
														<td class="text_table">'.$valueSync['Sync']['moneyAvailable'].'</td>
														<td class="text_table">'.$valueSync['Sync']['moneyCalculate'].'</td>
														<td class="text_table">'.@$listTypePay[$valueSync['Sync']['typedateEndPay']]['name'].'</td>
														<td class="text_table">'.$listStatusPay[$valueSync['Sync']['status']]['name'].'</td>
														<td class="text_table">';
														if($valueSync['Sync']['lock']==(int)1){
														echo '<div class="col-sm-12" style="color:green">OK</div>';
														}
														if($valueSync['Sync']['lock']==(int)2){
														echo '<div class="col-sm-12" style="color:red">Fail<input type="checkbox" name="checkbox[]" value="'.($i-1).'" id="checkbox" ></div>';
														}
														if($valueSync['Sync']['lock']==(int)0){
															echo '<input type="checkbox" name="checkbox[]" value="'.($i-1).'" id="checkbox" >';
														}
														echo
														'</td>
														</tr>';

													} //đóng for().
												} //đóng if(!empty($listData)).
												else{
													echo '<tr><td align="center" colspan="18">Chưa có dữ liệu</td></tr>';
												}
												?>
                      </tbody>
											</form>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>


    </div>
  </div>
</div>

<script type="text/javascript">
				$(document).ready(function() {
						 $("#idPlace").select2({
										placeholder: "Chọn điểm đặt",
										allowClear: true
						 });
						 $("#codeMachine").select2({
							 placeholder: "Mã máy",
							 allowClear: true
						 });
						 jQuery("[name=checkAll]").click(function(source) { // =)))) 5 ngày =))).
				    checkboxes = jQuery("[ id=checkbox ]");
				    for(var i in checkboxes){
				        checkboxes[i].checked = source.target.checked;
				    	}
						});
				});
</script>

<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/footer.php'; ?>
