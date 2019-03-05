<?php
  require("PHPExcel/PHPExcel.php");
  $objPHPExcel = new PHPExcel();
  $objPHPExcel->setActiveSheetIndex(0);

  $mergeCells=array(
    'A4:A6','B4:B6','C4:C6','D4:D6'
  );
  foreach ($mergeCells as $key => $value) {
    $objPHPExcel->getActiveSheet()->mergeCells($value);
  }

  // Thiết lập border
  $objPHPExcel->getActiveSheet()->getStyle('A4:H6')->applyFromArray(
      array(
          'borders' => array(
              'allborders' => array(
                  'style' => PHPExcel_Style_Border::BORDER_THIN,
                  'color' => array('argb' => '000000'),
              )
          ),
          'font' => array(
              'size' => 10,
              'bold' => true,
              'color' => array('rgb' => '000000')
          )
      )
  );

  // Thiết lập background
  $objPHPExcel->getActiveSheet()->getStyle('A4:H6')->applyFromArray(
      array(
          'fill' => array(
              'type' => PHPExcel_Style_Fill::FILL_SOLID,
              'color' => array('rgb' => 'eeeeee')
          )
      )
  );

  //  Thiết lập định dạng Đơn giá vận chuyển gõ tay
  $style = array(
      'font' => array(
          'size' => 10,
          'bold' => true,
          'color' => array('rgb' => 'ff0000')
      ),
      'borders' => array(
          'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN,
              'color' => array('argb' => '000000'),
          )
      )
  );
  // $objPHPExcel->getActiveSheet()->getStyle('R2:V2')->applyFromArray($style);
  // $objPHPExcel->getActiveSheet()->getStyle('R2:V2')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
  // $objPHPExcel->getActiveSheet()->getStyle('R2:V2')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
  // // căn giữa 2 bên
  // $objPHPExcel->getActiveSheet()->getStyle('A3:AJ6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  // // căn giữa trên dưới
  // $objPHPExcel->getActiveSheet()->getStyle('A3:AJ6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

  $setWrapText=array(
    'A4','B4','C4','D4','E4','E5','E6'
  );
  foreach ($setWrapText as $key => $value) {
    $objPHPExcel->getActiveSheet()->getStyle("$value")->getAlignment()->setWrapText(true);
  }
  $fields=array('code','name');
  $listProduct = $modelProduct ->find('all',array('fields'=>$fields));
  $countProduct=count($listProduct);
  pr($listProduct);
  die(); 
  $setCellValue=array(
     'A1'=> 'Bảng giá sản phẩm tại từng điểm máy',
     'A2'=> 'Giá bán bao gồm thuế GTGT 10%',
     'A4'=> 'Mã điểm máy',
     'B4'=> 'Tên điểm máy',
     'C4'=> 'Tên kho điểm',
     'D4'=> 'Kênh',
     'E4'=> 'Mã sản phẩm',

     'E5'=> 'Ngày bắt đầu',
     'E6'=> 'Tên sản phẩm',
  );
  $row=4;
  // $col=7;
  foreach ($setCellValue as $key => $value) {
    $objPHPExcel->getActiveSheet()->setCellValue("$key", "$value");
  };
  for ($col=5; $col <$countProduct +5 ; $col++) { 
    for ($i=0; $i < 5 ; $i++) { 
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$listProduct[$i]['Product']['code']);
    }
    
  }
  // foreach ($setCellValue as $key => $value) {
  //        'F4'=> $listProduct[0]['Product']['code'],
  //        $objPHPExcel->getActiveSheet()->setCellByColumnAndRow();
  // }
  

  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment;filename="bao-cao-theo-gia-ban-sp.xls"');
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

?>