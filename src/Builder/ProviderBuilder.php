<?php

namespace ASB\MorphToMany\Builder;

use ASB\MorphToMany\Enum\BasePathMTM;
use ASB\MorphToMany\Utility\File;

class ProviderBuilder
{
    public static function handle($values)
    {
        extract($values);
        $data = [
            'model' => $model,
            'plural' => $plural,
            'fileName' => sprintf(BasePathMTM::Provider, $model) . $model . 'ServiceProvider.php',
            'txt' => include BasePathMTM::ProviderTemplate,
        ];
        return File::handle($data);
    }
}
