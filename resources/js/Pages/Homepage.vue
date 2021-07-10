<template>
    <div>
        <div class="bg-gray-800 pb-32">
            <Disclosure as="nav" class="bg-gray-800" v-slot="{ open }">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="border-b border-gray-700">
                        <div class="flex items-center justify-between h-16 px-4 sm:px-0">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <img class="h-8 w-8" src="https://tailwindui.com/img/logos/workflow-mark-indigo-500.svg" alt="Workflow" />
                                </div>
                                <div class="hidden md:block">
                                    <div class="ml-10 flex items-baseline space-x-4">
                                        <template v-for="(item, itemIdx) in navigation" :key="item">
                                            <template v-if="(itemIdx === 0)">
                                                <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                                                <a href="#" class="bg-gray-900 text-white px-3 py-2 rounded-md text-sm font-medium">{{ item }}</a>
                                            </template>
                                            <a v-else href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">{{ item }}</a>
                                        </template>
                                    </div>
                                </div>
                            </div>
                            <div class="hidden md:block">
                                <div class="ml-4 flex items-center md:ml-6">
                                    <button class="bg-gray-800 p-1 text-gray-400 rounded-full hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
                                        <span class="sr-only">View notifications</span>
                                        <BellIcon class="h-6 w-6" aria-hidden="true" />
                                    </button>

                                    <!-- Proproduct dropdown -->
                                    <Menu as="div" class="ml-3 relative">
                                        <div>
                                            <MenuButton class="max-w-xs bg-gray-800 rounded-full flex items-center text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
                                                <span class="sr-only">Open user menu</span>
                                                <img class="h-8 w-8 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" />
                                            </MenuButton>
                                        </div>
                                        <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                                            <MenuItems class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                                                <MenuItem v-for="item in proproduct" :key="item" v-slot="{ active }">
                                                    <a href="#" :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">{{ item }}</a>
                                                </MenuItem>
                                            </MenuItems>
                                        </transition>
                                    </Menu>
                                </div>
                            </div>
                            <div class="-mr-2 flex md:hidden">
                                <!-- Mobile menu button -->
                                <DisclosureButton class="bg-gray-800 inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
                                    <span class="sr-only">Open main menu</span>
                                    <MenuIcon v-if="!open" class="block h-6 w-6" aria-hidden="true" />
                                    <XIcon v-else class="block h-6 w-6" aria-hidden="true" />
                                </DisclosureButton>
                            </div>
                        </div>
                    </div>
                </div>

                <DisclosurePanel class="border-b border-gray-700 md:hidden">
                    <div class="px-2 py-3 space-y-1 sm:px-3">
                        <template v-for="(item, itemIdx) in navigation" :key="item">
                            <template v-if="(itemIdx === 0)">
                                <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                                <a href="#" class="bg-gray-900 text-white block px-3 py-2 rounded-md text-base font-medium">{{ item }}</a>
                            </template>
                            <a v-else href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">{{ item }}</a>
                        </template>
                    </div>
                    <div class="pt-4 pb-3 border-t border-gray-700">
                        <div class="flex items-center px-5">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" />
                            </div>
                            <div class="ml-3">
                                <div class="text-base font-medium leading-none text-white">Tom Cook</div>
                                <div class="text-sm font-medium leading-none text-gray-400">tom@example.com</div>
                            </div>
                            <button class="ml-auto bg-gray-800 flex-shrink-0 p-1 text-gray-400 rounded-full hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
                                <span class="sr-only">View notifications</span>
                                <BellIcon class="h-6 w-6" aria-hidden="true" />
                            </button>
                        </div>
                        <div class="mt-3 px-2 space-y-1">
                            <a v-for="item in proproduct" :key="item" href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700">{{ item }}</a>
                        </div>
                    </div>
                </DisclosurePanel>
            </Disclosure>
            <header class="py-10">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h1 class="text-3xl font-bold text-white">
                        Beranda
                    </h1>
                </div>
            </header>
        </div>

        <main class="-mt-32">
            <div class="max-w-7xl mx-auto pb-12 px-4 sm:px-6 lg:px-8">
                <div class="bg-white rounded-lg shadow px-5 py-6 sm:px-6">
                    <h2 class="text-lg leading-6 font-medium text-gray-900">Kategori Pilihan</h2>
                    <div class="mt-2 grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div v-for="category in categories" :key="category.category_id" class="relative rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" />
                            </div>
                            <div class="flex-1 min-w-0">
                                <a href="#" class="focus:outline-none">
                                    <span class="absolute inset-0" aria-hidden="true" />
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ category.category_name }}
                                    </p>
                                    <p class="text-sm text-gray-500 truncate">
                                        {{ category.category_gender }}
                                    </p>
                                </a>
                            </div>
                        </div>
                    </div>
                    <h2 class="mt-8 mb-2 text-lg leading-6 font-medium text-gray-900">Daftar Produk</h2>
                    <div class="mt-2 bg-white dark:bg-gray-800 overflow-hidden sm:rounded-lg">
                        <ul role="list" class="grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8">
                            <li v-for="product in products" :key="product.source" class="relative">
                                <div class="group block w-full aspect-w-10 aspect-h-7 rounded-lg bg-gray-100 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-gray-100 focus-within:ring-indigo-500 overflow-hidden">
                                    <img src="https://images.unsplash.com/photo-1582053433976-25c00369fc93?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=512&q=80" alt=""
                                         class="object-cover pointer-events-none group-hover:opacity-75"/>
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
                            </li>
                            <li v-for="product in products" :key="product.source" class="relative">
                                <div class="group block w-full aspect-w-10 aspect-h-7 rounded-lg bg-gray-100 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-gray-100 focus-within:ring-indigo-500 overflow-hidden">
                                    <img src="https://images.unsplash.com/photo-1582053433976-25c00369fc93?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=512&q=80" alt=""
                                         class="object-cover pointer-events-none group-hover:opacity-75"/>
                                    <button type="button" class="absolute inset-0 focus:outline-none">
                                        <span class="sr-only">Lihat detil produk {{ product.product_name }}</span>
                                    </button>
                                </div>
                                <p class="mt-2 block text-sm font-medium text-gray-900 truncate pointer-events-none">
                                    {{ product.product_name }}
                                </p>
                                <div class="flex justify-between items-center">
                                    <p class="block text-sm font-medium text-gray-500 pointer-events-none">
                                        {{ addCommas(product.price_selling) }}
                                    </p>
                                    <p class="block text-sm font-medium text-gray-500 pointer-events-none">
                                        Stok : {{ product.product_stock }}
                                    </p>
                                </div>
                            </li>
                            <li v-for="product in products" :key="product.source" class="relative">
                                <div class="group block w-full aspect-w-10 aspect-h-7 rounded-lg bg-gray-100 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-gray-100 focus-within:ring-indigo-500 overflow-hidden">
                                    <img src="https://images.unsplash.com/photo-1582053433976-25c00369fc93?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=512&q=80" alt=""
                                         class="object-cover pointer-events-none group-hover:opacity-75"/>
                                    <button type="button" class="absolute inset-0 focus:outline-none">
                                        <span class="sr-only">Lihat detil produk {{ product.product_name }}</span>
                                    </button>
                                </div>
                                <p class="mt-2 block text-sm font-medium text-gray-900 truncate pointer-events-none">
                                    {{ product.product_name }}
                                </p>
                                <div class="flex justify-between items-center">
                                    <p class="block text-sm font-medium text-gray-500 pointer-events-none">
                                        {{ addCommas(product.price_selling) }}
                                    </p>
                                    <p class="block text-sm font-medium text-gray-500 pointer-events-none">
                                        Stok : {{ product.product_stock }}
                                    </p>
                                </div>
                            </li>
                            <li v-for="product in products" :key="product.source" class="relative">
                                <div class="group block w-full aspect-w-10 aspect-h-7 rounded-lg bg-gray-100 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-gray-100 focus-within:ring-indigo-500 overflow-hidden">
                                    <img src="https://images.unsplash.com/photo-1582053433976-25c00369fc93?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=512&q=80" alt=""
                                         class="object-cover pointer-events-none group-hover:opacity-75"/>
                                    <button type="button" class="absolute inset-0 focus:outline-none">
                                        <span class="sr-only">Lihat detil produk {{ product.product_name }}</span>
                                    </button>
                                </div>
                                <p class="mt-2 block text-sm font-medium text-gray-900 truncate pointer-events-none">
                                    {{ product.product_name }}
                                </p>
                                <div class="flex justify-between items-center">
                                    <p class="block text-sm font-medium text-gray-500 pointer-events-none">
                                        {{ addCommas(product.price_selling) }}
                                    </p>
                                    <p class="block text-sm font-medium text-gray-500 pointer-events-none">
                                        Stok : {{ product.product_stock }}
                                    </p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<style scoped>

