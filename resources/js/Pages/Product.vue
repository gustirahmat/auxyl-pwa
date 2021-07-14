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
                    <div class="lg:flex lg:items-center lg:justify-between">
                        <div class="flex-1 min-w-0">
                            <nav class="flex" aria-label="Breadcrumb">
                                <ol class="flex items-center space-x-4" role="list">
                                    <li>
                                        <div>
                                            <inertia-link href="/" class="text-sm font-medium text-gray-300 hover:text-white">
                                                <HomeIcon class="flex-shrink-0 h-5 w-5" aria-hidden="true" />
                                                <span class="sr-only">Home</span>
                                            </inertia-link>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="flex items-center">
                                            <ChevronRightIcon class="flex-shrink-0 h-5 w-5 text-gray-500" aria-hidden="true" />
                                            <inertia-link :href="route('category.show', product.product_id)" class="ml-4 text-sm font-medium text-gray-300 hover:text-white">
                                                {{ product.related_category.category_name }}
                                            </inertia-link>
                                        </div>
                                    </li>
                                </ol>
                            </nav>
                            <h2 class="mt-2 text-2xl font-bold leading-7 text-white sm:text-3xl sm:truncate">
                                {{ product.product_name }}
                            </h2>
                            <div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
                                <div class="mt-2 flex items-center text-sm text-gray-300">
                                    <CurrencyDollarIcon class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-500" aria-hidden="true" />
                                    {{ addCommas(product.price_selling) }}
                                </div>
                                <div v-if="product.product_stock > 0" class="mt-2 flex items-center text-sm text-gray-300">
                                    <CheckIcon class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-500" aria-hidden="true" />
                                    Stok {{ product.product_stock }}
                                </div>
                                <div v-else class="mt-2 flex items-center text-sm text-gray-300">
                                    <XIcon class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-500" aria-hidden="true" />
                                    Stok Kosong
                                </div>
                            </div>
                        </div>
                        <div class="mt-5 flex lg:mt-0 lg:ml-4">
                            <span class="sm:ml-3">
                                <button type="button" @click="showCart" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-auxyl-green hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-auxyl-green">
                                    <ShoppingCartIcon class="-ml-1 mr-2 h-5 w-5" aria-hidden="true" />
                                    Tambah ke Keranjang ({{ recentCart }})
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
            </header>
        </div>

        <main class="-mt-32">
            <div class="max-w-7xl mx-auto pb-12 px-4 sm:px-6 lg:px-8">
                <div class="bg-white rounded-lg shadow px-5 py-6 sm:px-6">
                    <div class="sm:flex">
                        <div class="mb-4 flex-shrink-0 sm:mb-0 sm:mr-4">
                            <img :src="product.related_photos[0].image_url" @error="imgUrlAlt" v-bind:alt="product.related_photos[0].image_alt_text" class="object-cover rounded-lg shadow h-80 w-full sm:w-96 bg-white"/>
                            <p class="block text-sm font-medium text-gray-500 pointer-events-none">SKU #{{ product.product_sku }}</p>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold">About</h4>
                            <p class="mt-1">
                                {{ product.product_description }}
                            </p>
                            <h4 class="mt-5 text-lg font-bold">Garansi</h4>
                            <p class="mt-1">
                                {{ product.product_guarantee }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400" v-if="isOpen">
            <div class="flex items-end justify-center min-h-screen text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>
                <!-- This element is to trick the browser into centering the modal contents. -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle max-w-lg w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                    <form @submit.prevent="addToCart">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <jet-validation-errors class="mb-4" />
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Tambah ke Keranjang
                            </h3>
                            <div class="mt-2 max-w-xl text-sm text-gray-500">
                                <p>
                                    Silahkan isi jumlah pesanan Anda.
                                </p>
                            </div>
                            <div class="mt-1 w-full sm:max-w-xs">
                                <jet-label for="cart_qty" class="sr-only" value="Cart Qty" />
                                <jet-input id="cart_qty" type="number" class="block w-full" min="1" :max="Number(product.product_stock)" v-model.number="form.cart_qty" ref="cart_qty" />
                                <jet-input-error :message="form.errors.cart_qty" class="mt-2" />
                            </div>
                        </div>
                        <div class="px-6 py-4 bg-gray-100 text-right flex justify-between items-center border border-top">
                            <jet-secondary-button @click="closeModal">
                                Batalkan
                            </jet-secondary-button>
                            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Simpan
                            </jet-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Global notification live region, render this permanently at the end of the document -->
    <div aria-live="assertive" class="fixed inset-0 flex items-end px-4 py-6 pointer-events-none sm:p-6 sm:items-start">
        <div class="w-full flex flex-col items-center space-y-4 sm:items-end">
            <!-- Notification panel, dynamically insert this into the live region when it needs to be displayed -->
            <transition enter-active-class="transform ease-out duration-300 transition" enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2" enter-to-class="translate-y-0 opacity-100 sm:translate-x-0" leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100" leave-to-class="opacity-0">
                <div v-if="show" class="max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden">
                    <div class="p-4">
                        <div class="flex items-center">
                            <div class="w-0 flex-1 flex justify-between">
                                <p class="w-0 flex-1 text-sm font-medium text-gray-900">
                                    {{ status }}
                                </p>
                                <inertia-link :href="route('cart.index')" class="ml-3 flex-shrink-0 self-center bg-white rounded-md text-sm font-medium text-auxyl-green hover:text-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-auxyl-green">
                                    Lihat Keranjang
                                </inertia-link>
                            </div>
                            <div class="ml-4 flex-shrink-0 flex">
                                <button @click="show = false" class="bg-white rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-auxyl-blue">
                                    <span class="sr-only">Close</span>
                                    <XIcon class="h-5 w-5" aria-hidden="true" />
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
    </div>
</template>

<style scoped>

</style>

<script>
import { ref } from 'vue'
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { BellIcon, MenuIcon, XIcon } from '@heroicons/vue/outline'
import {
    BriefcaseIcon,
    CalendarIcon,
    CheckIcon,
    ChevronDownIcon,
    ChevronRightIcon,
    CurrencyDollarIcon,
    HomeIcon,
    LinkIcon,
    LocationMarkerIcon,
    PencilIcon,
    ShoppingCartIcon,
} from '@heroicons/vue/solid'
import JetSecondaryButton from '@/Jetstream/SecondaryButton'
import JetButton from '@/Jetstream/Button'
import JetInput from '@/Jetstream/Input'
import JetInputError from '@/Jetstream/InputError'
import JetLabel from '@/Jetstream/Label'
import JetBanner from '@/Jetstream/Banner'
import JetValidationErrors from '@/Jetstream/ValidationErrors'

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
export default {
    name: 'Product',
    components: {
        Disclosure,
        DisclosureButton,
        DisclosurePanel,
        Menu,
        MenuButton,
        MenuItem,
        MenuItems,
        BellIcon,
        BriefcaseIcon,
        CalendarIcon,
        CheckIcon,
        ChevronDownIcon,
        ChevronRightIcon,
        CurrencyDollarIcon,
        HomeIcon,
        LinkIcon,
        LocationMarkerIcon,
        MenuIcon,
        PencilIcon,
        ShoppingCartIcon,
        XIcon,
        JetButton,
        JetSecondaryButton,
        JetInput,
        JetInputError,
        JetLabel,
        JetBanner,
        JetValidationErrors
    },
    setup() {
        const open = ref(false)
        const show = ref(false)

        return {
            navigation,
            proproduct,
            open,
            show
        }
    },
    data() {
        return {
            form: this.$inertia.form({
                cart_qty: 1,
                product_id: this.product.product_id
            }),
            isOpen: false,
            status: String
        }
    },
    props: {
        canLogin: Boolean,
        canRegister: Boolean,
        product: Object,
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
        },
        showCart() {
            this.isOpen = true
            this.form.cart_qty = this.recentCart
        },
        closeModal: function () {
            this.isOpen = false
        },
        addToCart() {
            try {
                if (this.form.cart_qty > 0) {
                    this.form.post(route('cart.store'), {
                        errorBag: 'addToCart',
                        preserveScroll: true,
                        onSuccess: (page) => {
                            this.closeModal()
                            this.form.reset()
                            this.show = true
                            this.status = page.props.flash.message
                        },
                    });
                } else {
                    alert('Harap masukkan jumlah pesanan!')
                }
            } catch (e) {
                console.log(e)
                alert(e)
            }
        }
    },
    computed: {
        recentCart() {
            return this.product.related_cart ? this.product.related_cart.cart_qty : 0
        }
    }
}
</script>
