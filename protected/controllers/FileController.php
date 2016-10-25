<?php
/**
 * file processing
 * Created by PhpStorm.
 * User: Administrator
 * Date: 15-11-2
 * Time: 下午4:48
 */
class FileController extends Controller
{
    /**
     * upload action
     * @author tangjf 2015-10-23
     */
    public function actionUpload(){
        //get file data
        $files = $_FILES['file'];

        //源文件名
        $fileName = $files['name'];
        //临时文件路径
        $fileTmpPath = $files['tmp_name'];

        //获取文件后缀名
        $ext = strtolower(trim(substr(strrchr($files['name'],'.'),0)));
        //重定义保存目录
        $rePath = 'content/tmpFile/upload/';

        //创建多级目录
        //兼容php4.0
//        $this->mkDirs($rePath);
        //普通形式
        if(!file_exists($rePath)){
            if(!@mkdir($rePath,0777,true))
                echo '创建目录失败！';
            //兼容umask系统
            chmod($rePath,0777);
        }
        //文件路径名
        $reName = $rePath.time().$ext;
        //复制临时文件到指定目录
        $copyStatus = copy($fileTmpPath,$reName);
        var_dump($copyStatus);exit;
        exit();
    }

    public function actionDeleteDir(){
        //打开文件目录
        $dir = "content/tmpFile/upload";
        $this->deleteDir($dir,true);

    }

    /**
     * download file
     */
    public function actionDownLoad()
    {
        $downPath = 'content/tmpFile/upload/（P18）广东省红色旅游示范基地名单.doc';
        $this->downLoad($downPath);

    }

    /**生成多级目录
     * @param $dir
     * @return bool
     */
    protected  function mkDirs($dir){
        if(!is_dir($dir)){
            if(!$this->mkDirs(dirname($dir))){
                return false;
            }
            if(!@mkdir($dir,0777)){
                return false;
            }
            @chmod($dir,0777);
        }
        return true;
    }

    /**
     * delete dir or file
     * @param string $dir
     * @param bool   $isDelDir
     */
    public function deleteDir($dir,$isDelDir = false)
    {
        $dirHandle  = @opendir($dir);
        //列出文件目录中的文件
        while (($file = readdir($dirHandle)) !== false)
        {
            if($file!='.' && $file!='..')
            {
                $fileName = $dir.'/'.$file;
                if(is_dir($fileName))
                    $this->deleteDir($fileName);
                else
                    @unlink($fileName);
            }
        }
        closedir($dirHandle);
        //删除目录
        if($isDelDir)
            return rmdir($dir);
    }

    /**
     * download funtion
     * @param string $path down path
     */
    protected function downLoad($path)
    {
        header("Content-Type:text/html;charset=utf-8");
        //兼容中文格式文件路径
        $fileName = iconv('utf-8','gb2312',$path);

        file_exists($fileName) or die('The file is not exist');

        $downName = basename($fileName);
        $fileSize = filesize($fileName);
        if(ob_get_length() !== false) @ob_end_clean();
        //消息请求头
        header("Content-type: application/octet-stream");
        header("Accept-Ranges: bytes");
        header("Accept-Length: ".$fileSize);
        header("Content-Disposition: attachment; filename=$downName");

        //读取文件
        $fp= fopen($fileName,'r+') or die('can not find file');
        $buffer = 1024;
        $bufferTotal = $buffer;
        while(!feof($fp) && $bufferTotal<=$fileSize)
        {
            echo fread($fp,$buffer);
            $bufferTotal+=$buffer;
        }
        fclose($fp);
    }

    /**
     * 生成doc文件
     *
     */
    public function actionCreateDoc()
    {
        $savePath = 'content/tmpFile';
        file_exists($savePath) or $this->mkDirs($savePath);

        $fileName = $savePath.'/create.doc';
//        file_exists($fileName) and @unlink($fileName);

        $docContent ='
        <html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:w="urn:schemas-microsoft-com:office:word" xmlns="http://www.w3.org/TR/REC-html40">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title>报名表格</title>
        </head>

        <body>
        <div style="font-size:30px; text-align:center; font-weight:800">真的库了啊啊是的那是</div>
        <div style="text-align:center;">姓名：qwqwq1</div>
        <div style="text-align:center;">指导老师:22qwqw22</div>
        <div style="text-align:center;">设计的空间啊上看到啊手机打开实打实的静安寺</div>
        <div style="">按理说没电了；啊速度快我去卡速度卡视频打卡上扩大斯柯达上看到阿斯顿卡死单卡双卡大赛大盘是空间的安排开始的爱普生【打开a</div>

        </body>
        </html> ';

        $fp = fopen($fileName,'w') or die('the file is not exsit!');
        if(fwrite($fp,$docContent) && fclose($fp));
            exit('创建doc成功！');

    }


