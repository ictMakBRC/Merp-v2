<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inv_stock_document_items', function (Blueprint $table) {
            $table->foreign(['document_id'])->references(['id'])->on('inv_stock_documents');
            $table->foreign(['inv_item_id'])->references(['id'])->on('inv_department_items');
            $table->foreign(['inv_store_id'])->references(['id'])->on('inv_stores')->onUpdate('CASCADE');
            $table->foreign(['inv_supplier_id'])->references(['id'])->on('inv_suppliers')->onUpdate('CASCADE');
            $table->foreign(['item_id'])->references(['id'])->on('inv_items');
            $table->foreign(['user_id'])->references(['id'])->on('users');
            $table->foreign(['department_id'])->references(['id'])->on('departments')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inv_stock_document_items', function (Blueprint $table) {
            $table->dropForeign('inv_stock_document_items_document_id_foreign');
            $table->dropForeign('inv_stock_document_items_inv_item_id_foreign');
            $table->dropForeign('inv_stock_document_items_inv_store_id_foreign');
            $table->dropForeign('inv_stock_document_items_inv_supplier_id_foreign');
            $table->dropForeign('inv_stock_document_items_item_id_foreign');
            $table->dropForeign('inv_stock_document_items_user_id_foreign');
            $table->dropForeign('inv_stock_document_items_department_id_foreign');
        });
    }
};
