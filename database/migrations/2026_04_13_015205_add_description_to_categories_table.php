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
        Schema::table('categories', function (Blueprint $table) {
            // Kiểm tra và thêm cột description nếu chưa có
            if (!Schema::hasColumn('categories', 'description')) {
                $table->text('description')->nullable()->after('name');
            }
            
            // Kiểm tra và thêm cột status nếu chưa có
            if (!Schema::hasColumn('categories', 'status')) {
                $table->tinyInteger('status')->default(1)->after('description');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            // Xóa các cột này nếu rollback
            $table->dropColumn(['description', 'status']);
        });
    }
};