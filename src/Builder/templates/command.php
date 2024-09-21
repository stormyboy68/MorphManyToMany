<?php
return
'<?php'."

namespace Rack\\Morph\\MTM\\$model\\App\\Commands;

use Rack\\Morph\\MTM\\$model\\App\\Models\\$model;
use Rack\\Morph\\MTM\\$model\\App\\Http\\Requests\\".$model."Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use ASB\MorphMTM\Utility\AsbClassMap;

class ".$model."Command
{
    /**
     * it gets all the models that have $model.
     * @param string|int \$$model Title|ID Title|ID
     * @return array|Collection
     */
    public function getModelsHave(string|int \$$model): array|Collection
    {
        \$temp=[];
        \$$model = \$this->get".$model."Model(\$$model);
        if (empty(\$$model)) return collect([]);
        foreach (AsbClassMap::getClassMap() as \$rel => \$class) {
            \$current_temp= \$$model->\$rel->all();
            if(!\$current_temp) continue;
            \$temp[\$rel] = \$current_temp;
        }
        return \$temp;
    }

    /**
     * it gets all the ".ucfirst($plural)." of Model.
     * @param Model \$model
     * @return array|Collection
     */
    public function get".ucfirst($plural)."(Model \$model, bool|string \$pluck = false): array|Collection
    {
        return !\$pluck && !empty(\$model->".strtolower($plural).") ?
            \$model->".strtolower($plural)." :
            \$model->".strtolower($plural)."()->pluck(\$pluck)->toArray();
    }

    /**
     * it checks The model has this $model by Title or ID.
     * @param Model \$model
     * @param string|int \$$model Title|ID
     * @return bool
     */
    public function has$model(Model \$model, string|int \$$model): bool
    {
        return in_array(\$$model, \$this->get".ucfirst($plural)."(\$model, is_int(\$$model)?'id':'title'));
    }

    /**
     * it assigns a $model to the Model by Title or ID.
     * @param Model \$model
     * @param string|int \$$model Title|ID
     * @return bool|Collection
     */
    public function assign$model(Model \$model, string|int \$$model): bool|Collection
    {
        if(\$this->isTrashed(\$$model)) return false;
        \$$model = \$this->firstOrCreate".$model."Internal(\$$model);
        if(is_bool(\$$model) && \$$model) return false;
        \$model->".strtolower($plural)."()->sync(\$$model);
        return \$model->$plural;
    }

    /**
     * it adds a $model to the Model by Title or ID.
     * @param Model \$model
     * @param string|int \$$model Title|ID
     * @return bool|Collection
     */
    public function add$model(Model \$model, string|int \$$model): bool|Collection
    {
        if(\$this->isTrashed(\$$model)) return false;
        \$$model = \$this->firstOrCreate".$model."Internal(\$$model);
        if(is_bool(\$$model) && \$$model) return false;
        return  \$this->has".$model."(\$model, \$".$model."->title) ? \$model->$plural :
            (\$model->".$plural."()->attach(\$$model) ?? \$model->$plural);
    }

    /**
     * it updates a $model from the Model and replace by new $model Or a $model that exists.
     * @param Model \$model
     * @param string|int \$$model Title|ID
     * @param string|int \$update".$model." Title|ID
     * @return bool
     */
    public function update$model(Model \$model, string|int \$$model, string|int \$update".$model."): bool
    {
        if (!\$$model = \$this->get".$model."Model(\$$model)) return false;
        \$update_".$model." = \$this->firstOrCreate".$model."Internal(\$update".$model.");
        \$existing_".$plural." = \$this->get".ucfirst($plural)."(\$model, 'id');
        if (in_array(\$".$model."->id, \$existing_".$plural.")) {
            if (in_array(\$update_".$model."->id, \$existing_".$plural.")){
                unset(\$existing_".$plural."[array_search(\$update_".$model."->id, \$existing_".$plural.")]);
            }
            return \$existing_".$plural." && \$model->".$plural."()->sync(\$existing_".$plural.");
        }
        return false;
    }

    /**
     * it removes a $model from the model by Title or ID
     * @param Model \$model
     * @param string|int \$$model Title|ID
     * @return mixed
     */
    public function remove$model(Model \$model, string|int \$$model): mixed
    {
        \$$model = \$this->get".$model."Model(\$$model);
        \$existing_".$plural." = \$this->get".ucfirst($plural)."(\$model, 'id');
        if (\$$model && in_array(\$".$model."->id, \$existing_".$plural.")) {
            return \$model->".$plural."()->detach(\$$model);
        }
        return false;
    }

    /**
     * it removes all the ".$model." from the Model
     * @param Model \$model
     * @return mixed
     */
    public function removeAll".$model."(Model \$model): mixed
    {
        return \$model->".$plural."()->detach();

    }

    /* =====================> crud $model model <============================ */
    /**
     * it Creates a $model by a new Title
     * @param string $$model
     * @return bool
     */
    public function create".$model."Model(string $$model): bool
    {
        return !".$model."Request::rules(\$$model) && $model::query()->createOrFirst(['title'=>$$model]);
    }

    /**
     * it gets all of $model And if it is called with \"true\" parameter, it will get all the deleted $model.
     * @param bool \$onlyTrashed It only receives ".ucfirst($plural)." in the Trash if it is True
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll".$model."Model(bool \$onlyTrashed=false): \Illuminate\Database\Eloquent\Collection
    {
        return !\$onlyTrashed?$model::all():$model::onlyTrashed()->get();
    }

    /**
     * it gets a $model by Title or ID.
     * @param string|int \$$model Title|ID
     * @return $model|null
     */
    public function get".$model."Model(string|int $$model): ?$model
    {
        return $model::query()->where('title', $$model)->first() ??
            $model::query()->where('id', $$model)->first();
    }

    /**
     * it updates a $model by Title or ID and replace by a new Title
     * @param string|int \$$model Title|ID
     * @param string \$update_$model
     * @return bool
     */
    public function update".$model."Model(string|int $$model, string \$update_$model): bool
    {
        $$model = \$this->get".$model."Model(\$$model);
        return $$model && !".$model."Request::rules(\$$model) && $".$model."->update(['title'=> \$update_$model]);
    }

    /**
     * it removes a $model by title or id
     * @param int|string $$model
     * @return bool
     */
    public function remove".$model."Model(int|string $$model): bool
    {
        $$model = \$this->get".$model."Model(\$$model);
        return $$model && $".$model."->delete();
    }
    /**
     * it restores a $$model by title or id
     * @param int|string $$model
     * @return bool
     */
    public function restore".$model."Model(int|string $$model): bool
    {
        $$model = $model::onlyTrashed()->where('title', $$model)->first() ?? $model::onlyTrashed()->where('id', $$model)->first();
        return $$model && $".$model."->restore();
    }
     /**
     * @param int|string $$model
     * @return $model|bool|Model
     */
    public function firstOrCreate".$model."Internal(int|string $$model): bool|Model|$model
    {
        return $model::query()->where(['id' => $$model])->first() ??
            is_int($$model) ?: $model::query()->firstOrCreate(['title' => $$model]);
    }

    /*====================================> Validation <===========================================*/
    /**
     * @param string $$model
     * @return bool
     */
    public function isTrashed(string $$model): bool
    {
        return $model::onlyTrashed()->where(['id' => $$model])->first() ||
         $model::onlyTrashed()->where(['title' => $$model])->first();
    }
}
";
