<?php

namespace ASB\MorphMTM\Builder;

use ASB\MorphMTM\Enum\BasePathMTM;
use ASB\MorphMTM\Utility\File;

class ProviderBuilder
{
    public static function handle($values)
    {
        extract($values);
        $data = [
            'model' => $model,
            'plural' => $plural,
            'fileName' => sprintf(BasePathMTM::Provider(), $model) . $model . 'ServiceProvider.php',
            'txt' => include BasePathMTM::ProviderTemplate,
        ];
        return File::handle($data);
    }
}
