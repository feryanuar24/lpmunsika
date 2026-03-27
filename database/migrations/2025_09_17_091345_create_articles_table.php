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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title')->index();
            $table->string('slug');
            $table->text('content');
            $table->string('thumbnail')->nullable();
            $table->boolean('is_active')->default(false);
            $table->boolean('is_pinned')->default(false);
            $table->integer('views')->default(0);
            $table->integer('likes')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['title', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
