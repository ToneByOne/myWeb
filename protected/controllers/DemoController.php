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
        $this->_filterDemo();
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
        $filterVal = 1;
        $filterValArr  = array(
            'name'=>array('filter'=>FILTER_SANITIZE_STRING),
            'age'=>array('filter'=>FILTER_VALIDATE_INT,'optionps'=>array('min_range'=>1,'max_range'=>12)),
        );


    }
}