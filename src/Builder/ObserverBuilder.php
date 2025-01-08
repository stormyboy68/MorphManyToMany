<?php

namespace ASB\MorphMTM\Builder;

use ASB\MorphMTM\Enum\BasePathMTM;
use ASB\MorphMTM\Utility\File;

class ObserverBuilder
{
    public static function handle($values)
    {
        extract($values);
        $data=[
            'model'=>$model,
            'plural'=>$plural,
            'fileName'=> sprintf(BasePathMTM::Observer(), $model).$model.'Observer.php',
            'txt' => include BasePathMTM::ObserverTemplate,
        ];
        return File::handle($data);
    }
}
