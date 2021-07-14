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
                <div class="max-w-3xl mx-auto px-4 sm:px-6 md:flex md:items-center md:justify-between md:space-x-5 lg:max-w-7xl lg:px-8">
                    <div class="flex items-center space-x-5">
                        <div>
                            <h1 class="text-3xl font-bold text-white">Pesanan No. {{ order.order_no }}</h1>
                            <p class="text-base font-medium text-gray-300"><time :datetime="order.order_date">{{ format(parseISO(order.order_date), 'EEEE, dd MMMM yyyy', { locale }) }}</time></p>
                        </div>
                    </div>
                    <div class="mt-6 flex flex-col-reverse justify-stretch space-y-4 space-y-reverse sm:flex-row-reverse sm:justify-end sm:space-x-reverse sm:space-y-0 sm:space-x-3 md:mt-0 md:flex-row md:space-x-3" v-if="!order.order_payment_proof">
                        <button type="button" @click="showUploadForm(order)" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-auxyl-blue bg-auxyl-green hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-auxyl-green">
                            Upload Bukti Bayar
                        </button>
                    </div>
                </div>
            </header>
        </div>

        <main class="-mt-32">
            <div class="max-w-3xl mx-auto grid grid-cols-1 gap-6 sm:px-6 lg:max-w-7xl lg:grid-flow-col-dense lg:grid-cols-3">
                <div class="space-y-6 lg:col-start-1 lg:col-span-2">
                    <section aria-labelledby="applicant-information-title">
                        <div class="bg-white shadow sm:rounded-lg">
                            <div class="px-4 py-5 sm:px-6">
                                <h2 id="applicant-information-title" class="text-lg leading-6 font-medium text-gray-900">
                                    Informasi Pesanan
                                </h2>
                                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                    Berikut adalah detil informasi pesanan Anda:
                                </p>
                            </div>
                            <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                                <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">
                                            Nama Pemesan
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            {{ $page.props.user.name }}
                                        </dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">
                                            Alamat Email
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            {{ $page.props.user.email }}
                                        </dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">
                                            Nama Penerima
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            {{ order.related_delivery.delivery_contact_name }}
                                        </dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">
                                            Nomor Kontak
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            {{ order.related_delivery.delivery_contact_phone }}
                                        </dd>
                                    </div>
                                    <div class="sm:col-span-2">
                                        <dt class="text-sm font-medium text-gray-500">
                                            Alamat Pengiriman
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            {{ order.related_delivery.delivery_address }}
                                        </dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">
                                            Kelurahan/Kode Pos
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            {{ order.related_delivery.delivery_kelurahan }} / {{ order.related_delivery.delivery_zipcode }}
                                        </dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">
                                            Kecamatan
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            {{ order.related_delivery.delivery_kecamatan }}
                                        </dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">
                                            Kabupaten/Kota
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            {{ order.related_delivery.delivery_kabkot }}
                                        </dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">
                                            Provinsi
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            {{ order.related_delivery.delivery_provinsi }}
                                        </dd>
                                    </div>
                                    <div class="sm:col-span-2">
                                        <dt class="text-sm font-medium text-gray-500">
                                            Total Pesanan
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            {{ addCommas(order.order_total) }}
                                        </dd>
                                    </div>
                                    <div class="sm:col-span-2" v-if="order.order_payment_proof">
                                        <dt class="text-sm font-medium text-gray-500">
                                            Bukti Bayar
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            <ul class="border border-gray-200 rounded-md divide-y divide-gray-200">
                                                <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                                    <div class="w-0 flex-1 flex items-center">
                                                        <!-- Heroicon name: solid/paper-clip -->
                                                        <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                            <path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd" />
                                                        </svg>
                                                        <span class="ml-2 flex-1 w-0 truncate">
                                                            {{ order.order_payment_proof }}
                                                        </span>
                                                    </div>
                                                    <div class="ml-4 flex-shrink-0">
                                                        <a :href="order.order_payment_proof" class="font-medium text-blue-600 hover:text-blue-500">
                                                            Lihat
                                                        </a>
                                                    </div>
                                                </li>
                                            </ul>
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                            <div v-if="!order.order_payment_proof">
                                <a href="#" class="block bg-gray-50 text-sm font-medium text-gray-500 text-center px-4 py-4 hover:text-gray-700 sm:rounded-b-lg">
                                    Batalkan Pesanan
                                </a>
                            </div>
                        </div>
                    </section>

                    <!-- Comments-->
                    <section aria-labelledby="products-title">
                        <div class="bg-white shadow sm:rounded-lg sm:overflow-hidden">
                            <div class="divide-y divide-gray-200">
                                <div class="px-4 py-5 sm:px-6">
                                    <h2 id="products-title" class="text-lg font-medium text-gray-900">
                                        Produk Yang Dibeli
                                    </h2>
                                </div>
                                <div class="px-4 py-6 sm:px-6">
                                    <ul class="space-y-8">
                                        <li>
                                            <div v-for="product in order.related_products" :key="product.order_product_id" class="flex space-x-3">
                                                <div class="flex-shrink-0">
                                                    <img class="h-24 sm:h-36 w-24 sm:w-36 object-cover shadow sm:rounded-md sm:overflow-hidden" :src="product.related_photos[0].image_url" @error="imgUrlAlt" v-bind:alt="product.related_photos[0].image_alt_text" />
                                                </div>
                                                <div>
                                                    <div class="text-sm">
                                                        <inertia-link :href="route('product.show', product.product_id)" class="font-medium text-gray-900">
                                                            {{ product.related_product.product_name }}
                                                        </inertia-link>
                                                    </div>
                                                    <div class="mt-1 text-sm text-gray-700">
                                                        <p>
                                                            {{ product.related_product.product_description }}
                                                        </p>
                                                    </div>
                                                    <div class="mt-2 text-sm space-x-2">
                                                        <span class="text-gray-500 font-medium">{{ product.order_product_qty }} item</span>
                                                        <span class="text-gray-500 font-medium">&commat;</span>
                                                        <span class="text-gray-500 font-medium">{{ addCommas(product.order_product_price) }}</span>
                                                        <span class="text-gray-500 font-medium">&middot;</span>
                                                        <span class="text-gray-900 font-medium">{{ addCommas(product.order_product_subtotal) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <section aria-labelledby="timeline-title" class="lg:col-start-3 lg:col-span-1">
                    <div class="bg-white px-4 py-5 shadow sm:rounded-lg sm:px-6">
                        <h2 id="timeline-title" class="text-lg font-medium text-gray-900">Status Pesanan</h2>
                        <div class="mt-6 flow-root">
                            <ul class="-mb-8">
                                <li v-for="status in order.related_statuses" :key="status.status_id">
                                    <div class="relative pb-8">
                                        <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                        <div class="relative flex space-x-3">
                                            <div>
                                                <span class="h-8 w-8 rounded-full bg-auxyl-green flex items-center justify-center ring-8 ring-white">
                                                    <!-- Heroicon name: solid/check -->
                                                    <CheckIcon class="h-5 w-5 text-white"/>
                                                </span>
                                            </div>
                                            <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                <div>
                                                    <p class="text-sm text-gray-500">{{ status.status_action }}</p>
                                                </div>
                                                <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                    <time :datetime="format(parseISO(status.created_at), 'yyyy-MM-dd')">
                                                        {{ format(parseISO(status.created_at), 'yyyy.MM.dd') }}
                                                        <br>
                                                        {{ format(parseISO(status.created_at), 'HH:mm') }}
                                                    </time>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="relative pb-8">
                                        <div class="relative flex space-x-3">
                                            <div>
                                                <span class="h-8 w-8 rounded-full bg-auxyl-green flex items-center justify-center ring-8 ring-white">
                                                    <!-- Heroicon name: solid/user -->
                                                    <UserIcon class="h-5 w-5 text-white"/>
                                                </span>
                                            </div>
                                            <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                <div>
                                                    <p class="text-sm text-gray-500">Pesanan dibuat</p>
                                                </div>
                                                <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                    <time :datetime="format(parseISO(order.created_at), 'yyyy-MM-dd')">
                                                        {{ format(parseISO(order.created_at), 'yyyy.MM.dd') }}
                                                        <br>
                                                        {{ format(parseISO(order.created_at), 'HH:mm') }}
                                                    </time>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </section>
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
                    <form @submit.prevent="submitPaymentProof(form)" enctype="multipart/form-data">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-9 sm:pb-4">
                            <div>
                                <input type="hidden" v-model="form.order_id">
                                <div class="mt-1 border-2 border-gray-300 border-dashed rounded-md px-6 pt-5 pb-6 flex justify-center">
                                    <div class="space-y-1 text-center">
                                        <div v-if="objectURL">
                                            <iframe :src="objectURL" class="h-1/2 w-full border-gray-300 bg-gray-300 overflow-scroll"></iframe>
                                            <div class="flex items-center align-middle justify-center">
                                                <p class="text-xs text-gray-500">
                                                    {{ name }} ({{ size }} kB). &nbsp;
                                                </p>
                                                <button type="button" @click="deleteFile" class="relative text-xs text-red-600 hover:text-red-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-red-500">Hapus</button>
                                            </div>
                                        </div>
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true" v-else>
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600 items-center align-middle justify-center">
                                            <label for="fileUpload" class="relative cursor-pointer bg-white rounded-md font-medium text-auxyl-green hover:text-green-700 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-auxyl-green">
                                                <span>Silahkan pilih file</span>
                                                <input type="file" ref="fileUpload" id="fileUpload" accept="image/*" class="sr-only" @input="form.order_payment_proof = $event.target.files[0]" @change="changeFile" required/>
                                            </label>
                                            <p class="pl-1">atau drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">
                                            Hanya menerima gambar dalam format JPG, JPEG, dan PNG maks. 2MB
                                        </p>
                                    </div>
                                </div>
                                <jet-input-error :message="form.errors.order_payment_proof" class="my-2" />
                            </div>
                        </div>
                        <div class="px-6 py-4 bg-gray-100 text-right flex justify-end">
                            <jet-secondary-button @click="closeModal">
                                Batalkan
                            </jet-secondary-button>
                            <jet-button class="ml-2" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Upload
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
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <CheckIcon class="h-6 w-6 text-green-400" aria-hidden="true" />
                            </div>
                            <div class="ml-3 w-0 flex-1 pt-0.5">
                                <p class="text-sm font-medium text-gray-900">
                                    Berhasil menyimpan!
                                </p>
                                <p class="mt-1 text-sm text-gray-500">
                                    {{ status }}
                                </p>
                            </div>
                            <div class="ml-4 flex-shrink-0 flex">
                                <button @click="show = false" class="bg-white rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
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

<script>
import { ref } from 'vue'
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { BellIcon, MenuIcon, ShoppingCartIcon, ShoppingBagIcon, XIcon } from '@heroicons/vue/outline'
import { TagIcon, CurrencyDollarIcon, ShoppingCartIcon as ShoppingCartIconSolid } from '@heroicons/vue/solid'
import { CalendarIcon, CheckIcon, ChevronRightIcon, UserIcon } from '@heroicons/vue/solid'
import {format} from 'date-fns'
import locale from 'date-fns/locale/id'
import parseISO from 'date-fns/parseISO'
import JetBanner from "@/Jetstream/Banner"
import JetButton from '@/Jetstream/Button'
import JetFormSection from '@/Jetstream/FormSection'
import JetInput from '@/Jetstream/Input'
import JetInputError from '@/Jetstream/InputError'
import JetLabel from '@/Jetstream/Label'
import JetActionMessage from '@/Jetstream/ActionMessage'
import JetSecondaryButton from '@/Jetstream/SecondaryButton'
import JetSectionBorder from '@/Jetstream/SectionBorder'
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
        title: 'Daftar Pesanan',
        url: route('order.index'),
    }
]
export default {
    name: "Order Details",
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
        CheckIcon,
        ChevronRightIcon,
        UserIcon,
        JetBanner,
        JetActionMessage,
        JetButton,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
        JetSecondaryButton,
        JetSectionBorder,
        JetValidationErrors,
    },
    data() {
        return {
            form: this.$inertia.form({
                order_id: this.order.order_id,
                order_payment_proof: null,
            }),
            format,
            locale,
            parseISO,
            status: String,
            uploadForm: Object,
            isOpen: false,
            name: "",
            type: "",
            size: 0,
            lastModified: null,
            lastModifiedDate: null,
            objectURL: null,
            file: null,
        }
    },
    setup() {
        const open = ref(false)
        const show = ref(false)

        return {
            navigation,
            proproduct,
            open,
            show,
        }
    },
    props: {
        canLogin: Boolean,
        canRegister: Boolean,
        order: Object,
    },
    computed: {
        totalProducts() {
            return this.order.related_products.length
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
        showUploadForm: function (data) {
            this.uploadForm = Object.assign({}, data);
            this.form.order_id = this.uploadForm.order_id
            this.form.order_payment_proof = this.uploadForm.order_payment_proof
            this.isOpen = true
        },
        closeModal: function () {
            this.isOpen = false
        },
        submitPaymentProof: function (form) {
            const data = new FormData();
            data.append('order_payment_proof', this.file);
            data.append('order_id', form.order_id);
            this.$inertia.post('/order/upload-payment-proof', data, {
                errorBag: 'submitPaymentProof',
                preserveScroll: true,
                onSuccess: page => {
                    console.log(page)
                    this.closeModal()
                    this.form.reset()
                    this.show = true
                    this.status = page.props.flash.message
                },
                onError : errors => {
                    console.log(errors)
                    this.form.errors = Object.assign({}, errors)
                }
            })
        },
        changeFile(event) {
            if (this.objectURL) {
                URL.revokeObjectURL(this.objectURL);
            }
            console.log(this.objectURL);
            this.file = event.target.files[0];
            this.name = this.file.name;
            this.type = this.file.type;
            this.size = this.file.size / 1000;
            this.lastModifiedDate = this.file.lastModifiedDate;
            this.lastModified = this.file.lastModified;
            this.objectURL = URL.createObjectURL(this.file);
        },
        deleteFile() {
            document.querySelector('#fileUpload').value = ''
            URL.revokeObjectURL(this.objectURL);
            this.objectURL = null
        },
    }
}
</script>

<style scoped>

</style>
