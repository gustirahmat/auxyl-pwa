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
                    <h1 class="text-3xl font-bold text-white">
                        Keranjang Saya
                    </h1>
                </div>
            </header>
        </div>

        <main class="-mt-32">
            <div class="max-w-7xl mx-auto pb-12 px-4 sm:px-6 lg:px-8">
                <div class="bg-white rounded-lg shadow px-5 py-6 sm:px-6">
                    <template v-if="totalCarts">
                        <ul class="divide-y divide-gray-200">
                            <li v-for="cart in carts" :key="cart.id">
                                <inertia-link :href="route('product.show', cart.product_id)" class="block hover:bg-gray-50 py-1">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <img :src="cart.related_product.related_photos[0].image_url" @error="imgUrlAlt" v-bind:alt="cart.related_product.related_photos[0].image_alt_text" class="object-cover rounded-lg h-full w-16 sm:w-32 border border-gray-300 bg-white"/>
                                        </div>
                                        <div class="block w-full">
                                            <div class="p-2 sm:py-4 sm:px-6">
                                                <p class="text-sm font-medium text-auxyl-blue truncate">
                                                    {{ cart.related_product.product_name }}
                                                </p>
                                                <div class="mt-2 sm:flex sm:justify-between">
                                                    <div class="sm:flex">
                                                        <p class="flex items-center text-sm text-gray-500">
                                                            <TagIcon class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" aria-hidden="true" />
                                                            Kategori {{ cart.related_product.related_category.category_name }}
                                                        </p>
                                                        <p class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0 sm:ml-6">
                                                            <ShoppingCartIconSolid class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" aria-hidden="true" />
                                                            Jumlah Pesanan : {{ cart.cart_qty }}
                                                        </p>
                                                    </div>
                                                    <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                                                        <CurrencyDollarIcon class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" aria-hidden="true" />
                                                        <p>
                                                            {{ addCommas(cart.product_price) }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </inertia-link>
                            </li>
                        </ul>
                        <div class="relative my-10">
                            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                <div class="w-full border-t border-gray-300" />
                            </div>
                            <div class="relative flex justify-center">
                                <span class="px-2 bg-white text-sm text-gray-500">Lanjutkan</span>
                            </div>
                        </div>
                        <jet-form-section @submitted="submitOrder">
                            <template #title>
                                Informasi Pengiriman
                            </template>

                            <template #description>
                                Silahkan lengkapi form berikut sebelum melanjutkan pesanan Anda.
                            </template>

                            <template #form>
                                <!-- Name -->
                                <div class="col-span-6 sm:col-span-4">
                                    <jet-label for="name" value="Name" />
                                    <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" autocomplete="name" />
                                    <jet-input-error :message="form.errors.name" class="mt-2" />
                                </div>

                                <!-- Phone -->
                                <div class="col-span-6 sm:col-span-4">
                                    <jet-label for="phone" value="Phone" />
                                    <jet-input id="phone" type="tel" class="mt-1 block w-full" v-model.number="form.phone" />
                                    <jet-input-error :message="form.errors.phone" class="mt-2" />
                                </div>

                                <!-- Delivery Address -->
                                <div class="col-span-6 sm:col-span-4">
                                    <jet-label for="address" value="Delivery Address" />
                                    <jet-input id="address" type="text" class="mt-1 block w-full" v-model="form.address" />
                                    <jet-input-error :message="form.errors.address" class="mt-2" />
                                </div>

                                <!-- Zipcode -->
                                <div class="col-span-6 sm:col-span-4">
                                    <jet-label for="zipcode" value="Zipcode" />
                                    <jet-input id="zipcode" type="text" class="mt-1 block w-full" v-model.number="form.zipcode" />
                                    <jet-input-error :message="form.errors.zipcode" class="mt-2" />
                                </div>

                                <!-- Kelurahan -->
                                <div class="col-span-6 sm:col-span-4">
                                    <jet-label for="kelurahan" value="Kelurahan" />
                                    <jet-input id="kelurahan" type="text" class="mt-1 block w-full" v-model="form.kelurahan" />
                                    <jet-input-error :message="form.errors.kelurahan" class="mt-2" />
                                </div>

                                <!-- Kecamatan -->
                                <div class="col-span-6 sm:col-span-4">
                                    <jet-label for="kecamatan" value="Kecamatan" />
                                    <jet-input id="kecamatan" type="text" class="mt-1 block w-full" v-model="form.kecamatan" />
                                    <jet-input-error :message="form.errors.kecamatan" class="mt-2" />
                                </div>

                                <!-- City -->
                                <div class="col-span-6 sm:col-span-4">
                                    <jet-label for="city" value="Kabupaten/Kota" />
                                    <jet-input id="city" type="text" class="mt-1 block w-full" v-model="form.city" />
                                    <jet-input-error :message="form.errors.city" class="mt-2" />
                                </div>

                                <!-- Province -->
                                <div class="col-span-6 sm:col-span-4">
                                    <jet-label for="province" value="Province" />
                                    <jet-input id="province" type="text" class="mt-1 block w-full" v-model="form.province" />
                                    <jet-input-error :message="form.errors.province" class="mt-2" />
                                </div>
                            </template>

                            <template #actions>
                                <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                                    {{ status }}
                                </jet-action-message>

                                <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Lanjutkan ke Pembayaran
                                </jet-button>
                            </template>
                        </jet-form-section>
                    </template>
                    <template v-else>
                        <div class="relative my-10">
                            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                <div class="w-full border-t border-gray-300" />
                            </div>
                            <div class="relative flex justify-center">
                                <span class="px-2 bg-white text-sm text-gray-500">Keranjang belanja kosong.</span>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </main>
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
                                <inertia-link :href="route('order.index')" class="ml-3 flex-shrink-0 self-center bg-white rounded-md text-sm font-medium text-auxyl-green hover:text-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-auxyl-green">
                                    Lihat Pesanan
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
import { BellIcon, MenuIcon, ShoppingCartIcon, XIcon } from '@heroicons/vue/outline'
import { TagIcon, CurrencyDollarIcon, ShoppingCartIcon as ShoppingCartIconSolid } from '@heroicons/vue/solid'
import JetSecondaryButton from '@/Jetstream/SecondaryButton'
import JetButton from '@/Jetstream/Button'
import JetInput from '@/Jetstream/Input'
import JetInputError from '@/Jetstream/InputError'
import JetLabel from '@/Jetstream/Label'
import JetBanner from '@/Jetstream/Banner'
import JetValidationErrors from '@/Jetstream/ValidationErrors'
import JetFormSection from '@/Jetstream/FormSection'
import JetActionMessage from '@/Jetstream/ActionMessage'

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
const positions = [
    {
        id: 1,
        title: 'Back End Developer',
        type: 'Full-time',
        location: 'Remote',
        department: 'Engineering',
        closeDate: '2020-01-07',
        closeDateFull: 'January 7, 2020',
    },
    {
        id: 2,
        title: 'Front End Developer',
        type: 'Full-time',
        location: 'Remote',
        department: 'Engineering',
        closeDate: '2020-01-07',
        closeDateFull: 'January 7, 2020',
    },
    {
        id: 3,
        title: 'User Interface Designer',
        type: 'Full-time',
        location: 'Remote',
        department: 'Design',
        closeDate: '2020-01-14',
        closeDateFull: 'January 14, 2020',
    },
]
export default {
    name: "Cart",
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
        ShoppingCartIcon,
        XIcon,
        TagIcon,
        CurrencyDollarIcon,
        ShoppingCartIconSolid,
        JetButton,
        JetSecondaryButton,
        JetInput,
        JetInputError,
        JetLabel,
        JetBanner,
        JetValidationErrors,
        JetFormSection,
        JetActionMessage
    },
    setup() {
        const open = ref(false)
        const show = ref(false)

        return {
            navigation,
            proproduct,
            positions,
            open,
            show
        }
    },
    props: {
        appName: String,
        canLogin: Boolean,
        canRegister: Boolean,
        carts: Object,
    },
    data() {
        return {
            form: this.$inertia.form({
                carts: this.carts,
                name: this.$page.props.user.name,
                phone: this.$page.props.user.phone,
                address: this.$page.props.user.related_customer ? this.$page.props.user.related_customer.customer_address : '',
                zipcode: this.$page.props.user.related_customer ? this.$page.props.user.related_customer.customer_zipcode : '',
                kelurahan: this.$page.props.user.related_customer ? this.$page.props.user.related_customer.customer_kelurahan : '',
                kecamatan: this.$page.props.user.related_customer ? this.$page.props.user.related_customer.customer_kecamatan : '',
                city: this.$page.props.user.related_customer ? this.$page.props.user.related_customer.customer_kabkot : '',
                province: this.$page.props.user.related_customer ? this.$page.props.user.related_customer.customer_provinsi : '',
            }),
            status: String
        }
    },
    computed: {
        totalCarts() {
            return this.carts.length
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
        },
        submitOrder() {
            this.form.post(route('order.store'), {
                errorBag: 'submitOrder',
                preserveScroll: true,
                onSuccess: (page) => {
                    this.form.reset()
                    this.show = true
                    this.status = page.props.flash.message
                },
                // onError: () => this.$refs.password.focus(),
                onFinish: () => this.form.reset(),
            });
        }
    },
}
</script>
