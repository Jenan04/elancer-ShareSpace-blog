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
        Schema::create('blogs', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('name');
            $table->string('slug')->unique();

            $table->text('description')->nullable();

            $table->foreignIdFor(\App\Models\User::class)
                  ->constrained()
                  ->cascadeOnDelete();
    
            // write in another way, we prefer this way when we naming the column in a spacific way that doesn't lead ```Laravel Standards``` 
            // $table->uuid('user_id');
            // $table->foreign('user_id')          
            //       ->references('id')            
            //       ->on('users')                 
            //       ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
