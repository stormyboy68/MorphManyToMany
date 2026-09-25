<?php

namespace ASB\MorphMTM\Exceptions\Builder;

use ASB\MorphMTM\Exceptions\Enum\BasePathMTM;
use ASB\MorphMTM\Exceptions\Utility\File;

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
