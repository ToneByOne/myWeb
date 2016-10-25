<?php
/**
 * regex useing
 * @author tangjf 2016-6-13
 */
class RegexController extends Controller
{
    /**
     * the index is the default in method(action)
     * @author tangjf 2016-6-13
     */
    public function actionIndex()
    {
        $this->case1();

        $this->case2();

        $this->case3();
    }

    /**
     * 查找1
     */
    protected function  case1()
    {
        $string = '123 abc aaaaa';
        preg_match_all('#abc.*#',$string,$returnArr);
        var_dump($returnArr);
    }

    /**
     * 查找2
     */
    protected function case2()
    {
        $string = 'asdadasdasd123asdasfasfasf456afasdasd789asdaggrht';
        preg_match_all('#([0-9])([0-9])([0-9])#',$string,$returnArr);
        var_dump($returnArr);
        $retrun = preg_replace('#([0-9])([0-9])([0-9])#','[\1\2\3]',$string);
        var_dump($retrun);
    }

    /**
     *身份证验证
     */
    protected function case3()
    {
        $string = '45090219901025311x';
        preg_match('/^\d{14}(\d{1}|[0-9]{3}(\d|x|X))$/',$string,$returnArr);
        var_dump($returnArr);exit;
        if($returnArr)
            var_dump($returnArr);
        else
            var_dump('fail');
    }

}