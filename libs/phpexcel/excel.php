<?php
$file = dirname(__FILE__) . '/PHPExcel.php';
// excel操作类库
require_once (dirname(__FILE__) . '/PHPExcel.php');
require_once (dirname(__FILE__) . '/PHPExcel/IOFactory.php');
require_once (dirname(__FILE__) . '/PHPExcel/Reader/Excel5.php');
require_once (dirname(__FILE__) . '/PHPExcel/Writer/Excel5.php');

function importExcel($file)
{
    $objReader = PHPExcel_IOFactory::createReader('Excel2007'); // use excel2007 for 2007 format
    $objPHPExcel = $objReader->load($file);
    $sheet = $objPHPExcel->getSheet(0);
    $highestRow = $sheet->getHighestRow(); // 取得总行数
    $highestColumn = $sheet->getHighestColumn(); // 取得总列数
    $objWorksheet = $objPHPExcel->getActiveSheet();
    
    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
    $excelData = array();
    for ($row = 0; $row <= $highestRow; $row ++) {
        for ($col = 0; $col < $highestColumnIndex; $col ++) {
            $excelData[$row][] = (string) $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
        }
    }
    return $excelData;
}

function exportExcel($column, $datalist, $tempdir)
{
    // Create new PHPExcel object
    $objPHPExcel = new PHPExcel();
    
    // Set properties
    
    $objPHPExcel->getProperties()->setCreator("MOT");
    $objPHPExcel->getProperties()->setLastModifiedBy("MOT");
    $objPHPExcel->getProperties()->setTitle("PHP Array To Excel");
    $objPHPExcel->getProperties()->setSubject("ExcelFile");
    $objPHPExcel->getProperties()->setDescription("PHP Array to Excel");
    
    // Add some data
    $objPHPExcel->setActiveSheetIndex(0);
    $basic = 'A';
    foreach ($column as $c) {
        $objPHPExcel->getActiveSheet()->SetCellValue($basic.'1', $c);
        $basic ++;
    }
    
    $max_length = count($datalist) - 1;
    for ($count = 0; $count <= $max_length; $count ++) {
        $basic = 65;
        $num_basic = 65;
        foreach ($datalist[$count] as $key => $d) {
            $basic = $num_basic;
            $basic = big_chr($basic);
            $d = str_replace('=', '_', $d);
            $objPHPExcel->getActiveSheet()->SetCellValue($basic . ($count + 2), $d);
            $num_basic ++;
        }
        $basic = 65;
    }
    
    // $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Hello');
    
    // Rename sheet
    
    $objPHPExcel->getActiveSheet()->setTitle('list');
    
    // Save Excel 2007 file
    $fhandle = opendir($tempdir."/");
    
    while (($file = readdir($fhandle))==true) {
        if (is_file($tempdir."/". $file)) {
            unlink($tempdir."/". $file);
        }
    }
    
    $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
    $filename = $tempdir."/".md5(time()).'.xls';
    echo $filename;
    $objWriter->save($filename);
    
    return $filename;
    // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    // header('Cache-Control: max-age=0');
}

function big_chr($number)
{
    if ($number < 91)
        return chr($number);
    
    $number = $number - 65;
    
    if ($number / 26 >= 1) {
        $size = intval($number / 26);
        
        $prefix = chr(64 + $size);
        
        return $prefix . chr(65 + $number % 26);
    }
}
