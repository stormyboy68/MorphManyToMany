<?php

namespace ASB\MorphMTM\Exceptions\Builder;

use ASB\MorphMTM\Exceptions\Enum\BasePathMTM;
use ASB\MorphMTM\Exceptions\Utility\File;

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
