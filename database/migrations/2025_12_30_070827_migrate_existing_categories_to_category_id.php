<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Blog;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Only migrate if the category column exists (for existing data)
        if (Schema::hasColumn('blogs', 'category')) {
            // Get all unique category strings from blogs
            $uniqueCategories = DB::table('blogs')
                ->select('category')
                ->whereNotNull('category')
                ->where('category', '!=', '')
                ->distinct()
                ->pluck('category')
                ->toArray();

            // Create Category records for each unique category
            $categoryMap = [];
            foreach ($uniqueCategories as $categoryName) {
                $category = Category::firstOrCreate(
                    ['slug' => Str::slug($categoryName)],
                    ['name' => $categoryName]
                );
                $categoryMap[$categoryName] = $category->id;
            }

            // Update blogs to use category_id
            foreach ($categoryMap as $categoryName => $categoryId) {
                DB::table('blogs')
                    ->where('category', $categoryName)
                    ->update(['category_id' => $categoryId]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration doesn't need a down method as it's a data migration
        // The schema migration will handle the column removal
    }
};
