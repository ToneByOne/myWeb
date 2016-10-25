<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 15-12-14
 * Time: 下午4:54
 */
class StrController extends Controller
{
    /**
     * index
     */
    public  function actionIndex()
    {
        $str = "zd11gbbbz";
        //strrchr
//        $text = "Line 1\nLine 2\nLine 3";
//        $last = strrchr($text, 10);
//        var_dump($last);exit;
        //substr
//        var_dump($this->substr($str,4,-1));
//        var_dump(substr($str,0));
        //trim
//        var_dump($str);
//        var_dump($this->trim($str,"s"));
        //strtolower
//        var_dump($str);
//        var_dump($this->strtolower($str));exit;
        //strtoupper
//        var_dump($str);
//        var_dump($this->strtoupper($str));
//        echo strlen($str)."</br>";
//        echo mb_strlen($str,"utf-8")."</br>";
//        var_dump(substr($str,1,7));
//        var_dump(mb_substr($str,1,7,'utf-8'));
        //strpos
//        var_dump($this->strpos($str,'z',2));
//        var_dump(mb_strpos($str,'温',0,'utf8'));
        //strrpos
//        var_dump($this->strrpos($str,'b'));exit;

//        var_dump(ord('a'));
//        var_dump(chr(ord('a')));
//        var_dump(sprintf('%.2f',2.3255));
        //匹配所有符合规则的字符串，以什么开头，什么结尾的
        $str = "afhdgasdasdad";
        $pattern ="/a.{0,}?d/";
        $replacement ="1";
        $return = preg_replace($pattern,$replacement,$str);
        var_dump($return);exit;
    }

    /**
     * strrchr 查找指定字符在字符串最后一次出现
     * @param haystack 在该字符串中查找。
     * @param needle
     * 如果 needle 包含了不止一个字符，那么仅使用第一个字符。该行为不同于 strstr() 。
     * 如果 needle 不是一个字符串，那么将被转化为整型并被视为字符顺序值。
     * @return string/bool
     * 该函数返回 haystack 字符串中的一部分，这部分以 needle 的最后出现位置开始，直到 haystack 末尾。
     */
    private  function strrchr($haystack,$needle)
    {
      return strrchr($haystack,$needle);
    }

    /**
     *substr 返回字符串的子串
     *@param $string  输入字符串。
     *@param $start   开始位置
     *如果 start 是非负数，返回的字符串将从 string 的 start 位置开始，从 0 开始计算。例如，在字符串 “abcdef” 中，在位置 0 的字符是 “a”，位置 2 的字符串是 “c” 等等。
     *如果 start 是负数，返回的字符串将从 string 结尾处向前数第 start 个字符开始。
     *如果 string 的长度小于或等于 start，将返回 FALSE。
     *@param length
     *如果提供了正数的 length，返回的字符串将从 start 处开始最多包括 length 个字符（取决于 string 的长度）。
     *如果提供了负数的 length，那么 string 末尾处的许多字符将会被漏掉（若 start 是负数则从字符串尾部算起）。如果 start 不在这段文本中，那么将返回一个空字符串。
     *如果提供了值为 0，FALSE 或 NULL 的 length，那么将返回一个空字符串。
     *如果没有提供 length，返回的子字符串将从 start 位置开始直到字符串结尾。
     */
    private function substr($string,$start,$length=null)
    {
        if($length)
            return substr($string,$start,$length);
        else
            return substr($string,$start);
    }

    /**
     * trim 除去字符串中首尾处的空白字符（或者其他字符）
     *说明：此函数返回字符串 str 去除首尾空白字符后的结果。如果不指定第二个参数，trim() 将去除这些字符：
     *" " (ASCII 32 (0x20))，普通空格符。
     *"\t" (ASCII 9 (0x09))，制表符。
     *"\n" (ASCII 10 (0x0A))，换行符。
     *"\r" (ASCII 13 (0x0D))，回车符。
     *"\0" (ASCII 0 (0x00))，空字节符。
     *"\x0B" (ASCII 11 (0x0B))，垂直制表符。
     * @param $str       待处理的字符串
     * @param $charlist  可选参数，过滤字符也可由 charlist 参数指定。一般要列出所有希望过滤的字符，也可以使用 “..” 列出一个字符范围。
     * @return 返回值     过滤后的字符串
     */

    private function trim($str,$charlist=null)
    {
        if($charlist)
            return trim($str,$charlist);
        else
            return trim($str);
    }

    /**
     * strtolower  将字符串转化为小写
     * 将 string 中所有的字母字符转换为小写并返回。
     * 注意 “字母” 与当前所在区域有关。例如，在默认的 “C” 区域，字符 umlaut-A（ä）就不会被转换。
     * @param $string 输入的字符串
     * @return string 返回转换后的小写字符串
     */
    private function strtolower($string)
    {
        return strtolower($string);
    }

    /**
     * strtoupper 将所有字母转换为大写字母
     *将 string 中所有的字母字符转换为大写并返回。
     *注意 “字母” 与当前所在区域有关。例如，在默认的 “C” 区域，字符 umlaut-a（ä）就不会被转换。
     * @param $string 输入的字符串
     * @return string 返回转换后的大写字符串。
     */
    private function strtoupper($string)
    {
        return strtoupper($string);
    }

    /**
     *strpos 查找字符串首次出现的位置(对应的不区分大小写的->stripos)
     *@param string haystack 在该字符串中进行查找
     *@param mix needle 如果 needle 不是一个字符串，那么它将被转换为整型并被视为字符的顺序值。
     *@param int offset 如果提供了此参数，搜索会从字符串该字符数的起始位置开始统计。和 strrpos()、 strripos()不一样，这个偏移量不能是负数
     */
    private function strpos($haystack,$needle,$offset = null)
    {
        return strpos($haystack,$needle,$offset);
    }

    /**
     * strrpos 计算指定字符串在目标字符串中最后一次出现的位置(对应的不区分大小写的->strripos)
     * @param  string $haystack 在此字符串中进行查找。
     * @param  mix    $needle  如果 needle不是一个字符串，它将被转换为整型并被视为字符的顺序值。
     * @param  int    $offset  或许会查找字符串中任意长度的子字符串。负数值将导致查找在字符串结尾处开始的计数位置处结束。
     */
    private function strrpos($haystack,$needle,$offset = null)
    {
        return strrpos($haystack,$needle,$offset);
    }
}
