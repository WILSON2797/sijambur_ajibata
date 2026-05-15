<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('umkms', function (Blueprint $table) {
            if (!Schema::hasColumn('umkms', 'name')) {
                $table->string('name')->after('id');
                $table->string('owner')->nullable()->after('name');
                $table->text('description')->nullable()->after('owner');
                $table->string('category')->nullable()->after('description');
                $table->string('phone')->nullable()->after('category');
                $table->string('address')->nullable()->after('phone');
                $table->string('image')->nullable()->after('address');
            }
        });

        Schema::table('wisatas', function (Blueprint $table) {
            if (!Schema::hasColumn('wisatas', 'name')) {
                $table->string('name')->after('id');
                $table->text('description')->nullable()->after('name');
                $table->string('location')->nullable()->after('description');
                $table->string('category')->nullable()->after('location');
                $table->string('image')->nullable()->after('category');
                $table->boolean('is_featured')->default(false)->after('image');
            }
        });

        Schema::table('galleries', function (Blueprint $table) {
            if (!Schema::hasColumn('galleries', 'title')) {
                $table->string('title')->after('id');
                $table->text('description')->nullable()->after('title');
                $table->string('category')->nullable()->after('description');
                $table->string('image')->after('category');
            }
        });
    }

    public function down(): void
    {
        Schema::table('umkms', function (Blueprint $table) {
            $table->dropColumn(['name', 'owner', 'description', 'category', 'phone', 'address', 'image']);
        });
        Schema::table('wisatas', function (Blueprint $table) {
            $table->dropColumn(['name', 'description', 'location', 'category', 'image', 'is_featured']);
        });
        Schema::table('galleries', function (Blueprint $table) {
            $table->dropColumn(['title', 'description', 'category', 'image']);
        });
    }
};
