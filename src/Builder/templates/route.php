<?php
return
'<?php'."

use Illuminate\Support\Facades\Route;
use Rack\\Morph\\MTM\\".$model."\App\Http\Controllers\\".$model."Controller;

Route::resource('".strtolower($plural)."', ".$model."Controller::class);
";
