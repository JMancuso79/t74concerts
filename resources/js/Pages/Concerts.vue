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
            <div class="max-width mx-auto">
                <div v-for="concert in matchedConcerts" class="bg-white p-4 border-bottom">
                    <div v-if="concert.filename != null">
                        <a :href="'/concert/'+concert.slug">
                            <img :src="concert.filename" />
                        </a>
                    </div>
                    <!-- Image
                    <img v-if="concert.filename != null && concert.filename != ''" class="w-full" :src="concert.filename" :alt="concert.title">
                     -->
                    <!-- Date -->
                    <div class="font-bold mt-4 text-medium">
                        {{concert.event.date_text}} 
                    </div>
                    <!-- Title -->
                    <div class="font-bold pb-2 text-xl">
                        <a :href="'/concert/'+concert.slug" class="text-dark">
                            {{concert.title}}
                        </a>
                    </div>
                    <!-- Venue -->
                    <div v-if="concert.event.venue" class="pb-2">
                        <span class="font-bold text-dark">Venue</span> 
                        <!--<div v-if="concert.event.venue.image">
                            <img :src="concert.event.venue.image" />
                        </div>-->
                        <div class="text-medium">
                            {{concert.event.venue.name}} - {{concert.event.venue.city}}, <span class="uppercase">{{concert.event.venue.state}}</span>
                        </div>
                    </div>
                    <!-- Tickets -->
                    <!--<div class="pb-2">
                        <span class="font-bold">Tickets</span>
                        
                        <div v-if="concert.onsale">
                            <div v-for="ticket in concert.tickets">
                                <div v-if="ticket.status === 1" class="capitalize mb-1">
                                    ${{ticket.price}} {{ticket.label}}
                                </div>
                            </div>
                        </div>-->
                        <!-- Off Sale
                        <div v-else>
                            Online sales are not available for this concert.
                        </div>
                    </div>-->
                    <!-- Artists -->
                    <div v-if="concert.artists.length > 0" class="pb-2">
                        <span class="font-bold text-dark">Artists</span>
                        <div v-for="artist in concert.artists" class="text-medium">
                            {{artist.name}}
                            <!--<div v-if="artist.image">
                                <img :src="artist.image" />
                            </div>-->
                        </div>
                    </div>
                    <!-- Details
                    <div v-if="concert.body != null && concert.body != ''" class="pb-2">
                        <div class="font-bold">Details</div> 
                        {{concert.body}}
                    </div> -->
                    <!-- Genres -->
                    <div v-if="concert.genres">
                        <span class="chip-medium text-sm mr-1" v-for="genre in concert.genres">
                            {{genre.name}}
                        </span>
                    </div>
                    <!-- Ticket Link -->
                    <div class="mt-4">
                        <a class="bg-primary text-white pt-2 pb-2 block text-center font-bold" :href="'/concert/'+concert.slug">
                            Details & Tickets
                        </a>
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
    import { parseISO, format } from 'date-fns'

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
                            this.concerts[i].event.date_text = format(parseISO(this.concerts[i].event.date_time), 'MMMM dd, yyyy')
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
