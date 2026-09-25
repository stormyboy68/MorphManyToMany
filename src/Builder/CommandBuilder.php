<?php

namespace ASB\MorphMTM\Exceptions\Builder;

use ASB\MorphMTM\Exceptions\Enum\BasePathMTM;
use ASB\MorphMTM\Exceptions\utility\File;

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
