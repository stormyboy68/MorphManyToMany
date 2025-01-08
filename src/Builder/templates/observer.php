<?php
return
'<?php' . "
namespace Rack\\Morph\\MTM\\$model\\App\\Observers;

use Rack\Morph\MTM\\$model\App\Models\\$model;

class ".$model."Observer
{
    /**
     * Handle the Type \"created\" event.
     */
    public function created($model $".lcfirst($model)."): void
    {
        ".(!$uuid?"":
         "if (empty(\$".lcfirst($model)."->id)) {
            $".lcfirst($model)."->id = (string)\Illuminate\Support\Str::uuid();
        }"
         )."
    }

    /**
     * Handle the Type \"updated\" event.
     */
    public function updated($model $".lcfirst($model)."): void
    {

    }

    /**
     * Handle the Type \deleted\" event.
     */
    public function deleted($model $".lcfirst($model)."): void
    {

    }

    /**
     * Handle the Type \"restored\" event.
     */
    public function restored($model $".lcfirst($model)."): void
    {

    }

    /**
     * Handle the Type \"force deleted\" event.
     */
    public function forceDeleted($model $".lcfirst($model)."): void
    {

    }
}";

