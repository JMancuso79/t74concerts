<template>
    <div class="bg-black">
        <div class="container mx-auto">
            <div class="mx-auto pt-4" style="max-width:220px;">
                <a href="/">
                    <img src="/images/logo-stroke-red.png" />
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