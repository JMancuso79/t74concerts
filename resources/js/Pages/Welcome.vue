<template>
    <div class="feat-bg">
        <!-- 
            Header
        -->
        <Header />
        <!-- 
            Content 
        -->
        <div class="top-spacer">
            <!-- Event -->
            <div v-for="concert in concerts" class="max-width mx-auto mb-4">

                <div class="md:hidden bg-black mb-4 ml-4 mr-4 text-white">
                    <img class="w-full" :src="concert.imageFull" :alt="concert.title">
                    <div class="p-4 w-full">
                        <p class="text-date font-bold uppercase">{{concert.dateHuman}} | {{concert.time}}</p>
                        <div class="uppercase text-title">
                            {{concert.title}}
                        </div>
                        <div>
                            <span class="text-venue text-gray-400">
                                {{concert.venue[0].name}}
                            </span> {{concert.venue[0].city}}, {{concert.venue[0].state}}
                        </div>
                        <p v-if="concert.details.length < 72" class="mt-2 text-gray-400">{{concert.details}}</p>
                        <p v-else class="mt-2 text-gray-400">{{concert.details.substring(0, 72)}}... <a :href="'/tickets/'+concert.slug"><strong>Read More</strong></a></p>
                        <p class="mt-2">
                            <a class="ticket-button block w-full" :href="'/tickets/'+concert.slug">Buy Tickets</a>
                        </p>
                    </div>
                </div>

                <div class="hidden md:flex bg-black p-2 mb-4">
                    <div class="flex-none w-48">
                        <!-- This item will not grow -->
                        <div class="grid justify-items-center items-center">
                            <img class="w-full" :src="concert.image" :alt="concert.title">
                        </div>
                    </div>
                    <div class="flex-grow">
                         <div class="p-4 w-full">
                            <p class="text-date font-bold uppercase">{{concert.dateHuman}} | {{concert.time}}</p>
                            <div class="uppercase text-title">
                                {{concert.title}}
                            </div>
                            <div class="text-gray-400">
                                <span class="text-venue">
                                    {{concert.venue[0].name}}
                                </span> {{concert.venue[0].city}}, {{concert.venue[0].state}}
                            </div>
                            <p v-if="concert.details.length < 120" class="mt-2 text-gray-400">{{concert.details}}</p>
                            <p v-else class="mt-2 text-gray-400">{{concert.details.substring(0, 120)}}... <a :href="'/tickets/'+concert.slug"><strong>Read More</strong></a></p>
                            <p class="mt-2 text-right">
                                <a class="ticket-button" :href="'/tickets/'+concert.slug">Buy Tickets</a>
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            <ArtistWave />

        </div>

        <Footer />
    </div>
</template>

<script>
    import Header from '@/Pages/Partials/Header'
    import Footer from '@/Pages/Partials/Footer'
    import ArtistWave from '@/Pages/Partials/ArtistWave'

    export default {
        components: {
            Header, ArtistWave, Footer
        },
        props: {
            canLogin: Boolean,
            canRegister: Boolean,
        },
        data() {
            return {
                // Concerts
                concerts: []
            }
        },
        methods: {
            getConcerts: function() {
                axios.get('/data/concerts.json')
                .then((response) => {
                    console.log(response.data)
                    if(response.data) {
                        this.concerts = response.data
                    }

                }).catch(error => {
                    console.log(error)
                });
            },
        },
        mounted() {
            this.getConcerts()
        }
    }
</script>
