<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lab_updates', function (Blueprint $table) {
            $table->longText('content')->nullable()->after('excerpt');
        });

        // Backfill content from excerpt for existing rows
        \DB::table('lab_updates')
            ->whereNull('content')
            ->update(['content' => \DB::raw('excerpt')]);

        Schema::table('lab_updates', function (Blueprint $table) {
            if (Schema::hasColumn('lab_updates', 'sort_order')) {
                $table->dropColumn('sort_order');
            }
        });
    }

    public function down(): void
    {
        Schema::table('lab_updates', function (Blueprint $table) {
            if (Schema::hasColumn('lab_updates', 'content')) {
                $table->dropColumn('content');
            }
            // Best-effort restore (will be empty for historical rows)
            if (!Schema::hasColumn('lab_updates', 'sort_order')) {
                $table->integer('sort_order')->default(0);
            }
        });
    }
};

