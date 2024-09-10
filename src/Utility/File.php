<?php

namespace ASB\MorphToMany\Utility;

class File
{

    public static function handle($data)
    {
        $myFile = fopen($data['fileName'], "w");
        if (!$myFile) {
            return $myFile;
        }
        fwrite($myFile, $data['txt']);
        return fclose($myFile);
    }


}
