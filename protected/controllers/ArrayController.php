<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 16-1-9
 * Time: 上午9:31
 */
class ArrayController extends Controller
{

    /**
     * index
     */
    public function actionIndex()
    {
        $array1 = array('a'=>1,'b'=>2);
        $array2 = array(1,2,3);
        $string = 'aaaa,aaaaaaaa,aaaaaa';
        $type = 5;
        $value2 = 10;
//        //is_array
//        var_dump(is_array($array1));
//        //in_array
//        var_dump(in_array(1,$array2));
//        //explode
//        var_dump(explode(',',$string));
//        //implode
//        var_dump(implode('hello',$array1));
        //array_map
        $arr = array_map(function($value) use($type,$value2){
            return $value * $type * $value2;
        },$array1);

        var_dump($arr);exit;

        $fruits = array("d" => "lemon", "a" => "orange", "b" => "banana", "c" => "apple");

        function test_alter(&$item1, $key, $prefix)
        {
            $item1 = "$prefix: $item1";
        }

        function test_print($item2, $key)
        {
            echo "$key. $item2<br />\n";
        }

        echo "Before ...:<br>";
        array_walk($fruits, 'test_print');

        array_walk($fruits, 'test_alter', 'fruit');
        var_dump($fruits);
        echo "... and after:<br>";

        array_walk($fruits, 'test_print');
        var_dump($fruits);
    }
}