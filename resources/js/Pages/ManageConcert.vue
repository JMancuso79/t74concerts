<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <div class="p-6 sm:px-20 bg-white border-b border-gray-200">

                        <div class="mt-8 text-2xl">
                            Welcome Tower74!
                        </div>

                    </div>

                    <div class="p-6 sm:px-20 bg-gray-200 bg-opacity-25">
                        <a class="block p-2 border-2 border-black pointer text-center font-bold" :href="'/box-office/'+id">
                            Box Office
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    //import Welcome from '@/Jetstream/Welcome'

    export default {
        props: ['id'],
        components: {
            AppLayout,
            //Welcome,
        },
    }
</script>
