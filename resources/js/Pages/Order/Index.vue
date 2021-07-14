<template>
    <div>
        <jet-banner />
        <div class="bg-auxyl-blue pb-32">
            <Disclosure as="nav" class="bg-auxyl-blue" v-slot="{ open }">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="border-b border-auxyl-green">
                        <div class="flex items-center justify-between h-16 px-4 sm:px-0">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <inertia-link href="/">
                                        <img class="block h-9 w-auto" :src="asset('manifest/playstore.png')" alt="Logo" />
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
                                <div v-if="canLogin" class="ml-4 flex items-center md:ml-6 space-x-3">
                                    <template v-if="$page.props.user">
                                        <inertia-link :href="route('cart.index')">
                                            <button class="bg-auxyl-blue p-1 text-gray-400 rounded-full hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
                                                <span class="sr-only">View carts</span>
                                                <ShoppingCartIcon class="h-6 w-6" aria-hidden="true" />
                                            </button>
                                        </inertia-link>
                                        <button class="bg-auxyl-blue p-1 text-gray-400 rounded-full hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
                                            <span class="sr-only">View notifications</span>
                                            <BellIcon class="h-6 w-6" aria-hidden="true" />
                                        </button>

                                        <!-- Proproduct dropdown -->
                                        <Menu as="div" class="ml-3 relative">
                                            <div>
                                                <MenuButton class="max-w-xs bg-auxyl-blue rounded-full flex items-center text-sm">
                                                    <span class="sr-only">Open user menu</span>
                                                    <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                                        <img class="h-8 w-8 rounded-full object-cover" :src="'https://ui-avatars.com/api/?name=' + $page.props.user.name + '&color=7F9CF5&background=EBF4FF'" v-bind:alt="$page.props.user.name" />
                                                    </button>
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
                                        <!-- Authentication -->
                                        <form @submit.prevent="logout">
                                            <button type="submit" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                                                Log Out
                                            </button>
                                        </form>
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
                            <div class="flex md:hidden space-x-1">
                                <inertia-link :href="route('cart.index')">
                                    <button class="bg-auxyl-blue inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
                                        <span class="sr-only">View carts</span>
                                        <ShoppingCartIcon class="block h-6 w-6" aria-hidden="true" />
                                    </button>
                                </inertia-link>
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
                        <template v-if="$page.props.user">
                            <div class="flex items-center px-5">
                                <div class="flex-shrink-0">
                                    <img class="h-10 w-10 rounded-full" :src="'https://ui-avatars.com/api/?name=' + $page.props.user.name + '&color=7F9CF5&background=EBF4FF'" v-bind:alt="$page.props.user.name" />
                                </div>
                                <div class="ml-3">
                                    <div class="text-base font-medium leading-none text-white">{{ $page.props.user.name }}</div>
                                    <div class="text-sm font-medium leading-none text-gray-400">{{ $page.props.user.email }}</div>
                                </div>
                                <button class="ml-auto bg-auxyl-blue flex-shrink-0 p-1 text-gray-400 rounded-full hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
                                    <span class="sr-only">View notifications</span>
                                    <BellIcon class="h-6 w-6" aria-hidden="true" />
                                </button>
                            </div>
                            <div class="mt-3 px-2 space-y-1">
                                <inertia-link :href="route('profile.show')" class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700">
                                    Profil Saya
                                </inertia-link>
                                <inertia-link :href="route('order.index')" class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700">
                                    Daftar Pesanan
                                </inertia-link>
                                <!-- Authentication -->
                                <form @submit.prevent="logout">
                                    <button type="submit" class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700">
                                        Log Out
                                    </button>
                                </form>
                            </div>
                        </template>
                        <template v-else>
                            <inertia-link :href="route('login')" class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700">
                                Log in
                            </inertia-link>

                            <inertia-link v-if="canRegister" :href="route('register')" class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700">
                                Register
                            </inertia-link>
                        </template>
                    </div>
                </DisclosurePanel>
            </Disclosure>
            <header class="py-10">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h1 class="text-3xl font-bold text-white">
                        Daftar Pesanan Saya
                    </h1>
                </div>
            </header>
        </div>

        <main class="-mt-32">
            <div class="max-w-7xl mx-auto pb-12 px-4 sm:px-6 lg:px-8">
                <div class="bg-white rounded-lg shadow px-5 py-6 sm:px-6">
                    <div class="bg-white shadow overflow-hidden sm:rounded-md">
                        <template v-if="totalOrders">
                            <ul class="divide-y divide-gray-200">
                                <li v-for="order in orders" :key="order.order_id">
                                    <inertia-link :href="route('order.show', order.order_id)" class="block hover:bg-gray-50">
                                        <div class="px-4 py-4 flex items-center sm:px-6">
                                            <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
                                                <div class="truncate">
                                                    <div class="flex items-center justify-between">
                                                        <p class="text-sm font-medium text-auxyl-blue truncate">
                                                            {{ order.order_no }}
                                                        </p>
                                                        <div class="ml-2 flex-shrink-0 flex">
                                                            <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                                {{ order.order_status }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="mt-2 flex">
                                                        <div class="sm:flex items-center text-sm text-gray-500">
                                                            <p class="flex items-center text-sm text-gray-500">
                                                                <CalendarIcon class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" aria-hidden="true" />
                                                                <time :datetime="order.order_date">
                                                                    {{ format(parseISO(order.order_date), 'EEEE, dd MMMM yyyy', { locale }) }}
                                                                </time>
                                                            </p>
                                                            <p class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0 sm:ml-6">
                                                                <ShoppingBagIcon class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" aria-hidden="true" />
                                                                {{ order.related_products.length }} barang
                                                            </p>
                                                            <p class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0 sm:ml-6">
                                                                <CurrencyDollarIcon class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" aria-hidden="true" />
                                                                {{ addCommas(order.order_total) }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mt-4 flex-shrink-0 sm:mt-0 sm:ml-5">
                                                    <div class="flex overflow-hidden -space-x-1">
                                                        <img v-for="product in order.related_products" :key="product.product_id" class="inline-block h-6 w-6 rounded-full ring-2 ring-white" :src="product.related_photos[0].image_url" @error="imgUrlAlt" v-bind:alt="product.related_photos[0].image_alt_text" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ml-5 flex-shrink-0">
                                                <ChevronRightIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                                            </div>
                                        </div>
                                    </inertia-link>
                                </li>
                            </ul>
                        </template>
                        <template v-else>
                            <div class="relative my-10">
                                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                    <div class="w-full border-t border-gray-300" />
                                </div>
                                <div class="relative flex justify-center">
                                    <span class="px-2 bg-white text-sm text-gray-500">Daftar pesanan kosong. Yuk mulai berbelanja!</span>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<script>
import { ref } from 'vue'
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { BellIcon, MenuIcon, ShoppingCartIcon, ShoppingBagIcon, XIcon } from '@heroicons/vue/outline'
import { TagIcon, CurrencyDollarIcon, ShoppingCartIcon as ShoppingCartIconSolid } from '@heroicons/vue/solid'
import { CalendarIcon, ChevronRightIcon } from '@heroicons/vue/solid'
import JetBanner from "@/Jetstream/Banner";
import {format} from 'date-fns'
import locale from 'date-fns/locale/id'
import parseISO from 'date-fns/parseISO'

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
        title: 'Daftar Pesanan',
        url: route('order.index'),
    }
]
const positions = [
    {
        id: 1,
        title: 'Back End Developer',
        department: 'Engineering',
        closeDate: '2020-01-07',
        closeDateFull: 'January 7, 2020',
        applicants: [
            {
                name: 'Dries Vincent',
                email: 'driesvincent@example.com',
                imageUrl:
                    'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
            },
            {
                name: 'Lindsay Walton',
                email: 'lindsaywalton@example.com',
                imageUrl:
                    'https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
            },
            {
                name: 'Courtney Henry',
                email: 'courtneyhenry@example.com',
                imageUrl:
                    'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
            },
            {
                name: 'Tom Cook',
                email: 'tomcook@example.com',
                imageUrl:
                    'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
            },
        ],
    },
    {
        id: 2,
        title: 'Front End Developer',
        department: 'Engineering',
        closeDate: '2020-01-07',
        closeDateFull: 'January 7, 2020',
        applicants: [
            {
                name: 'Whitney Francis',
                email: 'whitneyfrancis@example.com',
                imageUrl:
                    'https://images.unsplash.com/photo-1517365830460-955ce3ccd263?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
            },
            {
                name: 'Leonard Krasner',
                email: 'leonardkrasner@example.com',
                imageUrl:
                    'https://images.unsplash.com/photo-1519345182560-3f2917c472ef?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
            },
            {
                name: 'Floyd Miles',
                email: 'floydmiles@example.com',
                imageUrl:
                    'https://images.unsplash.com/photo-1463453091185-61582044d556?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
            },
        ],
    },
    {
        id: 3,
        title: 'User Interface Designer',
        department: 'Design',
        closeDate: '2020-01-14',
        closeDateFull: 'January 14, 2020',
        applicants: [
            {
                name: 'Emily Selman',
                email: 'emilyselman@example.com',
                imageUrl:
                    'https://images.unsplash.com/photo-1502685104226-ee32379fefbe?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
            },
            {
                name: 'Kristin Watson',
                email: 'kristinwatson@example.com',
                imageUrl:
                    'https://images.unsplash.com/photo-1500917293891-ef795e70e1f6?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
            },
            {
                name: 'Emma Dorsey',
                email: 'emmadorsey@example.com',
                imageUrl:
                    'https://images.unsplash.com/photo-1505840717430-882ce147ef2d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
            },
        ],
    },
]

export default {
    name: "Order Lists",
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
        ShoppingBagIcon,
        ShoppingCartIcon,
        XIcon,
        TagIcon,
        CurrencyDollarIcon,
        ShoppingCartIconSolid,
        CalendarIcon,
        ChevronRightIcon,
        JetBanner
    },
    data() {
        return {
            format,
            locale,
            parseISO,
        }
    },
    setup() {
        const open = ref(false)

        return {
            navigation,
            proproduct,
            positions,
            open
        }
    },
    props: {
        canLogin: Boolean,
        canRegister: Boolean,
        orders: Object,
    },
    computed: {
        totalOrders() {
            return this.orders.length
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
        logout() {
            this.$inertia.post(route('logout'));
        }
    },
}
</script>

<style scoped>

</style>
