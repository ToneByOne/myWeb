<?php

class DemoController extends Controller
{
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{

        //filter
//        $this->_filterDemo();

        //exception
//        $this->_demoException();

        //error_log
        $this->_errorLogDemo();
	}

    /**
     * filter
     * @author tangjf 2016-10-14
     */
    private function _filterDemo()
    {
        //filter_var()
        $filterVal = "1D1sgsgsgs";
        $returnVal = filter_var($filterVal,FILTER_VALIDATE_INT,array('options'=>array('min_range'=>1,'max_range'=>12)));
        var_dump("FILTER_VALIDATE_INT:".$returnVal);

        $returnVal = filter_var($filterVal,FILTER_SANITIZE_NUMBER_INT);
        var_dump("FILTER_SANITIZE_NUMBER_INT:".$returnVal);

        //filter_var_array()
        $filterVal = array('name'=>"skjhdkja555",'age'=>13);
        $filterValArr  = array(
            'name'=>array('filter'=>FILTER_SANITIZE_STRING),
            'age'=>array('filter'=>FILTER_VALIDATE_INT,'options'=>array('min_range'=>1,'max_range'=>12)),
        );

        $returnVal = filter_var_array($filterVal,$filterValArr);
        var_dump($returnVal);

        //filter_var;
        //filter_input_array();


    }

    /**
     * Custom exception function
     *
     */
    public function customException($exception){
        var_dump($exception);
    }

    /**
     * exception
     */
    private function _demoException()
    {
        set_exception_handler(array($this,'customException'));
        $val = 1;
        try
        {
            if ($val > 0) {
                throw new Exception('Exception is sadak');
            }
        }
        catch(Exception $e){
            echo $e->getMessage();
        }

    }


    /**
     * error
     */
    private function _errorLogDemo(){
        //服务器日志
        $returnVal =  error_log('服务器日志!');
        var_dump($returnVal);

        //发送到邮箱
        $returnVal = $this->sendEmail('1033168036@qq.com','发送到邮箱的错误日志','把手搭开始的');
        var_dump($returnVal);
    }


    /**
     * 邮件发送函数
     *
     * @param $email    接收方邮件地址
     * @param $content  邮件正文
     * @param $subject  邮件标题
     * @return bool     true-发送成功   false-发送失败
     */
    public static function sendEmail($email,$content,$subject){
        date_default_timezone_set("PRC");
        $mail = Yii::createComponent('application.extensions.mailer.EMailer');
        $mail->IsSMTP();	// set mailer to use SMTP
        $mail->Port = 25;
        $mail->CharSet = 'utf-8';
        $mail->Host = 'smtp.exmail.qq.com';	 // 指定主和备份服务器
        $mail->SMTPAuth = false;     // 启动SMTP验证
        $mail->Username = '';  // SMTP 用户名
        $mail->Password = ''; // SMTP 密码
        $mail->From = '1033168036@qq.com';	// 发件人邮箱地址
        $mail->FromName = '1033168036@qq.com';			//发件人姓名
        $mail->AddAddress($email);       // 收件人地址和姓名
        $mail->Subject = $subject;
        $mail->MsgHTML($content);
        return $mail->Send();
    }

}
