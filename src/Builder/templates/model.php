<?php
return
'<?php' . "
namespace Rack\\Morph\\MTM\\$model\\App\\Models;\n

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;\n
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
    ];
    public static function CreateTable()
    {
        Schema::create('".$plural."', function (Blueprint \$table) {
            \$table->id();
            \$table->string('title')->unique();
            \$table->softDeletes();
            \$table->timestamps();
        });
    }
}";
