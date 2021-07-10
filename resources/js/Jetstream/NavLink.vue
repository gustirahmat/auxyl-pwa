<template>
    <inertia-link :href="href" :class="classes">
        <slot></slot>
    </inertia-link>
</template>

<!--<template v-for="(item, itemIdx) in navigation" :key="item">-->
<!--    <template v-if="(itemIdx === 0)">-->
<!--         Current: "bg-auxyl-blue text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white"-->
<!--        <a href="#" class="bg-auxyl-blue text-white px-3 py-2 rounded-md text-sm font-medium">{{ item }}</a>-->
<!--    </template>-->
<!--    <a v-else href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">{{ item }}</a>-->
<!--</template>-->
<script>
    export default {
        props: ['href', 'active'],

        computed: {
            classes() {
                return this.active
                            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-auxyl-green text-sm font-medium leading-5 text-auxyl-green focus:outline-none focus:text-white focus:border-white transition'
                            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-white hover:text-auxyl-green hover:border-auxyl-green focus:outline-none focus:text-auxyl-green focus:border-auxyl-green transition'
            }
        }
    }
</script>
