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
                    <div class="pt-2 pb-2">
                        <a class="bg-primary block text-white pt-2 pb-2 text-center font-bold" :href="'/concert/'+concert.slug">
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
