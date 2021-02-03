<?php


class helper
{
    static function redirect($url){
        if ($url){
            if (!headers_sent()){
                header("Location:".$url);
            }else{
                echo '<script>location.href="'.$url.'"</script>';
            }
        }
    }
    static function cleaner($text){
        $array = array("select", "insert", "update", "union", "*");
        $text = str_replace($array, $text);
        $text = strip_tags($text);
        $text = trim($text);
        return $text;
    }
}