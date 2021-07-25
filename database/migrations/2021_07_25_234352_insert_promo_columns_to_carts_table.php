<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertPromoColumnsToCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->unsignedBigInteger('promo_product_id')->index()->nullable()->after('product_id');
            $table->foreign('promo_product_id')->references('promo_product_id')->on('promo_product')->onDelete('cascade');

            $table->unsignedBigInteger('promo_id')->index()->nullable()->after('product_id');
            $table->foreign('promo_id')->references('promo_id')->on('promos')->onDelete('cascade');
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
            $table->dropForeign('carts_promo_id_foreign');
            $table->dropIndex('carts_promo_id_index');
            $table->dropColumn('promo_id');

            $table->dropForeign('carts_promo_product_id_foreign');
            $table->dropIndex('carts_promo_product_id_index');
            $table->dropColumn('promo_product_id');
        });
    }
}
