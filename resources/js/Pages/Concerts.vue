<template>
    <div class="feat-bg bottom-spacer">
        <!-- 
            Header
        -->
        <Header />
        <!-- 
            Content 
        -->

        <div class="container mx-auto bg-white p-4">
            <!-- Not Loading -->
            <div v-if="isLoading === false">
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <div v-for="concert in matchedConcerts" class="bg-black">
                        <div v-if="concert.filename != null">
                            <a :href="'/concert/'+concert.slug">
                                <img :src="concert.filename" />
                            </a>
                        </div>
                        <div v-if="concert.event.venue" class="pt-2">
                            <div class="text-white text-center text-sm font-bold">
                                {{concert.event.venue.city}}, <span class="uppercase">{{concert.event.venue.state}}</span>
                            </div>
                        </div>
                        <!-- Ticket Link -->
                        <div class="p-2">
                            <a class="bg-primary block text-white pt-2 pb-2 text-center font-bold" :href="'/concert/'+concert.slug">
                                Details & Tickets
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Loading -->
            <div v-else class="p-4">
                <div style="width:100%;max-width:120px;margin:0 auto;">
                    <div class="loading">
                        <svg xmlns="http://www.w3.org/2000/svg"  fill="none" viewBox="0 0 24 24" stroke="black">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                        </svg>
                    </div>
                </div>
                <div class="text-center">
                    Loading
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
                this.isLoading = true
                axios.get('https://api.artistwave.com/api/get/page-concerts/91')
                .then((response) => {
                    console.log(response.data)
                    if(response.data) {
                        this.concerts = response.data
                        this.isLoading = false
                    }

                }).catch(error => {
                    this.isLoading = false
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
