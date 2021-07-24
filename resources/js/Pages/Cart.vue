<template>
    <public-layout>
        <template #header>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold text-white">
                    Keranjang Saya
                </h1>
            </div>
        </template>

        <div>
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
                                                            <ShoppingCartIcon class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" aria-hidden="true" />
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
        </div>
    </public-layout>

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
import { asset } from "@codinglabs/laravel-asset";
import { ref } from 'vue'
import { XIcon } from '@heroicons/vue/outline'
import { TagIcon, CurrencyDollarIcon, ShoppingCartIcon } from '@heroicons/vue/solid'
import JetSecondaryButton from '@/Jetstream/SecondaryButton'
import JetButton from '@/Jetstream/Button'
import JetInput from '@/Jetstream/Input'
import JetInputError from '@/Jetstream/InputError'
import JetLabel from '@/Jetstream/Label'
import JetValidationErrors from '@/Jetstream/ValidationErrors'
import JetFormSection from '@/Jetstream/FormSection'
import JetActionMessage from '@/Jetstream/ActionMessage'
import PublicLayout from "@/Layouts/PublicLayout"

export default {
    name: "Cart",
    components: {
        XIcon,
        TagIcon,
        CurrencyDollarIcon,
        ShoppingCartIcon,
        JetButton,
        JetSecondaryButton,
        JetInput,
        JetInputError,
        JetLabel,
        JetValidationErrors,
        JetFormSection,
        JetActionMessage,
        PublicLayout
    },
    setup() {
        const show = ref(false)

        return {
            show
        }
    },
    props: {
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
