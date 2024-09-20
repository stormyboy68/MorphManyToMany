<?php

namespace ASB\MorphMTM\Builder;

use ASB\MorphMTM\Enum\BasePathMTM;
use ASB\MorphMTM\utility\File;

class RequestBuilder
{
    public static function handle($values)
    {
        extract($values);
        $data = [
            'model' => $model,
            'plural' => $plural,
            'fileName' => sprintf(BasePathMTM::Request(), $model) . $model . 'Request.php',
            'txt' => include BasePathMTM::RequestTemplate,
        ];
        return File::handle($data);
    }
}
