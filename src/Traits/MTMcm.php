<?php
namespace ASB\MorphMTM\Traits;

use ASB\MorphMTM\Utility\AsbClassMap;

trait MTMcm
{
    public function __construct()
    {
        AsbClassMap::handler(self::class);
    }
}
