<?php
  require("PHPExcel/PHPExcel.php");
  $objPHPExcel = new PHPExcel();
  $objPHPExcel->setActiveSheetIndex(0);
  // gộp ô
  $merge=[
    'A3:A6',
    'B3:B6',
    'C3:C6',
    'D3:D6',
    'E3:E6',
    'F3:F6',
    'G3:G6',
    'H3:H6',
    'I3:I5',
    'J3:J5',
    'K3:K5',
    'L3:L5',
    'M3:M5',
    'N3:Q3',
    'W3:W4',
    'X3:AB3',
    'AC3:AE3',
    'AF3:AJ3'
  ];
  // Tiêu đề đầu trang
  $cellVal=array(
    'A1'=>'BẢNG THEO DÕI GIÁ HÀNG MUA',
    'A3'=>'STT',
    'B3'=>'Ngày bắt đầu',
    'C3'=>'Mã sản phẩm',
    'D3'=>'Sản phẩm',
    'E3'=>'Bao bì',
    'F3'=>'Dung tích or trọng lượng',
    'G3'=>'Số SP/thùng',
    'H3'=>'NCC',
    'I3'=>'Giá nhập/thùng (bao gồm thuế)',
    'J3'=>'Giá nhập/SP (bao gồm thuế)',
    'K3'=>'Thuế suất',
    'L3'=>'Giá nhập/SP (ko bao gồm thuế)',
    'M3'=>'Mức CK trực tiếp',
    'N3'=>'Tổng chiết khấu ko bao gồm thuế',
    'N4'=>'Tổng chiết khấu trực tiếp (156)',
    'O4'=>'Tổng chiết khấu trả sau (632)',
    'P4'=>'Tổng doanh thu CCDV (5113)',
    'Q4'=>'Tổng thu nhập khác (711)',
    'R1'=>'Đơn giá vận chuyển gõ tay',
    'R2'=>'10000',
    'S2'=>'10000',
    'T2'=>'8500',
    'U2'=>'7000',
    'V2'=>'7700',
    'R3'=>'CPVC',
    'S3'=>'CPVC',
    'T3'=>'CPVC',
    'U3'=>'CPVC',
    'V3'=>'CPVC',
    'R4'=>'HCM',
    'S4'=>'Hội Sở',
    'T4'=>'Cần Thơ',
    'U4'=>'Huế',
    'V4'=>'Đà Nẵng',
    'W3'=>'GV Mua - Chỉ bao gồm giá mua - CK trực tiếp',
    'X3'=>'GV chiết khấu ( bao gồm DTQC, CK, CF VC, thưởng..)',
    'X4'=>'HCM',
    'Y4'=>'Hội Sở',
    'Z4'=>'Cần Thơ',
    'AA4'=>'Huế',
    'AB4'=>'Đà Nẵng',
    'AC3'=>'Phân bổ chi phí (im port và gõ tay)',
    'AC4'=>'CF BH',
    'AD4'=>'CF QL',
    'AE4'=>'Lãi vay',
    'AF3'=>'Giá bán hòa vốn (tự động cộng)',
    'AF4'=>'HCM',
    'AG4'=>'Hội Sở',
    'AH4'=>'Cần Thơ',
    'AI4'=>'Huế',
    'AJ4'=>'Đà Nẵng'
    );
    $wrap=['B3','C3','D3','F3','G3','I3','J3','K3','L3','M3','N4','O4','P4','Q4','W3','AC3'];
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
    // Thiết lập border
  $objPHPExcel->getActiveSheet()->getStyle('A3:AJ6')->applyFromArray(
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
  $objPHPExcel->getActiveSheet()->getStyle('A3:AJ6')->applyFromArray(
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
          'color' => array('rgb' => 'ff0000') //định dạng mã màu theo rgb.
      ),
      'borders' => array(
          'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN,
              'color' => array('argb' => '000000'), //định dạng mã màu theo argb.
          )
      )
  );
  $objPHPExcel->getActiveSheet()->getStyle('R2:V2')->applyFromArray($style);
  // $objPHPExcel->getActiveSheet()->getStyle('R2:V2')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
  // $objPHPExcel->getActiveSheet()->getStyle('R2:V2')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
  // căn giữa 2 bên
  $objPHPExcel->getActiveSheet()->getStyle('A3:AJ6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  // căn giữa trên dưới
  $objPHPExcel->getActiveSheet()->getStyle('A3:AJ6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);


  //$listDataProduct= $modelProduct->find('all',array('conditions'=>array(),'limit'=>15));
  $dataExport=$modelProduct->find('all',array('conditions'=>$conditions,'order'=>array('created'=>'DESC')));

  if(!empty($dataExport)){
    $i=1;
    $j=$i+6;
    foreach ($dataExport as $key => $value) {
      $objPHPExcel->getActiveSheet()->setCellValue("A$j", $i);
      $objPHPExcel->getActiveSheet()->setCellValue("C$j", $value['Product']['code']);
      $objPHPExcel->getActiveSheet()->setCellValue("D$j", $value['Product']['name']);
      $objPHPExcel->getActiveSheet()->getStyle("D$j")->getAlignment()->setWrapText(true);
      $i++;
      $j++;
    }
    //  Thiết lập định dạng border body
    $styleBody = array(
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('argb' => '000000'),
            )
        )
    );
    --$j;
    $objPHPExcel->getActiveSheet()->getStyle("A7:AJ$j")->applyFromArray($styleBody);
    // foreach(range('A','AJ') as $column) {
    //     $objPHPExcel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
    // }
    // xuất file
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="BC-bang-gia-nhap-SP.xls"');
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
