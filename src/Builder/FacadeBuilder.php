<?php

namespace ASB\MorphMTM\Builder;

use ASB\MorphMTM\Enum\BasePathMTM;
use ASB\MorphMTM\utility\File;

class FacadeBuilder
{
    public static function handle($values)
    {
        $values['plural']=ucfirst($values['plural']);
        extract($values);
        $data = [
            'model' => $model,
            'fileName' => sprintf(BasePathMTM::Facade(), $model).BasePathMTM::Prefix."$model.php",
            'txt' => include  BasePathMTM::FacadeTemplate,
        ];
        return File::handle($data);
    }
}
