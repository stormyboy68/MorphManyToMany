<?php

namespace ASB\MorphMTM\Builder;

use ASB\MorphMTM\Enum\BasePathMTM;
use ASB\MorphMTM\utility\File;

class ModelBuilder
{
    public static function handle($values)
    {
        extract($values);
        $data=[
            'model'=>$model,
            'plural'=>$plural,
            'fileName'=> sprintf(BasePathMTM::Model(), $model).$model.'.php',
            'txt' => include BasePathMTM::ModelTemplate,
        ];
        return File::handle($data);
    }

}
