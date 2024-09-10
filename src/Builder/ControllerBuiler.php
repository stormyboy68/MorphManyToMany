<?php

namespace ASB\MorphToMany\Builder;

use ASB\MorphToMany\Enum\BasePathMTM;
use ASB\MorphToMany\Utility\File;

class ControllerBuiler
{

    public static function handle($values)
    {
        extract($values);
        $data = [
            'model' => $model,
            'fileName' => sprintf(BasePathMTM::Controller, $model) . $model . "Controller.php",
            'txt' => include  BasePathMTM::ControllerTemplate,
        ];
        return File::handle($data);
    }
}
