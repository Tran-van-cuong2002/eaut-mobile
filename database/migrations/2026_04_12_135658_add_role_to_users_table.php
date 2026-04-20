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
    Schema::table('users', function (Blueprint $table) {
        // Thêm cột role, kiểu số nguyên nhỏ, mặc định là 0 (Khách hàng)
        // ->after('password') để đặt cột này đứng ngay sau cột password cho đẹp
        $table->tinyInteger('role')->default(0)->after('password');
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        // Xóa cột role nếu muốn hoàn tác (rollback)
        $table->dropColumn('role');
    });
}
};
