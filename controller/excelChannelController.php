<?php
  require("PHPExcel/PHPExcel.php");
  $objPHPExcel = new PHPExcel();
  $objPHPExcel->setActiveSheetIndex(0);
  // gộp ô
  $merge = ['G3:J3', 'K3:S3', 'T3:AB3', 'AC3:AK3'];
  $cellVal = [
    'A1' => 'Doanh thu, lợi nhuận theo mã hàng theo kênh',
    'A2' => 'Trường học',
    'F3' => 'Định mức',
    'G3' => 'Đơn giá bình quân tháng 7',
    'K3' => 'Tháng 7',
    'T3' => 'Tháng 6',
    'AC3' => 'Chênh lệch',
    'A4' => 'STT',
    'B4' => 'Ngày bắt đầu',
    'C4' => 'Mã hàng',
    'D4' => 'Tển sản phẩm',
    'E4' => 'Tên NCC',
    'F4' => 'Giá bán hòa vốn',
    'G4' => 'Giá bán TB Kênh',
    'H4' => 'Doanh thu',
    'I4' => 'Giá vốn',
    'J4' => 'Lợi nhuận',
    'K4' => 'Số điểm hoạt động',
    'L4' => 'Số lượng bán',
    'M4' => 'Doanh số',
    'N4' => 'Doanh thu',
    'O4' => 'DT TB máy',
    'P4' => 'Giá vốn',
    'Q4' => 'LN gộp',
    'R4' => 'Tỉ trọng DT',
    'S4' => 'Tỉ lệ LN/DT',
    'T4' => 'Số điểm hoạt động',
    'U4' => 'Số lượng bán',
    'V4' => 'Doanh số',
    'W4' => 'Doanh thu',
    'X4' => 'DT TB máy',
    'Y4' => 'Giá vốn',
    'Z4' => 'LN gộp',
    'AA4' => 'Tỉ trọng DT',
    'AB4' => 'Tỉ lệ LN/DT',
    'AC4' => 'Số điểm hoạt động',
    'AD4' => 'Số lượng bán',
    'AE4' => 'Doanh số',
    'AF4' => 'Doanh thu',
    'AG4' => 'DT TB máy',
    'AH4' => 'Giá vốn',
    'AI4' => 'LN gộp',
    'AJ4' => 'Tỉ trọng DT',
    'AK4' => 'Tỉ lệ LN/DT',
  ];
  $wrap = ['B4', 'C4', 'D4', 'E4', 'F4', 'G4', 'H4', 'I4', 'J4', 'K4', 'L4', 'M4',
  'N4', 'O4', 'P4', 'Q4', 'R4', 'S4', 'T4', 'U4', 'V4', 'W4', 'X4', 'Y4', 'Z4', 'AA4',
  'AB4', 'AC4', 'AD4', 'AE4', 'AF4', 'AG4', 'AH4', 'AI4', 'AJ4', 'AK4'];
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
  $objPHPExcel->getActiveSheet()->getStyle('A4:AK4')->applyFromArray($border);
  $objPHPExcel->getActiveSheet()->getStyle('A4:AK4')->applyFromArray($bold);
  $objPHPExcel->getActiveSheet()->getStyle('F3:AB3')->applyFromArray($border);
  $dataExport=$modelProduct->find('all',array('conditions'=>$conditions,'order'=>array('created'=>'DESC')));
  // căn giữa 2 bên
  $objPHPExcel->getActiveSheet()->getStyle('A4:AK4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  $objPHPExcel->getActiveSheet()->getStyle('F3:AK3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  // căn giữa trên dưới
  $objPHPExcel->getActiveSheet()->getStyle('A4:AK4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
  if(!empty($dataExport)){


      // xuất file
      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="BC-doanh-thu-theo-kenh.xls"');
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
