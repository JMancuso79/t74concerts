<template>
    <div class="feat-bg bottom-spacer">
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
                        <a :href="'/venue/'+concert.venue[0].slug" class="block text-venue text-gray-400">
                            Venue: {{concert.venue[0].name}}
                        </a>
                        <p class="mt-2 text-gray-400">{{concert.details}}</p>
                        <p class="mt-2">
                            <a class="ticket-button block w-full" :href="'/tickets/'+concert.slug">Buy Tickets</a>
                        </p>
                    </div>
                </div>

                <div class="hidden md:flex bg-black p-2">
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
                            <a :href="'/venue/'+concert.venue[0].slug" class="block text-venue text-gray-400">
                                Venue: {{concert.venue[0].name}}
                            </a>
                            <p class="mt-2 text-gray-400">{{concert.details}}</p>
                            <p class="mt-2 text-right">
                                <a class="ticket-button" :href="'/tickets/'+concert.slug">Buy Tickets</a>
                            </p>
                        </div>
                    </div>
                </div>

            </div> 
        </div>
    </div>
</template>

<script>
    import Header from '@/Pages/Partials/Header'

    export default {
        components: {
            Header,
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
