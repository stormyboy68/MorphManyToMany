<?php
return '<?php'."

namespace Rack\\Morph\\MTM\\$model\\Facades;

use Rack\\Morph\\MTM\\$model\\App\\Models\\$model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * @method static Collection getModelsHave(string \$$model) it gets all the models that have $model.
 *
 * @method static Collection get$plural(Model \$model,bool|string \$pluck = false) it gets all the ".ucfirst($plural)." of Model.
 *
 * @method static boolean has$model(Model \$model,string|int \$$model) it checks the Model has this $model by Title or ID.
 *
 * @method static mixed assign$model(Model \$model,string|int \$$model) it assigns a $model to the Model by Title or ID.
 *
 * @method static mixed add$model(Model \$model,string|int \$$model) it adds a ".$model." to the Model by Title or ID.
 * @method static mixed update$model(Model \$model,string|int \$$model,string|int \$new$model) it updates a $model from the Model and replace by new $model Or a $model that exists.
 * @method static mixed remove$model(Model \$model,string|int \$$model) it removes a $model from the model by Title or ID.
 * @method static mixed removeAll$model(Model \$model) it removes all $plural from the model.
 *
 * @method static bool create".$model."Model(string \$$model) it Creates a $model by a new Title.
 * @method static Collection getAll".$model."Model(bool \$onlyTrashed=false) it gets all of $model And if it is called with \"true\" parameter, it will get all the deleted $model.
 * @method static $model|Model|null get".$model."Model(string|int \$$model)  it gets a $model by Title or ID.
 * @method static bool update".$model."Model(string|int \$$model, string \$update_$model) updates a $model by Title or ID and replace by a new Title.
 * @method static boolean remove".$model."Model(int|string \$$model) it removes a $model by Title or ID and removing the $model and from all Models.
 * @method static boolean restore".$model."Model(int|string \$$model) it restored a $model by Title or ID.
 */
class MTM$model extends Facade
{
    protected static function getFacadeAccessor():string
    {
            return 'MTM$model';
    }
}
";
