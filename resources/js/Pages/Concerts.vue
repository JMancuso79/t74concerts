<template>
    <div class="feat-bg bottom-spacer">
        <!-- 
            Header
        -->
        <Header />
        <!-- 
            Content 
        -->
        <div class="top-spacer mb-4">
            <div class="max-width mx-auto">
                <div v-for="concert in matchedConcerts" class="bg-gray-200 m-4 p-4">
                    <div v-if="concert.filename != null">
                        <img :src="concert.filename" />
                    </div>
                    <!-- Image
                    <img v-if="concert.filename != null && concert.filename != ''" class="w-full" :src="concert.filename" :alt="concert.title">
                     -->
                    <!-- Date -->
                    <div>
                        {{concert.event.date_time}} 
                    </div>
                    <!-- Title -->
                    <div class="font-bold pb-2 text-lg">
                        {{concert.title}}
                    </div>
                    <div class="pb-2">
                        <span class="font-bold">Tickets</span>
                        <!-- Tickets -->
                        <div v-if="concert.onsale">
                            <div v-for="ticket in concert.tickets" class="capitalize mb-1">
                                ${{ticket.price}} {{ticket.label}}
                            </div>
                            <!-- Ticket Link -->
                            <div v-if="concert.event.ticket_link" class="pb-2">
                                <a class="bg-gray-600 pl-2 pr-2 pt-1 pb-1 mr-1 text-white font-bold" :href="concert.event.ticket_link">
                                    Buy Tickets
                                </a>
                            </div>
                        </div>
                        <!-- Off Sale -->
                        <div v-else>
                            Online sales are not available for this concert.
                        </div>
                    </div>
                    <!-- Artists -->
                    <div v-if="concert.artists.length > 0" class="pb-2">
                        <span class="font-bold">Artists</span>
                        <div v-for="artist in concert.artists">
                            {{artist.name}}
                            <div v-if="artist.image">
                                <!--<img :src="artist.image" />-->
                            </div>
                        </div>
                    </div>
                    <!-- Details -->
                    <div v-if="concert.body != null && concert.body != ''" class="pb-2">
                        <div class="font-bold">Details</div> 
                        {{concert.body}}
                    </div>
                    <!-- Venue -->
                    <div v-if="concert.event.venue" class="pb-2">
                        <span class="font-bold">Venue</span> 
                        <div v-if="concert.event.venue.image">
                            <!--<img :src="concert.event.venue.image" />-->
                        </div>
                        <div>
                            {{concert.event.venue.name}}
                        </div>
                        <div>
                            {{concert.event.venue.street_address}}
                        </div>
                        <div>
                            {{concert.event.venue.city}}, {{concert.event.venue.state}} {{concert.event.venue.zip_code}}
                        </div>
                    </div>
                    <!-- Genres -->
                    <div v-if="concert.genres">
                        <span class="bg-gray-600 pl-2 pr-2 pt-1 pb-1 mr-1 text-white" v-for="genre in concert.genres">
                            {{genre.name}}
                        </span>
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
        data() {
            return {
                isLoading: false,  
                concerts: [],
                matchedConcerts: [],
                keyword: null,
                filters: []
            }
        },
        mounted() {
            this.getConcerts()
        },
        methods: {
            getConcerts: function() {
                axios.get('https://api.artistwave.com/api/get/page-concerts/91')
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
        watch: {
            concerts: {
                handler() {
                    this.matchedConcerts = []
                    // Default
                    if(this.keyword === null) {
                        for(var i=0;i<this.concerts.length;i++) {
                            let isOnSale = false
                            if(this.concerts[i].tickets) {
                                for(var x=0;x<this.concerts[i].tickets.length;x++) {
                                    if(this.concerts[i].tickets[x].status === 1) {
                                        isOnSale = true
                                    }
                                }
                            }
                            this.concerts[i].onsale = isOnSale
                            this.matchedConcerts.push(this.concerts[i])
                        }
                    }
                },
                deep:true
            }
        }
    }
</script>
