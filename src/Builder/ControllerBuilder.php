<?php

namespace ASB\MorphMTM\Builder;

use ASB\MorphMTM\Enum\BasePathMTM;
use ASB\MorphMTM\Utility\File;

class ControllerBuilder
{

    public static function handle($values)
    {
        extract($values);
        $data = [
            'model' => $model,
            'fileName' => sprintf(BasePathMTM::Controller(), $model) . $model . "Controller.php",
            'txt' => include  BasePathMTM::ControllerTemplate,
        ];
        return File::handle($data);
    }
}
