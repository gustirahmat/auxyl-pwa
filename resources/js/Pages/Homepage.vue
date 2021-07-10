<template>
    <div>
        <div class="bg-auxyl-blue pb-32">
            <Disclosure as="nav" class="bg-auxyl-blue" v-slot="{ open }">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="border-b border-auxyl-green">
                        <div class="flex items-center justify-between h-16 px-4 sm:px-0">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <inertia-link href="/">
                                        <img class="block h-9 w-auto" src="/manifest/playstore.png" alt="Logo" />
                                    </inertia-link>
                                </div>
                                <div class="hidden md:block">
                                    <div class="ml-10 flex items-baseline space-x-4">
                                        <template v-for="(item, itemIdx) in navigation" :key="item">
                                            <template v-if="(itemIdx === 0)">
                                                <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                                                <inertia-link :href="item.url" class="bg-gray-900 text-white px-3 py-2 rounded-md text-sm font-medium">
                                                    {{ item.title }}
                                                </inertia-link>
                                            </template>
                                            <inertia-link v-else :href="item.url" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                                                {{ item.title }}
                                            </inertia-link>
                                        </template>
                                    </div>
                                </div>
                            </div>
                            <div class="hidden md:block">
                                <div v-if="canLogin" class="ml-4 flex items-center md:ml-6">
                                    <template v-if="$page.props.user">
                                        <button class="bg-auxyl-blue p-1 text-gray-400 rounded-full hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
                                            <span class="sr-only">View notifications</span>
                                            <BellIcon class="h-6 w-6" aria-hidden="true" />
                                        </button>

                                        <!-- Proproduct dropdown -->
                                        <Menu as="div" class="ml-3 relative">
                                            <div>
                                                <MenuButton class="max-w-xs bg-auxyl-blue rounded-full flex items-center text-sm">
                                                    <span class="sr-only">Open user menu</span>
                                                    <button v-if="$page.props.jetstream.managesProfilePhotos" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                                        <img class="h-8 w-8 rounded-full object-cover" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name" />
                                                    </button>

                                                    <span v-else class="inline-flex rounded-md">
                                                        <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                                            {{ $page.props.user.name }}

                                                            <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                            </svg>
                                                        </button>
                                                    </span>
                                                </MenuButton>
                                            </div>
                                            <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                                                <MenuItems class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                                        Pengaturan
                                                    </div>
                                                    <MenuItem v-for="item in proproduct" :key="item" v-slot="{ active }">
                                                        <inertia-link :href="item.url" :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">
                                                            {{ item.title }}
                                                        </inertia-link>
                                                    </MenuItem>
                                                </MenuItems>
                                            </transition>
                                        </Menu>
                                    </template>
                                    <template v-else>
                                        <inertia-link :href="route('login')" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                                            Log in
                                        </inertia-link>

                                        <inertia-link v-if="canRegister" :href="route('register')" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                                            Register
                                        </inertia-link>
                                    </template>
                                </div>
                            </div>
                            <div class="-mr-2 flex md:hidden">
                                <!-- Mobile menu button -->
                                <DisclosureButton class="bg-auxyl-blue inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
                                    <span class="sr-only">Open main menu</span>
                                    <MenuIcon v-if="!open" class="block h-6 w-6" aria-hidden="true" />
                                    <XIcon v-else class="block h-6 w-6" aria-hidden="true" />
                                </DisclosureButton>
                            </div>
                        </div>
                    </div>
                </div>

                <DisclosurePanel class="border-b border-auxyl-green md:hidden">
                    <div class="px-2 py-3 space-y-1 sm:px-3">
                        <template v-for="(item, itemIdx) in navigation" :key="item">
                            <template v-if="(itemIdx === 0)">
                                <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                                <inertia-link :href="item.url" class="bg-gray-900 text-white block px-3 py-2 rounded-md text-base font-medium">
                                    {{ item.title }}
                                </inertia-link>
                            </template>
                            <inertia-link v-else :href="item.url" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">
                                {{ item.title }}
                            </inertia-link>
                        </template>
                    </div>
                    <div class="pt-4 pb-3 border-t border-auxyl-green">
                        <div class="flex items-center px-5">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" />
                            </div>
                            <div class="ml-3">
                                <div class="text-base font-medium leading-none text-white">Tom Cook</div>
                                <div class="text-sm font-medium leading-none text-gray-400">tom@example.com</div>
                            </div>
                            <button class="ml-auto bg-auxyl-blue flex-shrink-0 p-1 text-gray-400 rounded-full hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
                                <span class="sr-only">View notifications</span>
                                <BellIcon class="h-6 w-6" aria-hidden="true" />
                            </button>
                        </div>
                        <div class="mt-3 px-2 space-y-1">
                            <inertia-link v-for="item in proproduct" :key="item.title" :href="item.url" class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700">{{ item.title }}</inertia-link>
                        </div>
                    </div>
                </DisclosurePanel>
            </Disclosure>
            <header class="py-10">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h1 class="text-3xl font-bold text-white">
                        {{ appName }}
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
                    <div class="mt-2 bg-white dark:bg-auxyl-blue overflow-hidden sm:rounded-lg">
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

const navigation = [
    {
        title: 'Beranda',
        url: '/',
    },
    {
        title: 'Kategori',
        url: '/kategori',
    },
    {
        title: 'Promo',
        url: '/promo',
    }
]
const proproduct = [
    {
        title: 'Profil Saya',
        url: route('profile.show'),
    },
    {
        title: 'Log Out',
        url: '/',
    }
]
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
        appName: String,
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
