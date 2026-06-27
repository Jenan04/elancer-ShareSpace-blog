<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->foreignUuid('user_id')
                  ->nullable() // Keep nullable in migration to prevent issues with existing posts if any, but default to required for new ones.
                  ->constrained('users')
                  ->cascadeOnDelete();
            
            $table->foreignUuid('category_id')
                  ->nullable()
                  ->constrained('categories')
                  ->nullOnDelete();

            $table->unsignedInteger('read_time')->default(0);
            $table->string('image_path')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');

            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');

            $table->dropColumn('read_time');
            $table->dropColumn('image_path');
        });
    }
};
