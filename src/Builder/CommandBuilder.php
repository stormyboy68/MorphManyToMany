<?php

namespace ASB\MorphToMany\Builder;

use ASB\MorphToMany\Enum\BasePathMTM;
use ASB\MorphToMany\utility\File;

class CommandBuilder
{
    public static function handle($values)
    {
        extract($values);
        $data = [
            'model' => $model,
            'fileName' => sprintf(BasePathMTM::Commands,$model).$model."Command.php",
            'txt' => include BasePathMTM::CommandTemplate,
        ];
        return File::handle($data);
    }
}
