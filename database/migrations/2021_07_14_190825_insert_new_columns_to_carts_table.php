<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertNewColumnsToCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->unsignedBigInteger('supplier_id')->index()->nullable()->after('user_id');
            $table->unsignedBigInteger('category_id')->index()->nullable()->after('user_id');

            $table->foreign('supplier_id')->references('supplier_id')->on('suppliers')->onDelete('cascade');
            $table->foreign('category_id')->references('category_id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropForeign('carts_supplier_id_foreign');
            $table->dropIndex('carts_supplier_id_index');
            $table->dropColumn('supplier_id');

            $table->dropForeign('carts_category_id_foreign');
            $table->dropIndex('carts_category_id_index');
            $table->dropColumn('category_id');
        });
    }
}
