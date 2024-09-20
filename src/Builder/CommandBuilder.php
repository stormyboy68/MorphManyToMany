<?php

namespace ASB\MorphMTM\Builder;

use ASB\MorphMTM\Enum\BasePathMTM;
use ASB\MorphMTM\utility\File;

class CommandBuilder
{
    public static function handle($values)
    {
        extract($values);
        $data = [
            'model' => $model,
            'fileName' => sprintf(BasePathMTM::Commands(),$model).$model."Command.php",
            'txt' => include BasePathMTM::CommandTemplate,
        ];
        return File::handle($data);
    }
}