    /**
     * 根据生成统计文件
     * @author tangjf 2015-11-3
     */
    public function actionCreateExcel(){
        $filePath="content/tmpFile/";
        $fileName= iconv('utf-8','gb2312','kpanswerstat.xlsx');
        file_exists($filePath) or mkdir($filePath,0777,true);
        file_exists($filePath.$fileName) and @unlink($filePath.$fileName);

        $dataArr = array(array('鱼','竞赛'),array('sh','ss'),array('你好' ,'你好'));
        $this->createExcels($dataArr,$filePath.$fileName);//生成文件
        return $filePath.$fileName;
    }
    /**
     * 生成excel 文件
     * @param $arr
     * @param $file
     * @author tangjf 2015-11-3
     */
    private function createExcels(){
        include_once('protected/extensions/phpexcel/PHPExcel.php');
        include_once('protected/extensions/phpexcel/PHPExcel/Style/Font.php');
        include_once('protected/extensions/phpexcel/PHPExcel/Writer/Excel2007.php');
        include_once('protected/extensions/phpexcel/PHPExcel/IOFactory.php');

        $objPHPExcel = new PHPExcel();
        $objStyle = new PHPExcel_Style_Font();
        $objStyle->setName('宋体');

        $properties = $objPHPExcel->getProperties();
        $properties->setCreator("www.1024i.com");
        $properties->setLastModifiedBy("www.loubarnes.com");
        $properties->setTitle("PHP 生成 Excel");
        $properties->setSubject("PHP 生成 Excel");
        $properties->setDescription('PHP 生成 Excel');
        $properties->setKeywords("PHP 生成 Excel");
        $properties->setCategory("PHP 生成 Excel");

        $objPHPExcel->setActiveSheetIndex(0);
        $active_sheet = $objPHPExcel->getActiveSheet();

        $active_sheet->setTitle('用户');
        // 自动调节大小
        $active_sheet->getColumnDimension('A')->setWidth(8);
        $active_sheet->getColumnDimension('B')->setWidth(12);
        $active_sheet->getColumnDimension('C')->setWidth(8);
        $active_sheet->getColumnDimension('D')->setWidth(8);
        $active_sheet->getColumnDimension('E')->setWidth(24);
        $active_sheet->getColumnDimension('F')->setWidth(60);

        $active_sheet->setCellValue('A1', 'PHP 生成 Excel 示例' );
        $active_sheet->mergeCells('A1:F1');	// 合并表头单元格
        $active_sheet->getRowDimension(1)->setRowHeight(30);	// 设置表头1高度
        $style = array(
            'font' => array(
                'size' => 20,
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
                'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $active_sheet->getStyle('A1:F1')->applyFromArray($style);	// 设置表头1样式



        $active_sheet->getRowDimension(2)->setRowHeight(30);	// 设置表头2高度
        // 设置表头2名称
        $active_sheet->setCellValue('A2', '编号');
        $active_sheet->setCellValue('B2', '名称');
        $active_sheet->setCellValue('C2', '性别');
        $active_sheet->setCellValue('D2', '年龄');
        $active_sheet->setCellValue('E2', '出生日期');
        $active_sheet->setCellValue('F2', '备注');



        // 表头(编号, 名称, 性别, 出生日期)样式
        $style = array(
            'font' => array(
                'bold' => true,
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
                'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            ),

        );
        $active_sheet->getStyle('A2:E2')->applyFromArray($style);

        // 表头(备注)样式
        $style = array(
            'font' => array(
                'bold' => true,
            ),
            'borders' => array(
                'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $active_sheet->getStyle('F2')->applyFromArray($style);
        // 内容样式
        $style = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );
//        $arr = array(PHPExcel_Cell_DataType::checkString('45454654654654544646464'));
//        $active_sheet->fromArray($arr);

        $active_sheet->setCellValueExplicit('B24','123456789123456789',PHPExcel_Cell_DataType::TYPE_STRING);
        $active_sheet->getStyle('B24')->getNumberFormat()->setFormatCode("@");

        $active_sheet->getStyle('A:E')->applyFromArray($style);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'pdf');
        $objWriter->save('table.pdf');
    }

    /**
     *execl表导入数据到数据库(案例)
     *
     */
    public function actionImportExcelToDB()
    {
        include_once('protected/extensions/phpexcel/PHPExcel.php');
        include_once('protected/extensions/phpexcel/PHPExcel/Style/Font.php');
        include_once('protected/extensions/phpexcel/PHPExcel/Writer/Excel2007.php');
        include_once('protected/extensions/phpexcel/PHPExcel/IOFactory.php');
        $filePath = Yii::getPathOfAlias('webroot')."/content/wf.xlsx";

        if(!file_exists($filePath)) {
            throw new Exception('The file named wf.xlsx is not exist');
        }

        $objReader   = PHPExcel_IOFactory::createReader('Excel2007');//use excel2003 和  2007 format
        $objPHPExcel = PHPExcel_IOFactory::load($filePath);
        if(!$objPHPExcel) {
            throw new Exception('load phpexcel failed');
        }

        $sheet = $objPHPExcel->getSheet(0);
        $totalColumn = $sheet->getHighestColumn(); // 取得总行数

//        var_dump($totalRow);exit;
        $totalRow = $sheet->getHighestRow(); // 取得总行数
        if($totalRow>1){
            for ($row = 2; $row <= $totalRow; $row++) {
                $contentID = $sheet->getCell('A'.$row)->getValue();
                $wfwkID = $sheet->getCell('B'.$row)->getValue();
                $address = $sheet->getCell('C'.$row)->getValue();
                if($address == '') continue;
                echo 'contentID:'.$contentID;
                $return = WeikeService::factory()->updateWfWKFile($contentID,$wfwkID,$address);
                echo $return."</br>";
            }
        }else{
            echo 'nodata';
        }
        exit();
    }


    /**
     * @param $num
     * @return mixed
     */
    public function num2letter($num)
    {
        $letter = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
        return $letter[$num];
    }

   public function convertUTF8($str)
    {
        if(empty($str)) return '';
        return  iconv('gbk', 'utf-8', $str);
    }



    /**
     * upload file
     * @author tangjf 20116-5-31
     */
    public function actionUploadFile()
    {

    }

}