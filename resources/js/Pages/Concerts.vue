<template>
  <div class="min-h-full">

    <!-- 
      Top Nav Here
    -->
    <Header />

    <div class="relative bg-gray-900 py-32 px-6 sm:py-40 sm:px-12 lg:px-16 mb-16">
        <div class="absolute inset-0 overflow-hidden">
            <img src="/storage/images/en-young-bg.jpg" alt="" class="h-full w-full object-cover object-center" />
        </div>
        <div aria-hidden="true" class="absolute inset-0 bg-gray-900 bg-opacity-50" />
        <div class="relative mx-auto flex max-w-3xl flex-col items-center text-center">
            <p class="mt-3 text-sm text-white">Featured Concert</p>
            <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl uppercase">E.N Young & Imperial Sound</h2>
            <p class="mt-3 text-xl text-white">With performances by Ital Vibes, Bobby Hustle & Capital Dub</p>
            <a href="/concert/en-young-imperial-sound-wital-vibes-659077554" class="mt-8 block w-full rounded-md border border-transparent bg-white py-3 px-8 text-base font-medium text-gray-900 hover:bg-gray-100 sm:w-auto">Buy Tickets</a>
        </div>
    </div>

    <div class="py-10">
      <div class="max-w-3xl mx-auto sm:px-6 lg:max-w-7xl lg:px-8 lg:grid lg:grid-cols-12 lg:gap-8">
        
          <!-- 
            Side Nav Here
          -->

        <main class="col-span-12 lg:col-span-8">
          <div>
            <div class="artist-list">
                <div class="">

                    <div class="featured-artist-section">
                        <!-- Feature
                        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10 mb-6">
                            <a href="/concert/porch-bobby-hustle-1860150981">
                                <img src="https://artistwavesoftware.s3-us-west-1.amazonaws.com/posts/63781867705de.jpeg" class="w-full" />
                            </a>
                            <div class="bg-white pt-4">
                                <a href="/concert/porch-bobby-hustle-1860150981">
                                    <h3 class="text-lg leading-6 font-bold text-blue-900">Porch & Bobby Hustle @ Tiki Bar</h3>
                                </a>
                                <p class="text-gray-900">Tickets are available online or at the door.</p>
                            </div>
                            <p>
                                <a href="/concert/porch-bobby-hustle-1860150981" class="mt-4 w-full block text-center px-4 py-2 border border-blue-300 shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-900">
                                    Buy Tickets
                                </a>
                            </p>
                        </div> --> 
                        <div v-if="isLoading === false">
                            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10 mb-4">
                                <div class="mb-6">
                                    <h2 id="create-artist-heading" class="text-base font-medium text-gray-900">
                                        Upcoming Concerts
                                    </h2>
                                </div>
                                <div v-if="concerts && concerts.length">
                                    <ul role="list" class="-my-5 divide-y divide-gray-200">
                                        <li v-for="concert in concerts" :key="concert.id" class="py-4">
                                            <div class="flex items-center space-x-4">
                                                <div class="flex-shrink-0">
                                                    <img class="w-14 rounded-md" :src="concert.filename" alt="" />
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm text-gray-900">
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-gray-800 text-white">
                                                            {{ concert.event.date_text }}
                                                        </span>
                                                    </p>
                                                    <h4 class="text-gray-800 truncate font-bold">{{ concert.title }}</h4>
                                                    <p v-if="concert.event.venue" class="text-sm truncate text-gray-800">
                                                        {{ concert.event.venue.name }} - {{concert.event.venue.city}},  <span class="uppercase">{{concert.event.venue.state}}</span>
                                                    </p>
                                                    
                                                </div>
                                                <div v-if="concert.event">
                                                    <a @click.prevent="doTicketLink(concert.slug, concert.event.ticket_link)" class="inline-flex items-center shadow-sm px-2.5 py-0.5 border border-gray-300 text-sm leading-5 font-medium rounded-full text-gray-700 bg-white hover:bg-gray-50">
                                                        Tickets
                                                    </a>
                                                </div>
                                            </div>
                               
                                        </li>
                                    </ul>
                                </div> 
                                <div v-else>
                                    There are currently no concerts.
                                </div>
                            </div>
                        </div>
                        <div v-else>
                            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10 mb-4">
                                <div>
                                    <h2 id="create-artist-heading" class="text-base font-medium text-gray-900">
                                        Loading concerts...
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </main>
        <aside class="col-span-12 lg:col-span-4">
          <div class="sticky top-4 space-y-4">
            <RightCol />
          </div>
        </aside>
      </div>
    </div>
  </div>

</template>

<script>
    import Header from '@/Pages/Partials/Header'
    import Footer from '@/Pages/Partials/Footer'
    import RightCol from '@/Pages/Partials/RightCol'
    import { parseISO, format } from 'date-fns'
    import { TicketIcon, HomeIcon, MailIcon, CalendarIcon } from '@heroicons/vue/outline'

    const navigation = [
      { name: 'Home', href: '/', icon: HomeIcon, current: true },
      { name: 'Concerts', href: '/', icon: TicketIcon, current: false },
      { name: 'Booking', href: '/booking', icon: CalendarIcon, current: false },
      { name: 'Contact', href: '/contact', icon: MailIcon, current: false },
    ]

    const communities = []
    export default {
        components: {
            Header, 
            Footer,
            TicketIcon, 
            HomeIcon, 
            MailIcon,
            CalendarIcon,
            RightCol
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
        setup() {
            return {
                navigation,
                communities,
            }
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
            },
            doTicketLink: function(slug, tLink) {
                if(tLink && tLink != '') {
                    window.location = tLink
                } else {
                    window.location = '/concert/'+slug
                }
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
