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
                    <img
                      class="block h-9 w-auto"
                      :src="asset('manifest/playstore.png')"
                      alt="Logo"
                    />
                  </inertia-link>
                </div>
                <div class="hidden md:block">
                  <div class="ml-10 flex items-baseline space-x-4">
                    <template v-for="(item, itemIdx) in navigation" :key="item">
                      <template v-if="itemIdx === 0">
                        <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                        <inertia-link
                          :href="item.url"
                          class="
                            bg-gray-900
                            text-white
                            px-3
                            py-2
                            rounded-md
                            text-sm
                            font-medium
                          "
                        >
                          {{ item.title }}
                        </inertia-link>
                      </template>
                      <inertia-link
                        v-else
                        :href="item.url"
                        class="
                          text-gray-300
                          hover:bg-gray-700
                          hover:text-white
                          px-3
                          py-2
                          rounded-md
                          text-sm
                          font-medium
                        "
                      >
                        {{ item.title }}
                      </inertia-link>
                    </template>
                  </div>
                </div>
              </div>
              <div class="hidden md:block">
                <div
                  v-if="$page.props.canLogin"
                  class="ml-4 flex items-center md:ml-6 space-x-3"
                >
                  <template v-if="$page.props.user">
                    <inertia-link :href="route('cart.index')">
                      <button
                        class="
                          bg-auxyl-blue
                          p-1
                          text-gray-400
                          rounded-full
                          hover:text-white
                          focus:outline-none
                          focus:ring-2
                          focus:ring-offset-2
                          focus:ring-offset-gray-800
                          focus:ring-white
                        "
                      >
                        <span class="sr-only">View carts</span>
                        <ShoppingCartIcon class="h-6 w-6" aria-hidden="true" />
                      </button>
                    </inertia-link>
                    <button
                      class="
                        bg-auxyl-blue
                        p-1
                        text-gray-400
                        rounded-full
                        hover:text-white
                        focus:outline-none
                        focus:ring-2
                        focus:ring-offset-2
                        focus:ring-offset-gray-800
                        focus:ring-white
                      "
                    >
                      <span class="sr-only">View notifications</span>
                      <BellIcon class="h-6 w-6" aria-hidden="true" />
                    </button>

                    <!-- Proproduct dropdown -->
                    <Menu as="div" class="ml-3 relative">
                      <div>
                        <MenuButton
                          class="
                            max-w-xs
                            bg-auxyl-blue
                            rounded-full
                            flex
                            items-center
                            text-sm
                          "
                        >
                          <span class="sr-only">Open user menu</span>
                          <button
                            class="
                              flex
                              text-sm
                              border-2 border-transparent
                              rounded-full
                              focus:outline-none
                              focus:border-gray-300
                              transition
                            "
                          >
                            <img
                              class="h-8 w-8 rounded-full object-cover"
                              :src="
                                'https://ui-avatars.com/api/?name=' +
                                $page.props.user.name +
                                '&color=7F9CF5&background=EBF4FF'
                              "
                              v-bind:alt="$page.props.user.name"
                            />
                          </button>
                        </MenuButton>
                      </div>
                      <transition
                        enter-active-class="transition ease-out duration-100"
                        enter-from-class="transform opacity-0 scale-95"
                        enter-to-class="transform opacity-100 scale-100"
                        leave-active-class="transition ease-in duration-75"
                        leave-from-class="transform opacity-100 scale-100"
                        leave-to-class="transform opacity-0 scale-95"
                      >
                        <MenuItems
                          class="
                            origin-top-right
                            absolute
                            right-0
                            mt-2
                            w-48
                            rounded-md
                            shadow-lg
                            py-1
                            bg-white
                            ring-1 ring-black ring-opacity-5
                            focus:outline-none
                          "
                        >
                          <div class="block px-4 py-2 text-xs text-gray-400">
                            Pengaturan
                          </div>
                          <MenuItem
                            v-for="item in proproduct"
                            :key="item"
                            v-slot="{ active }"
                          >
                            <inertia-link
                              :href="item.url"
                              :class="[
                                active ? 'bg-gray-100' : '',
                                'block px-4 py-2 text-sm text-gray-700',
                              ]"
                            >
                              {{ item.title }}
                            </inertia-link>
                          </MenuItem>
                        </MenuItems>
                      </transition>
                    </Menu>
                    <!-- Authentication -->
                    <form @submit.prevent="logout">
                      <button
                        type="submit"
                        class="
                          text-gray-300
                          hover:bg-gray-700
                          hover:text-white
                          px-3
                          py-2
                          rounded-md
                          text-sm
                          font-medium
                        "
                      >
                        Log Out
                      </button>
                    </form>
                  </template>
                  <template v-else>
                    <inertia-link
                      :href="route('login')"
                      class="
                        text-gray-300
                        hover:bg-gray-700
                        hover:text-white
                        px-3
                        py-2
                        rounded-md
                        text-sm
                        font-medium
                      "
                    >
                      Masuk
                    </inertia-link>

                    <inertia-link
                      v-if="$page.props.canRegister"
                      :href="route('register')"
                      class="
                        text-gray-300
                        hover:bg-gray-700
                        hover:text-white
                        px-3
                        py-2
                        rounded-md
                        text-sm
                        font-medium
                      "
                    >
                      Daftar
                    </inertia-link>
                  </template>
                </div>
              </div>
              <div class="flex md:hidden space-x-1">
                <inertia-link :href="route('cart.index')">
                  <button
                    class="
                      bg-auxyl-blue
                      inline-flex
                      items-center
                      justify-center
                      p-2
                      rounded-md
                      text-gray-400
                      hover:text-white
                      hover:bg-gray-700
                      focus:outline-none
                      focus:ring-2
                      focus:ring-offset-2
                      focus:ring-offset-gray-800
                      focus:ring-white
                    "
                  >
                    <span class="sr-only">View carts</span>
                    <ShoppingCartIcon
                      class="block h-6 w-6"
                      aria-hidden="true"
                    />
                  </button>
                </inertia-link>
                <!-- Mobile menu button -->
                <DisclosureButton
                  class="
                    bg-auxyl-blue
                    inline-flex
                    items-center
                    justify-center
                    p-2
                    rounded-md
                    text-gray-400
                    hover:text-white
                    hover:bg-gray-700
                    focus:outline-none
                    focus:ring-2
                    focus:ring-offset-2
                    focus:ring-offset-gray-800
                    focus:ring-white
                  "
                >
                  <span class="sr-only">Open main menu</span>
                  <MenuIcon
                    v-if="!open"
                    class="block h-6 w-6"
                    aria-hidden="true"
                  />
                  <XIcon v-else class="block h-6 w-6" aria-hidden="true" />
                </DisclosureButton>
              </div>
            </div>
          </div>
        </div>

        <DisclosurePanel class="border-b border-auxyl-green md:hidden">
          <div class="px-2 py-3 space-y-1 sm:px-3">
            <template v-for="(item, itemIdx) in navigation" :key="item">
              <template v-if="itemIdx === 0">
                <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                <inertia-link
                  :href="item.url"
                  class="
                    bg-gray-900
                    text-white
                    block
                    px-3
                    py-2
                    rounded-md
                    text-base
                    font-medium
                  "
                >
                  {{ item.title }}
                </inertia-link>
              </template>
              <inertia-link
                v-else
                :href="item.url"
                class="
                  text-gray-300
                  hover:bg-gray-700
                  hover:text-white
                  block
                  px-3
                  py-2
                  rounded-md
                  text-base
                  font-medium
                "
              >
                {{ item.title }}
              </inertia-link>
            </template>
          </div>
          <div class="pt-4 pb-3 border-t border-auxyl-green">
            <template v-if="$page.props.user">
              <div class="flex items-center px-5">
                <div class="flex-shrink-0">
                  <img
                    class="h-10 w-10 rounded-full"
                    :src="
                      'https://ui-avatars.com/api/?name=' +
                      $page.props.user.name +
                      '&color=7F9CF5&background=EBF4FF'
                    "
                    v-bind:alt="$page.props.user.name"
                  />
                </div>
                <div class="ml-3">
                  <div class="text-base font-medium leading-none text-white">
                    {{ $page.props.user.name }}
                  </div>
                  <div class="text-sm font-medium leading-none text-gray-400">
                    {{ $page.props.user.email }}
                  </div>
                </div>
                <button
                  class="
                    ml-auto
                    bg-auxyl-blue
                    flex-shrink-0
                    p-1
                    text-gray-400
                    rounded-full
                    hover:text-white
                    focus:outline-none
                    focus:ring-2
                    focus:ring-offset-2
                    focus:ring-offset-gray-800
                    focus:ring-white
                  "
                >
                  <span class="sr-only">View notifications</span>
                  <BellIcon class="h-6 w-6" aria-hidden="true" />
                </button>
              </div>
              <div class="mt-3 px-2 space-y-1">
                <inertia-link
                  :href="route('profile.show')"
                  class="
                    block
                    px-3
                    py-2
                    rounded-md
                    text-base
                    font-medium
                    text-gray-400
                    hover:text-white
                    hover:bg-gray-700
                  "
                >
                  Profil Saya
                </inertia-link>
                <inertia-link
                  :href="route('order.index')"
                  class="
                    block
                    px-3
                    py-2
                    rounded-md
                    text-base
                    font-medium
                    text-gray-400
                    hover:text-white
                    hover:bg-gray-700
                  "
                >
                  Daftar Pesanan
                </inertia-link>
                <!-- Authentication -->
                <form @submit.prevent="logout">
                  <button
                    type="submit"
                    class="
                      block
                      px-3
                      py-2
                      rounded-md
                      text-base
                      font-medium
                      text-gray-400
                      hover:text-white
                      hover:bg-gray-700
                    "
                  >
                    Log Out
                  </button>
                </form>
              </div>
            </template>
            <template v-else>
              <inertia-link
                :href="route('login')"
                class="
                  block
                  px-3
                  py-2
                  rounded-md
                  text-base
                  font-medium
                  text-gray-400
                  hover:text-white
                  hover:bg-gray-700
                "
              >
                Masuk
              </inertia-link>

              <inertia-link
                v-if="$page.props.canRegister"
                :href="route('register')"
                class="
                  block
                  px-3
                  py-2
                  rounded-md
                  text-base
                  font-medium
                  text-gray-400
                  hover:text-white
                  hover:bg-gray-700
                "
              >
                Daftar
              </inertia-link>
            </template>
          </div>
        </DisclosurePanel>
      </Disclosure>

      <!-- Page Heading -->
      <header class="py-10" v-if="$slots.header">
        <slot name="header"></slot>
      </header>
    </div>

    <!-- Page Content -->
    <main class="-mt-32">
      <slot></slot>
    </main>
  </div>
</template>

<script>
import { ref } from "vue";
import {
  Disclosure,
  DisclosureButton,
  DisclosurePanel,
  Menu,
  MenuButton,
  MenuItem,
  MenuItems,
} from "@headlessui/vue";
import {
  BellIcon,
  MenuIcon,
  ShoppingCartIcon,
  XIcon,
} from "@heroicons/vue/outline";
import JetBanner from "@/Jetstream/Banner";

const navigation = [
  {
    title: "Beranda",
    url: route("home"),
  },
  {
    title: "Kategori",
    url: route("category.index"),
  },
  {
    title: "Promo",
    url: "/promo",
  },
];
const proproduct = [
  {
    title: "Profil Saya",
    url: route("profile.show"),
  },
  {
    title: "Daftar Pesanan",
    url: route("order.index"),
  },
];
export default {
  name: "PublicLayout",
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
    JetBanner,
  },
  setup() {
    const open = ref(false);

    return {
      navigation,
      proproduct,
      open,
    };
  },
  props: {
    appName: String,
  },
  methods: {
    logout() {
      this.$inertia.post(route("logout"));
    },
  },
};
</script>

<style scoped>
</style>
