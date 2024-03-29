<template>
    <public-layout>
        <template #header>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold text-white">
                    {{ appName }}
                </h1>
            </div>
        </template>
        
        <div>
            <div class="max-w-7xl mx-auto pb-12 px-4 sm:px-6 lg:px-8">
                <div class="bg-white rounded-lg shadow px-5 py-6 sm:px-6">
                    <h2 class="text-lg leading-6 font-medium text-gray-900">Kategori Pilihan</h2>
                    <div class="mt-2 grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div v-for="category in categories" :key="category.category_id" class="relative rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-auxyl-blue">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full object-cover" :src="category.category_icon" @error="imgUrlAlt" v-bind:alt="category.category_name" />
                            </div>
                            <div class="flex-1 min-w-0">
                                <inertia-link :href="route('category.show', category.category_id)" class="focus:outline-none">
                                    <span class="absolute inset-0" aria-hidden="true" />
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ category.category_name }}
                                    </p>
                                    <p class="text-sm text-gray-500 truncate">
                                        Terdapat {{ category.related_products_count }} item untuk {{ category.category_gender }}
                                    </p>
                                </inertia-link>
                            </div>
                        </div>
                    </div>
                    <h2 class="mt-8 mb-2 text-lg leading-6 font-medium text-gray-900">Daftar Produk</h2>
                    <div class="mt-2 bg-white dark:bg-auxyl-blue overflow-hidden sm:rounded-lg">
                        <ul role="list" class="grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8">
                            <li v-for="product in products" :key="product.source" class="relative">
                                <inertia-link :href="route('product.show', product.product_id)">
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
                                            Stok {{ product.product_stock }}
                                        </p>
                                        <p class="block text-sm font-medium text-gray-500 pointer-events-none">
                                            {{ addCommas(product.price_selling) }}
                                        </p>
                                    </div>
                                </inertia-link>
                            </li>
                        </ul>
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
        appName: String,
        categories: Object,
        products: Object,
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
