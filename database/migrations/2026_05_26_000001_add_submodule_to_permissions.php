<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            if (!Schema::hasColumn('permissions', 'submodule')) {
                $table->string('submodule')->nullable()->after('module');
            }
            if (!Schema::hasColumn('permissions', 'submodule_label')) {
                $table->string('submodule_label')->nullable()->after('submodule');
            }
            if (!Schema::hasColumn('permissions', 'module_label')) {
                $table->string('module_label')->nullable()->after('module');
            }
        });
    }

    public function down(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropColumn(['submodule', 'submodule_label', 'module_label']);
        });
    }
};
