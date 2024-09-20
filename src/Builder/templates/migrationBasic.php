<?php
return '<?php'."

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        \Rack\\Morph\\MTM\\$model\\App\\Models\\$model::CreateTable();
    }
    public function down(): void
    {
        Schema::dropIfExists(\"$plural\");
    }
};
";
