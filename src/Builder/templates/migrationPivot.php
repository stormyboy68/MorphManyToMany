<?php
return '<?php'."

namespace database\migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        \Rack\\Morph\\MTM\\$model\\App\\Models\\$model::CreatePivotTable();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('".strtolower($pluralRelation)."');
    }
};
";
