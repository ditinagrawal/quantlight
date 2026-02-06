<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('lab_updates', 'slug')) {
            Schema::table('lab_updates', function (Blueprint $table) {
                $table->string('slug')->nullable()->unique()->after('title');
            });
        }

        // Backfill slug from title for records that have null slug
        $updates = \DB::table('lab_updates')->whereNull('slug')->get();
        foreach ($updates as $update) {
            $slug = \Illuminate\Support\Str::slug($update->title);
            $original = $slug;
            $count = 0;
            while (\DB::table('lab_updates')->where('slug', $slug)->where('id', '!=', $update->id)->exists()) {
                $count++;
                $slug = $original . '-' . $count;
            }
            \DB::table('lab_updates')->where('id', $update->id)->update(['slug' => $slug]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('lab_updates', 'slug')) {
            Schema::table('lab_updates', function (Blueprint $table) {
                $table->dropColumn('slug');
            });
        }
    }
};
