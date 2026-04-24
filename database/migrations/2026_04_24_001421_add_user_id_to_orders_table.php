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
    Schema::table('orders', function (Blueprint $table) {
        // Thêm cột user_id sau cột id, cho phép null (để khách vãng lai vẫn đặt được hàng)
        $table->unsignedBigInteger('user_id')->nullable()->after('id');

        // Nếu bạn muốn ràng buộc khóa ngoại với bảng users
        $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
    });
}

public function down(): void
{
    Schema::table('orders', function (Blueprint $table) {
        $table->dropForeign(['user_id']);
        $table->dropColumn('user_id');
    });
}
};
