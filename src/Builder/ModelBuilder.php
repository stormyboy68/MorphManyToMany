<?php

namespace ASB\MorphToMany\Builder;

use ASB\MorphToMany\Enum\BasePathMTM;
use ASB\MorphToMany\utility\File;

class ModelBuilder
{
    public static function handle($values)
    {
        extract($values);
        $data=[
            'model'=>$model,
            'plural'=>$plural,
            'fileName'=> sprintf(BasePathMTM::Model, $model).$model.'.php',
            'txt' => include BasePathMTM::ModelTemplate,
        ];

        return File::handle($data);
    }

}
