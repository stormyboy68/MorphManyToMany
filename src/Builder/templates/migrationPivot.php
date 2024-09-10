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
        Schema::create('".strtolower($pluralRelation)."', function (Blueprint \$table) {
            \$table->foreignId(\"".strtolower($model)."_id\")->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            \$table->morphs('".strtolower($relationName)."');
        });
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
