<template>
    <div class="bg-white min-h-screen px-4 py-16 sm:px-6 sm:py-24 md:grid md:place-items-center lg:px-8">
        <div class="max-w-max mx-auto">
            <main class="sm:flex">
                <p class="text-4xl font-extrabold text-auxyl-green sm:text-5xl">{{ status }}</p>
                <div class="sm:ml-6">
                    <div class="sm:border-l sm:border-gray-200 sm:pl-6">
                        <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight sm:text-5xl">{{ title }}</h1>
                        <p class="mt-1 text-base text-gray-500">{{ description }}</p>
                    </div>
                    <div class="mt-10 sm:border-l sm:border-transparent sm:pl-6">
                        <inertia-link href="/" class="text-base font-medium text-auxyl-green hover:text-green-700">
                            Kembali ke Beranda<span aria-hidden="true"> &rarr;</span>
                        </inertia-link>
                    </div>
                </div>
            </main>
        </div>
    </div>
</template>

<script>
export default {
    name: "Error",
    props: {
        status: Number,
    },
    computed: {
        title() {
            return {
                503: 'Service Unavailable',
                500: 'Server Error',
                404: 'Page Not Found',
                403: 'Forbidden',
            }[this.status]
        },
        description() {
            return {
                503: 'Sorry, we are doing some maintenance. Please check back soon.',
                500: 'Whoops, something went wrong on our servers.',
                404: 'Sorry, the page you are looking for could not be found.',
                403: 'Sorry, you are forbidden from accessing this page.',
            }[this.status]
        },
    },
}
</script>

<style scoped>

</style>