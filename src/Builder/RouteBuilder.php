<?php

namespace ASB\MorphToMany\Builder;

use ASB\MorphToMany\Enum\BasePathMTM;
use ASB\MorphToMany\Utility\File;

class RouteBuilder
{
    public static function handle($values)
    {
        extract($values);
        $data = [
            'model' => $model,
            'plural' => $plural,
            'relationName' => $relationName,
            'fileName' => sprintf(BasePathMTM::Route, $model) . 'routes.php',
            'txt' => include BasePathMTM::RouteTemplate,
        ];
        return File::handle($data);
    }
}
