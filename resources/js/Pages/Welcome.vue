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
            <div class="max-width mx-auto">
                <div class="mr-4 ml-4 md:m-0">
                    <!-- 
                        Not Loading 
                    -->
                    <div v-if="isLoading === false">
                        <!-- Regions -->
                        <div class="mb-4 text-white">
                            <div class="bg-black">
                                <button :class="defaultClass" @click="region = 'default'">All Regions</button>
                                <button :class="westCoastClass" @click="region = 'west-coast'">West Coast</button>
                                <button :class="midWestClass" @click="region = 'midwest'">Midwest</button>
                            </div>
                        </div>
                        <div v-if="matchedItems" class="text-white">
                            <!-- Concerts -->
                            <div v-if="matchedItems.length > 0">
                                <!-- Event -->
                                <div v-for="concert in matchedItems" class="mb-4">

                                    <div class="md:hidden bg-black text-white">
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
                            </div>
                            <!-- No Concerts -->
                            <div v-else class="bg-black text-white p-4">
                                There are no concerts at this time.
                            </div>
                        </div>
                        <!-- No Concerts -->
                        <div v-else class="bg-black text-white p-4">
                            There are no concerts at this time.
                        </div>
                    </div>
                    <!-- Loading -->
                    <div v-else class="text-white">
                        Loading
                    </div>
                </div>
            </div>
        </div>

        <Footer page="concerts" />
    </div>
</template>

<script>
    import Header from '@/Pages/Partials/Header'
    import Footer from '@/Pages/Partials/Footer'

    export default {
        components: {
            Header, Footer
        },
        mounted() {
            this.getConcerts()
        },
        data() {
            return {
                // Concerts
                concerts: [],
                matchedItems: [],
                region: 'default',
                defaultClass: 'active-location-tab',
                westCoastClass: 'location-tab',
                midWestClass: 'location-tab',
                isLoading: false,
            }
        },
        methods: {
            getConcerts: function() {
                axios.get('/data/concerts.json')
                .then((response) => {
                    if(response.data) {
                        this.concerts = response.data
                    }
                }).catch(error => {
                    console.log(error)
                });
            },
            filterConcerts() {
                // Default
                if(this.region == 'default') {
                    this.matchedItems = this.concerts
                } 
                // Selected Region
                else {
                    this.matchedItems = []
                    for(var i=0;i<this.concerts.length;i++) {
                        if(this.concerts[i].venue) {
                            if(this.concerts[i].venue[0]) {
                                if(this.concerts[i].venue[0].region == this.region) {
                                    this.matchedItems.push(this.concerts[i])
                                }
                            }  
                        }

                    }
                }
            }
        },
        watch: {
            concerts: {
                handler() {
                    if(this.concerts) {
                        if(this.concerts.length > 0) {
                            this.matchedItems = this.concerts
                        }
                    }
                },
                deep:true
            },
            region: function() {
                // Default
                if(this.region == 'default') {
                    this.defaultClass = 'active-location-tab'
                    this.westCoastClass = 'location-tab'
                    this.midWestClass = 'location-tab'
                }
                // West Coast
                if(this.region == 'west-coast') {
                    this.defaultClass = 'location-tab'
                    this.westCoastClass = 'active-location-tab'
                    this.midWestClass = 'location-tab'
                }
                // Midwest
                if(this.region == 'midwest') {
                    this.defaultClass = 'location-tab'
                    this.westCoastClass = 'location-tab'
                    this.midWestClass = 'active-location-tab'
                }
                this.filterConcerts()
            }
        }
    }
</script>
