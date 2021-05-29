<template>
    <div class="bg-black">
        <!--<div v-if="page != 'booking'" class="max-width mx-auto mb-4">
            <div class="bg-black ml-4 mr-4 md:m-0 p-2">
                <a href="/booking">
                    <img src="/images/atg-booking.jpg" style="width:100%;" />
                </a>
            </div>
        </div>
        <ArtistWave />-->
        <div class="mx-auto pt-4" style="max-width:240px;">
            <a href="/">
                <img src="/images/tower74-black-logo-1.jpg" />
            </a>
        </div>
        <div class="bg-black">
            <div class="max-width mx-auto p-4">
                <a href="/login">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="#333">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</template>

<script>
import ArtistWave from '@/Pages/Partials/ArtistWave'

    export default {
        components: {
            ArtistWave
        },
        props: ['page']

    }
</script>