</style>

<script>
import { ref } from 'vue'
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { BellIcon, MenuIcon, XIcon } from '@heroicons/vue/outline'

const navigation = ['Beranda', 'Kategori', 'Promo']
const proproduct = ['Profil Saya', 'Pengaturan', 'Keluar']
const products = [
    {
        title: 'IMG_4985.HEIC',
        size: '3.9 MB',
        source:
            'https://images.unsplash.com/photo-1582053433976-25c00369fc93?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=512&q=80',
    },
    {
        title: 'IMG_4985.HEIC',
        size: '3.9 MB',
        source:
            'https://images.unsplash.com/photo-1582053433976-25c00369fc93?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=512&q=80',
    },
    {
        title: 'IMG_4985.HEIC',
        size: '3.9 MB',
        source:
            'https://images.unsplash.com/photo-1582053433976-25c00369fc93?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=512&q=80',
    },
    {
        title: 'IMG_4985.HEIC',
        size: '3.9 MB',
        source:
            'https://images.unsplash.com/photo-1582053433976-25c00369fc93?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=512&q=80',
    },
    // More products...
]
const people = [
    {
        name: 'Leslie Alexander',
        email: 'lesliealexander@example.com',
        role: 'Co-Founder / CEO',
        imageUrl:
            'https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
    },
    {
        name: 'Leslie Alexander',
        email: 'lesliealexander@example.com',
        role: 'Co-Founder / CEO',
        imageUrl:
            'https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
    },
    // More people...
]

export default {
    name: 'Homepage',
    components: {
        Disclosure,
        DisclosureButton,
        DisclosurePanel,
        Menu,
        MenuButton,
        MenuItem,
        MenuItems,
        BellIcon,
        MenuIcon,
        XIcon,
    },
    setup() {
        const open = ref(false)

        return {
            navigation,
            proproduct,
            products,
            people,
            open,
        }
    },
    props: {
        canLogin: Boolean,
        canRegister: Boolean,
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
    },
}
</script>
