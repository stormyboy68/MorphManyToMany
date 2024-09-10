<?php
namespace ASB\MorphToMany\Traits;

use ASB\MorphToMany\Utility\AsbClassMap;

trait MTMcm
{
    public function __construct()
    {
        AsbClassMap::handler(self::class);
    }
}
