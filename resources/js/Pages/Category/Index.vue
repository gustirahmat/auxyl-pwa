<template>
    <public-layout>
        <template #header>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold text-white">
                    Daftar Kategori
                </h1>
            </div>
        </template>
        
        <div>
            <div class="max-w-7xl mx-auto pb-12 px-4 sm:px-6 lg:px-8">
                <div class="bg-white rounded-lg shadow px-5 py-6 sm:px-6">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
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
    name: 'Category Lists',
    components: {
        PublicLayout
    },
    props: {
        categories: Object,
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
