<?php
return
'<?php' . "
namespace Rack\\Morph\\MTM\\$model\\App\\Models;\n

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;\n
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Rack\Morph\MTM\\$model\App\Observers\\".$model."Observer;

#[ObservedBy([".$model."Observer::class])]
class $model extends Model
{
    use HasFactory,SoftDeletes;

    protected \$hidden = [
        'pivot',
        'deleted_at',
        'created_at',
        'updated_at'
    ];
    protected \$fillable = [
        'title',
        'model_type',
    ];
    public static function CreateTable(): void
    {
        Schema::create('".$plural."', function (Blueprint \$table) {
            " . ($uuid ? "\$table->uuid(\"id\")->unique();" : "\$table->id();") . "
            \$table->string('title');
            \$table->string('model_type');
            \$table->unique(['title','model_type',DB::raw('(CASE WHEN deleted_at IS NULL THEN 1 ELSE NULL END)')]);
            \$table->softDeletes();
            \$table->timestamps();
        });
    }
    public static function CreatePivotTable(): void
    {
        Schema::create('".strtolower($pluralRelation)."', function (Blueprint \$table) {
            " . ($uuid ? "\$table->foreignUuid(\"".strtolower($model)."_id\")" : "\$table->foreignId(\"".strtolower($model)."_id\")") ."
            ->constrained('$plural')->cascadeOnDelete()->cascadeOnUpdate();
            " . ($uuid ? "\$table->uuidMorphs('".strtolower($relationName)."');" : "\$table->morphs('".strtolower($relationName)."');") . "
        });
    }
    public static function boot()
    {
        parent::boot();

        static::creating(function (\$".$plural.") {
            \$existing".ucfirst($plural)." = self::query()
                ->where('title',\$".$plural."->title)
                ->where('model_type', \$".$plural."->model_type)
                ->where('deleted_at', null)
                ->exists();
            if (\$existing".ucfirst($plural).") {
                throw new \Exception('A $model with this title for this model type already exists.');
            }
        });
    }
}";
