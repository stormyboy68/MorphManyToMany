<?php
return
    '<?php'."
namespace Rack\\Morph\\MTM\\$model\\App\\Commands;

use Rack\\Morph\\MTM\\$model\\App\\Models\\$model;
use Rack\\Morph\\MTM\\$model\\App\\Http\\Requests\\".$model."Request;
use ASB\\MorphMTM\\Exceptions\\DuplicateMtmModelException;
use Illuminate\\Database\\Eloquent\\Model;
use Illuminate\\Support\\Collection;
use ASB\\MorphMTM\\Utility\\Map;

class ".$model."Command
{
    /* =====================> Relations <============================ */

    /**
     * it gets all the models that have $model.
     */
    public function getModelsHave(string|int \$$model): array|Collection
    {
        \$temp = [];
        \$$model = \$this->get".$model."Model(\$$model);
        if (empty(\$$model)) return collect([]);
        foreach (Map::getClassMap() as \$rel => \$class) {
            \$current_temp = \$$model->\$rel->all();
            if (!\$current_temp) continue;
            \$temp[\$rel] = \$current_temp;
        }
        return \$temp;
    }

    /**
     * it gets all the ".ucfirst($plural)." of Model.
     */
    public function get".ucfirst($plural)."(Model \$model, bool|string \$pluck = false): array|Collection
    {
        return !\$pluck && !empty(\$model->".strtolower($plural).") ?
            \$model->".strtolower($plural)." :
            \$model->".strtolower($plural)."()->pluck(\$pluck)->toArray();
    }

    /**
     * it checks The model has this $model by Title or ID.
     */
    public function has$model(Model \$model, string|int \$$model): bool
    {
        return in_array(\$$model, \$this->get".ucfirst($plural)."(\$model, is_int(\$$model) ? 'id' : 'title'));
    }

    /**
     * it assigns a $model to the Model by Title or ID.
     */
    public function assign$model(Model \$model, string|int \$$model): bool|Collection
    {
        \$$model = \$this->firstOrCreate".$model."Internal(\$$model, get_class(\$model));
        if (!\$$model || !\$$model instanceof $model) return false;
        \$model->".strtolower($plural)."()->sync(\$$model);
        return \$model->$plural;
    }

    /**
     * it adds a $model to the Model by Title or ID.
     */
    public function add$model(Model \$model, string|int \$$model): bool|Collection
    {
        \$$model = \$this->firstOrCreate".$model."Internal(\$$model, get_class(\$model));
        if (!\$$model || !\$$model instanceof $model) return false;
        return \$this->has".$model."(\$model, \$".$model."->title)
            ? \$model->$plural
            : (\$model->".$plural."()->attach(\$$model) ?? \$model->$plural);
    }

    /**
     * it updates a $model from the Model and replace by new $model Or a $model that exists.
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
            \$temp_".$plural." = array_replace(\$existing_".$plural.",
                [array_search(\$".$model."->id, \$existing_".$plural.") => \$update_".$model."->id]);
            return \$existing_".$plural." && \$model->".$plural."()->sync(\$temp_".$plural.");
        }
        return false;
    }

    /**
     * it removes a $model from the model by Title or ID
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
     */
    public function removeAll".$model."(Model \$model): mixed
    {
        return \$model->".$plural."()->detach();
    }

    /* =====================> CRUD $model model <============================ */

    /**
     * it Creates a $model by a new Title.
     *
     * @throws \\ASB\\MorphMTM\\Exceptions\\DuplicateMtmModelException
     */
    public function create".$model."Model(string $$model, ?string \$model_type = null): $model
    {
        return $model::mtmCreate($$model, \$model_type);
    }

    /**
     * it gets all of $model And if it is called with \"true\" parameter, it will get all the deleted $model.
     */
    public function getAll".$model."Model(bool \$onlyTrashed = false): \\Illuminate\\Database\\Eloquent\\Collection
    {
        return !\$onlyTrashed ? $model::all() : $model::onlyTrashed()->get();
    }

    /**
     * it gets a $model by Title or ID.
     */
    public function get".$model."Model(string|int $$model): ?$model
    {
        return $model::query()->where('title', $$model)->first()
            ?? $model::query()->where('id', $$model)->first();
    }

    /**
     * it updates a $model by Title or ID and replace by a new Title.
     *
     * @throws \\ASB\\MorphMTM\\Exceptions\\DuplicateMtmModelException
     */
    public function update".$model."Model(string|int $$model, string \$update_$model): $model
    {
        $$model = \$this->get".$model."Model($$model);
        if (!$$model) {
            throw new \\RuntimeException('$model not found.');
        }
        return $".$model."->mtmUpdate(\$update_$model);
    }

    /**
     * it removes a $model by title or id.
     */
    public function remove".$model."Model(int|string $$model): bool
    {
        $$model = \$this->get".$model."Model($$model);
        return $$model && $".$model."->delete();
    }

    /**
     * it restores a $$model by title or id.
     *
     * @throws \\ASB\\MorphMTM\\Exceptions\\DuplicateMtmModelException
     */
    public function restore".$model."Model(int|string $$model): $model
    {
        $$model = $model::onlyTrashed()->where('title', $$model)->first()
            ?? $model::onlyTrashed()->where('id', $$model)->first();

        if (!$$model) {
            throw new \\RuntimeException('$model not found in trash.');
        }

        return $".$model."->mtmRestore();
    }

    /**
     * Resolve an existing $model or create a new one, respecting uniqueness.
     *
     * @throws \\ASB\\MorphMTM\\Exceptions\\DuplicateMtmModelException
     */
    public function firstOrCreate".$model."Internal(int|string $$model, ?string \$model_type = null): bool|Model|$model
    {
        // ۱. اگه عددی بود (ID)، اول با ID بگرد
        if (is_numeric($$model)) {
            return $model::query()->where('id', $$model)->first() ?: false;
        }

        // ۲. اول با title بگرد (فقط رکوردهای فعال)
        \$found = $model::query()
            ->where('title', $$model)
            ->where('model_type', \$model_type)
            ->whereNull('deleted_at')
            ->first();

        if (\$found) return \$found;

        // ۳. نساخته — با mtmCreate بساز
        try {
            return $model::mtmCreate($$model, \$model_type);
        } catch (DuplicateMtmModelException \$e) {
            // یه پروسه دیگه همزمان ساختش — دوباره بگرد
            return $model::query()
                ->where('title', $$model)
                ->where('model_type', \$model_type)
                ->whereNull('deleted_at')
                ->first() ?: false;
        }
    }

    /* ====================================> Validation <=========================================== */

    /**
     * Check if the $model is in trash.
     */
    public function isTrashed(int|string $$model, ?string \$model_type = null): bool
    {
        return is_numeric($$model)
            ? (bool) $model::onlyTrashed()->where(['id' => $$model])->first()
            : (bool) $model::onlyTrashed()->where(['title' => $$model, 'model_type' => \$model_type])->first();
    }
}
";
