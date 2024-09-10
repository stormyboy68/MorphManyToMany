<?php

namespace ASB\MorphToMany\Builder;

use ASB\MorphToMany\Enum\BasePathMTM;
use ASB\MorphToMany\utility\File;

class RequestBuilder
{
    public static function handle($values)
    {
        extract($values);
        $data = [
            'model' => $model,
            'plural' => $plural,
            'fileName' => sprintf(BasePathMTM::Request, $model) . $model . 'Request.php',
            'txt' => include BasePathMTM::RequestTemplate,
        ];
        return File::handle($data);
    }
}
