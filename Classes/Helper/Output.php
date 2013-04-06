<?php
class Helper_Output
{
    public static function getObjOutput($file)
    {
        ob_start();
        include_once $file;
        $viewOutput = ob_get_contents();
        ob_end_clean();
        return $viewOutput;
    }

    public static function checkError()
    {

    }
}