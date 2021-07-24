<template>
    <public-layout>
        <template #header>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:flex lg:items-center lg:justify-between">
                    <div class="flex-1 min-w-0">
                        <nav class="flex" aria-label="Breadcrumb">
                            <ol class="flex items-center space-x-4" role="list">
                                <li>
                                    <div>
                                        <inertia-link href="/" class="text-sm font-medium text-gray-400 hover:text-gray-500">
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
                                        <inertia-link :href="route('category.show', product.category_id)" class="ml-4 text-sm font-medium text-gray-400 hover:text-gray-500">
                                            {{ product.related_category.category_name }}
                                        </inertia-link>
                                    </div>
                                </li>
                                <li>
                                    <div class="flex items-center">
                                        <ChevronRightIcon class="flex-shrink-0 h-5 w-5 text-gray-400" aria-hidden="true" />
                                        <p class="ml-4 text-sm font-medium text-gray-500 line-clamp-1 md:line-clamp-none">
                                            {{ product.product_name }}
                                        </p>
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
        </template>
        
        <div>
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
        </div>
    </public-layout>

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
                                Silahkan isi jumlah pesanan Anda:
                            </p>
                        </div>
                        <div class="mt-1">
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
import { asset } from "@codinglabs/laravel-asset";
import { ref } from 'vue'
import { XIcon } from '@heroicons/vue/outline'
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
import JetValidationErrors from '@/Jetstream/ValidationErrors'
import PublicLayout from "@/Layouts/PublicLayout"

export default {
    name: 'Product',
    components: {
        XIcon,
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
        JetButton,
        JetSecondaryButton,
        JetInput,
        JetInputError,
        JetLabel,
        JetValidationErrors,
        PublicLayout
    },
    setup() {
        const show = ref(false)

        return {
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
