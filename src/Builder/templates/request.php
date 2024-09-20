<?php
return
'<?php'."
namespace Rack\\Morph\\MTM\\$model\\App\\Http\\Requests;

use Illuminate\Support\Facades\Validator;

class ".$model."Request
{

    public static function rules(\$value)
    {
        \$validator = Validator::make(['title' => \$value], [
            'title' => 'required|unique:$plural|max:255',
        ]);
        if (\$validator->fails()) {
            return true;
        }
    }
}
";
