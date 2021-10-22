<template>
    <div class="feat-bg bottom-spacer">
        <!-- 
            Header
        -->
        <Header />
        <!-- 
            Content 
        -->
 <div class="bg-primary">
    <div class="max-w-2xl mx-auto text-center py-16 px-4 sm:py-20 sm:px-6 lg:px-8">
      <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
        <span class="block">The Heroine</span>
        <span class="block">@ DiPiazza's Friday, October 22nd</span>
      </h2>
      <p class="mt-4 text-lg leading-6 text-white">Tickets are available online or at the door.</p>
      <a href="/concert/the-heroine-280909685" class="mt-8 w-full inline-flex items-center justify-center px-5 py-3  text-base    bg-white text-black font-extrabold  sm:w-auto">
        Tickets & Info
      </a>
    </div>

  </div>
        <div class="container mx-auto bg-white p-4 mt-4">
            <!-- Not Loading -->
            <div v-if="isLoading === false">

                <!--<div class="flex mb-4 justify-center items-center">
                    <div class="flex-1">
                        <input type="text" class="form-input w-full h-8" v-model="keyword" placeholder="Enter artist">
                    </div>
                    <div class="flex-none">
                        <svg v-if="keyword == null" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" @click.prevent="reset()">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                </div>

                <div v-if="matchedArtists && matchedArtists.length > 0">
                    <div v-for="artist in matchedArtists">
                        {{artist.name}}
                    </div>
                </div>-->

                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <div v-for="concert in matchedConcerts" class="bg-black p-2">
                        <div v-if="concert.filename != null">
                            <a :href="'/concert/'+concert.slug">
                                <img :src="concert.filename" />
                            </a>
                        </div>
                        <div v-if="concert.event.date_text" class="pt-2 text-white text-center font-bold">
                            {{concert.event.date_text}}
                        </div>
                        <div v-if="concert.event.venue" class="mb-2">
                            <div class="text-white text-center text-sm font-bold">
                                 {{concert.event.venue.name}} - {{concert.event.venue.city}}, <span class="uppercase">{{concert.event.venue.state}}</span>
                            </div>
                        </div>
                        <!-- Ticket Link -->
                        <div>
                            <a class="bg-primary block text-white p-2 text-center font-bold" :href="'/concert/'+concert.slug">
                                Tickets & Info
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
                artists: [],
                matchedArtists: [],
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
            reset: function() {
                this.keyword = null
                this.matchedArtists = []
                this.matchedConcerts = []
            }
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
                            if(this.concerts[i].artists) {
                                for(var y=0;y<this.concerts[i].artists.length;y++) {
                                    if(this.concerts[i].artists[y].status === 1) {
                                        this.artists.push(this.concerts[i].artists[y])
                                    }
                                }
                            } 
                            this.concerts[i].onsale = isOnSale
                            this.matchedConcerts.push(this.concerts[i])
                        }
                    }
                },
                deep:true
            },
            keyword: function() {

                if(this.keyword != null && this.keyword.length >= 2) {
                    this.matchedArtists = []
                    if(this.artists && this.artists.length > 0) {

                        let str = this.keyword.toLowerCase()
                        for(var i=0;i<this.artists.length;i++) {
                            let artist = this.artists[i].name.toLowerCase()
                            if(artist.includes(str)) {
                                this.matchedArtists.push(this.artists[i])
                            }
                        }
                    }
                }
            }
        }
    }
</script>

<style>
.bg-feat {
    background: #8a96fd;

}
</style>
