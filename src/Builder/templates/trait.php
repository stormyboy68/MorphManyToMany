<?php
return
'<?php'."
namespace Rack\\Morph\\MTM\\$model\\Traits;

use Rack\\Morph\\Traits\\HasMtmModel;
use Rack\\Morph\\MTM\\$model\\App\\Models\\$model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait Has$model
{
    public function $plural(): morphToMany
    {
        return \$this->morphToMany($model::class, '$relationName','$pluralRelation');
    }
}";
