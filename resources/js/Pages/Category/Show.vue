<template>
    <public-layout>
        <template #header>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-4">
                        <li>
                            <div>
                                <inertia-link href="/" class="text-gray-400 hover:text-gray-500">
                                    <HomeIcon class="flex-shrink-0 h-5 w-5" aria-hidden="true" />
                                    <span class="sr-only">Home</span>
                                </inertia-link>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <ChevronRightIcon class="flex-shrink-0 h-5 w-5 text-gray-400" aria-hidden="true" />
                                <inertia-link :href="route('category.index')" class="ml-4 text-sm font-medium text-gray-400 hover:text-gray-500">
                                    Daftar Kategori
                                </inertia-link>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <ChevronRightIcon class="flex-shrink-0 h-5 w-5 text-gray-400" aria-hidden="true" />
                                <p class="ml-4 text-sm font-medium text-gray-500">
                                    {{ category.category_name }}
                                </p>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="mt-2 text-3xl font-bold text-white">
                    {{ category.category_name }}
                </h1>
                <p class="mt-1 text-sm text-gray-300 truncate">
                    Terdapat {{ category.related_products_count }} item untuk {{ category.category_gender }}
                </p>
            </div>
        </template>
        
        <div>
            <div class="max-w-7xl mx-auto pb-12 px-4 sm:px-6 lg:px-8">
                <div class="bg-white rounded-lg shadow px-5 py-6 sm:px-6">
                    <div class="bg-white dark:bg-auxyl-blue overflow-hidden sm:rounded-lg">
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
import { ChevronRightIcon, HomeIcon } from '@heroicons/vue/solid'
import PublicLayout from "@/Layouts/PublicLayout"

export default {
    name: 'Category Details',
    components: {
        ChevronRightIcon,
        HomeIcon,
        PublicLayout
    },
    props: {
        category: Object,
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
