<template>
  <public-layout>
    <template #header>
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-white">Daftar Pesanan SayA</h1>
      </div>
    </template>

    <div>
      <div class="max-w-7xl mx-auto pb-12 px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow px-5 py-6 sm:px-6">
          <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <template v-if="totalOrders">
              <ul class="divide-y divide-gray-200">
                <li v-for="order in orders" :key="order.order_id">
                  <inertia-link
                    :href="route('order.show', order.order_id)"
                    class="block hover:bg-gray-50"
                  >
                    <div class="px-4 py-4 flex items-center sm:px-6">
                      <div
                        class="
                          min-w-0
                          flex-1
                          sm:flex
                          sm:items-center
                          sm:justify-between
                        "
                      >
                        <div class="truncate">
                          <div class="flex items-center justify-between">
                            <p
                              class="
                                text-sm
                                font-medium
                                text-auxyl-blue
                                truncate
                              "
                            >
                              {{ order.order_no }}
                            </p>
                            <div class="ml-2 flex-shrink-0 flex">
                              <p
                                class="
                                  px-2
                                  inline-flex
                                  text-xs
                                  leading-5
                                  font-semibold
                                  rounded-full
                                  bg-green-100
                                  text-green-800
                                "
                              >
                                {{ order.order_status }}
                              </p>
                            </div>
                          </div>
                          <div class="mt-2 flex">
                            <div
                              class="sm:flex items-center text-sm text-gray-500"
                            >
                              <p
                                class="flex items-center text-sm text-gray-500"
                              >
                                <CalendarIcon
                                  class="
                                    flex-shrink-0
                                    mr-1.5
                                    h-5
                                    w-5
                                    text-gray-400
                                  "
                                  aria-hidden="true"
                                />
                                <time :datetime="order.order_date">
                                  {{
                                    format(
                                      parseISO(order.order_date),
                                      "EEEE, dd MMMM yyyy",
                                      { locale }
                                    )
                                  }}
                                </time>
                              </p>
                              <p
                                class="
                                  mt-2
                                  flex
                                  items-center
                                  text-sm text-gray-500
                                  sm:mt-0
                                  sm:ml-6
                                "
                              >
                                <ShoppingBagIcon
                                  class="
                                    flex-shrink-0
                                    mr-1.5
                                    h-5
                                    w-5
                                    text-gray-400
                                  "
                                  aria-hidden="true"
                                />
                                {{ order.related_products.length }} barang
                              </p>
                              <p
                                class="
                                  mt-2
                                  flex
                                  items-center
                                  text-sm text-gray-500
                                  sm:mt-0
                                  sm:ml-6
                                "
                              >
                                <CurrencyDollarIcon
                                  class="
                                    flex-shrink-0
                                    mr-1.5
                                    h-5
                                    w-5
                                    text-gray-400
                                  "
                                  aria-hidden="true"
                                />
                                {{ addCommas(order.order_total) }}
                              </p>
                            </div>
                          </div>
                        </div>
                        <div class="mt-4 flex-shrink-0 sm:mt-0 sm:ml-5">
                          <div class="flex overflow-hidden -space-x-1">
                            <img
                              v-for="product in order.related_products"
                              :key="product.product_id"
                              class="
                                inline-block
                                h-6
                                w-6
                                rounded-full
                                ring-2 ring-white
                              "
                              :src="product.related_photos[0].image_url"
                              @error="imgUrlAlt"
                              v-bind:alt="
                                product.related_photos[0].image_alt_text
                              "
                            />
                          </div>
                        </div>
                      </div>
                      <div class="ml-5 flex-shrink-0">
                        <ChevronRightIcon
                          class="h-5 w-5 text-gray-400"
                          aria-hidden="true"
                        />
                      </div>
                    </div>
                  </inertia-link>
                </li>
              </ul>
            </template>
            <template v-else>
              <div class="relative my-10">
                <div
                  class="absolute inset-0 flex items-center"
                  aria-hidden="true"
                >
                  <div class="w-full border-t border-gray-300" />
                </div>
                <div class="relative flex justify-center">
                  <span class="px-2 bg-white text-sm text-gray-500"
                    >Daftar pesanan kosong. Yuk mulai berbelanja!</span
                  >
                </div>
              </div>
            </template>
          </div>
        </div>
      </div>
    </div>
  </public-layout>
</template>

<script>
import { asset } from "@codinglabs/laravel-asset";
import { ShoppingCartIcon, ShoppingBagIcon } from "@heroicons/vue/outline";
import {
  CurrencyDollarIcon,
  ShoppingCartIcon as ShoppingCartIconSolid,
} from "@heroicons/vue/solid";
import { CalendarIcon, ChevronRightIcon } from "@heroicons/vue/solid";
import { format } from "date-fns";
import locale from "date-fns/locale/id";
import parseISO from "date-fns/parseISO";
import JetBanner from "@/Jetstream/Banner";
import PublicLayout from "@/Layouts/PublicLayout";

export default {
  name: "Order Lists",
  components: {
    ShoppingBagIcon,
    ShoppingCartIcon,
    CurrencyDollarIcon,
    ShoppingCartIconSolid,
    CalendarIcon,
    ChevronRightIcon,
    JetBanner,
    PublicLayout,
  },
  data() {
    return {
      format,
      locale,
      parseISO,
    };
  },
  props: {
    orders: Object,
  },
  computed: {
    totalOrders() {
      return this.orders.length;
    },
  },
  methods: {
    addCommas(nStr) {
      return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        maximumSignificantDigits: 9,
      }).format(nStr);
    },
    imgUrlAlt(event) {
      event.target.src = asset("manifest/playstore.png");
    },
  },
};
</script>

<style scoped>
</style>
