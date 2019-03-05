<?php
  require("PHPExcel/PHPExcel.php");
  $objPHPExcel = new PHPExcel();
  $objPHPExcel->setActiveSheetIndex(0);
  // gộp ô
  $merge = ['J3:R3', 'S3:AA3', 'AB3:AJ3'];
  $cellVal = [
    'A1' => 'BÁO CÁO DOANH THU - LỢI NHUẬN THEO TỪNG MÁY BÁN HÀNG',
    'A2' => 'Tháng '.@$_GET['dateStart'],
    'G2' => 'Đơn vị tính: VNĐ',
    'J3' => 'Tháng 7',
    'S3' => 'Tháng 6',
    'AB3' => 'Chênh lệch',
    'A4' => 'STT',
    'B4' => 'Ngày bắt đầu',
    'C4' => 'Ngày Kết thúc',
    'D4' => 'Mã máy',
    'E4' => 'Mã kho',
    'F4' => 'Khu vực',
    'G4' => 'Kênh',
    'H4' => 'Vị trí lắp máy',
    'I4' => 'Tên kho điểm',
    'J4' => 'Số điểm hoạt động',
    'K4' => 'Số lượng bán',
    'L4' => 'Doanh số',
    'M4' => 'Doanh thu',
    'N4' => 'DT TB máy',
    'O4' => 'Giá vốn',
    'P4' => 'LN gộp',
    'Q4' => 'Tỉ trọng DT',
    'R4' => 'Tỉ lệ LN /DT',
    'S4' => 'Số điểm hoạt động',
    'T4' => 'Số lượng bán',
    'U4' => 'Doanh số',
    'V4' => 'Doanh thu',
    'W4' => 'DT TB máy',
    'X4' => 'Giá vốn',
    'Y4' => 'LN gộp',
    'Z4' => 'Tỉ trọng DT',
    'AA4' => 'Tỉ lệ LN /DT',
    'AB4' => 'Số điểm hoạt động',
    'AC4' => 'Số lượng bán',
    'AD4' => 'Doanh số',
    'AE4' => 'Doanh thu',
    'AF4' => 'DT TB máy',
    'AG4' => 'Giá vốn',
    'AH4' => 'LN gộp',
    'AI4' => 'Tỉ trọng DT',
    'AJ4' => 'Tỉ lệ LN /DT',
  ];
  $wrap = ['B4', 'C4', 'H4', 'I4', 'J4', 'K4', 'N4', 'Q4', 'R4', 'W4', 'Z4', 'AA4', 'AB4', 'AC4', 'AE4', 'AF4', 'AI4', 'AJ4'];
    // merge cells
    foreach ($merge as $key => $value) {
      $objPHPExcel->getActiveSheet()->mergeCells($value);
    }
    // set cell value title
    foreach ($cellVal as $key => $value) {
      $objPHPExcel->getActiveSheet()->setCellValue($key, $value);
    }
    // set Wrap Text
    foreach ($wrap as $key => $value) {
      $objPHPExcel->getActiveSheet()->getStyle($value)->getAlignment()->setWrapText(true);
    }
  $border = array(
      'borders' => array(
          'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN,
              'color' => array('argb' => '000000'), //định dạng mã màu theo argb.
          )
      )
  );
  $bold = [
    'font' => array(
        'bold' => true,
        'color' => array('rgb' => '000000') //định dạng mã màu theo rgb.
    )
  ];
  $objPHPExcel->getActiveSheet()->getStyle('A4:AJ4')->applyFromArray($border);
  $objPHPExcel->getActiveSheet()->getStyle('A4:AJ4')->applyFromArray($bold);
  $objPHPExcel->getActiveSheet()->getStyle('J3:AJ3')->applyFromArray($border);
  $dataExport=$modelProduct->find('all',array('conditions'=>$conditions,'order'=>array('created'=>'DESC')));
  // căn giữa 2 bên
  $objPHPExcel->getActiveSheet()->getStyle('A4:AJ4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  // căn giữa trên dưới
  $objPHPExcel->getActiveSheet()->getStyle('A4:AJ4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
  if(!empty($dataExport)){


      // xuất file
      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="BC-doanh-thu-theo-may.xls"');
      header('Cache-Control: max-age=0');
      // If you're serving to IE 9, then the following may be needed
      header('Cache-Control: max-age=1');
      // If you're serving to IE over SSL, then the following may be needed
      header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
      header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
      header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
      header('Pragma: public'); // HTTP/1.0
      $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
      ob_end_clean();
      $objWriter->save('php://output');
      exit;
  } // hết if(!empty($dataExport))
?>
