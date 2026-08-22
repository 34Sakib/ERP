<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('sender_name');
            $table->string('sender_avatar')->nullable();
            $table->string('badge_icon')->default('bi-bell-fill');
            $table->string('badge_color')->default('bg-primary');
            $table->string('title');
            $table->string('target_name')->nullable();
            $table->text('body')->nullable();
            $table->string('action_url')->nullable();
            $table->boolean('has_actions')->default(false);
            $table->string('action_decline_label')->default('Decline');
            $table->string('action_accept_label')->default('Accept');
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
