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
        Schema::create('posts', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignIdFor(\App\Models\Blog::class)
                  ->constrained()
                  ->cascadeOnDelete();

            // $table->foreginIdFor(\App\Modles\Catergory::class)
            //       ->nullable()
            //       ->constrained()
            //       ->nullOnDelete();      

            $table->string('title');
            $table->string('slug');
            
            $table->longText('content')->nullable();
            $table->string('cover_image_url')->nullable();

            $table->enum('status', ['draft','published','archived'])->default('draft');

            $table->unsignedBigInteger('views_count')->default(0);

            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->unique(['blog_id', 'slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
