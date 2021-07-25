<template>
    <public-layout>
        <template #header>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold text-white">
                    {{ promo.promo_name }}
                </h1>
                <img :src="promo.promo_banner" @error="imgUrlAlt" v-bind:alt="promo.promo_name" class="object-cover w-full h-48 sm:h-72 rounded-lg shadow mt-3 mb-2 bg-white"/>
            </div>
        </template>
        
        <div>
            <div class="max-w-7xl mx-auto pb-12 px-4 sm:px-6 lg:px-8">
                <div class="bg-white rounded-lg shadow px-5 py-6 sm:px-6">
                    <div class="bg-white dark:bg-auxyl-blue overflow-hidden sm:rounded-lg">
                        <template v-if="totalProducts">
                            <ul role="list" class="grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8">
                                <li v-for="product in promo.related_products" :key="product.source" class="relative">
                                    <inertia-link :href="route('promo.show', {
                                        promo: promo.promo_id,
                                        _query: {
                                            promo_product_id: product.pivot.promo_product_id
                                        }
                                    })">
                                        <div class="group block w-full aspect-w-10 aspect-h-7 rounded-lg bg-gray-100 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-gray-100 focus-within:ring-auxyl-blue overflow-hidden">
                                            <img :src="product.related_photos[0].image_url" @error="imgUrlAlt" v-bind:alt="product.related_photos[0].image_alt_text" class="object-cover pointer-events-none group-hover:opacity-75"/>
                                            <button type="button" class="absolute inset-0 focus:outline-none">
                                                <span class="sr-only">Lihat detil produk {{ product.product_name }}</span>
                                            </button>
                                        </div>
                                        <p class="mt-2 block text-sm font-medium text-gray-900 truncate pointer-events-none">
                                            {{ product.product_name }}
                                        </p>
                                        <div class="flex justify-between items-center">
                                            <p class="block text-sm font-medium text-gray-500 pointer-events-none">
                                                Stok {{ product.pivot.promo_product_stock }}
                                            </p>
                                            <div>
                                                <p class="block text-sm font-medium text-gray-300 pointer-events-none">
                                                    <s>{{ addCommas(product.price_selling) }}</s>
                                                </p>
                                                <p class="block text-sm font-medium text-gray-500 pointer-events-none">
                                                    {{ addCommas(product.pivot.promo_price_selling) }}
                                                </p>
                                            </div>
                                        </div>
                                    </inertia-link>
                                </li>
                            </ul>
                        </template>
                        <template v-else>
                            <p>Tidak ada produk tersedia dalam promo ini.</p>
                        </template>
                    </div>
                </div>
            </div>
            <div class="mt-2 max-w-7xl mx-auto pb-12 px-4 sm:px-6 lg:px-8">
                <div class="bg-white rounded-lg shadow overflow-hidden sm:rounded-lg px-5 py-6 sm:px-6">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            {{ promo.promo_name }}
                        </h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            Syarat dan Ketentuan
                        </p>
                    </div>
                    <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">
                                    Tentang Promo
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ promo.promo_terms }}
                                </dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">
                                    Tanggal Mulai
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ promo.promo_started_at }}
                                </dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">
                                    Tanggal Akhir
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ promo.promo_finished_at }}
                                </dd>
                            </div>
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">
                                    Syarat dan Ketentuan
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ promo.promo_terms }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </public-layout>
</template>

<style scoped>

</style>

<script>
import { asset } from "@codinglabs/laravel-asset";
import PublicLayout from "@/Layouts/PublicLayout"

export default {
    name: 'Homepage',
    components: {
        PublicLayout
    },
    props: {
        promo: Object,
    },
    computed: {
        totalProducts() {
            return this.promo.related_products.length
        },
    },
    methods: {
        addCommas(nStr) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumSignificantDigits: 9
            }).format(nStr);
        },
        imgUrlAlt(event) {
            event.target.src = asset('manifest/playstore.png')
        },
    },
}
</script>
