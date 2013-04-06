<?php
class Helper_Output
{
    protected $data = null;
    public static function getObjOutput($file, $data = null)
    {
        Helper_Debug::dump(__FILE__, __LINE__);
        $this->data = $data;
        ob_start();
        include_once $file;
        $viewOutput = ob_get_contents();
        exit;
        ob_end_clean();
        return $viewOutput;
    }

    public static function checkError()
    {

    }
}