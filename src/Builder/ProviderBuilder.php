<?php

namespace ASB\MorphMTM\Exceptions\Builder;

use ASB\MorphMTM\Exceptions\Enum\BasePathMTM;
use ASB\MorphMTM\Exceptions\Utility\File;

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
