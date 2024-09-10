<?php
return
'<?php'."
namespace Rack\\MTM\\$model\\Traits;

use Rack\\MTM\\$model\\App\\Models\\$model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait Has$model
{
    public function $plural(): MorphToMany
    {
        return \$this->morphToMany($model::class, '$relationName','$pluralRelation');
    }
}";
