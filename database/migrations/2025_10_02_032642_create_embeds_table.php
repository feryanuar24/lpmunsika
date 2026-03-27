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
        Schema::create('embeds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('platform_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('embed_code');
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['platform_id', 'title', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('embeds');
    }
};
