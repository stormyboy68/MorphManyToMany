<?php
return '<?php'."

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        \Rack\\Morph\\MTM\\$model\\App\\Models\\$model::CreateTable();
        \Rack\\Morph\\MTM\\$model\\App\\Models\\$model::CreatePivotTable();
    }
    public function down(): void
    {
        Schema::dropIfExists(\"$plural\");
        Schema::dropIfExists('".strtolower($pluralRelation)."');
    }
};
";
