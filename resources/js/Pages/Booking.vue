<template>
  <div class="min-h-full">

    <!-- 
      Top Nav Here
    -->
    <Header />

    <div class="py-10">
      <div class="max-w-3xl mx-auto sm:px-6 lg:max-w-7xl lg:px-8 lg:grid lg:grid-cols-12 lg:gap-8">
        <div class="hidden lg:block lg:col-span-3 xl:col-span-2">
          <!-- 
            Side Nav Here
          -->
          <nav aria-label="Sidebar" class="sticky top-4 divide-y divide-gray-300">
            <div class="pb-8 space-y-1">
              <a v-for="item in navigation" :key="item.name" :href="item.href" :class="[item.current ? 'bg-gray-200 text-gray-900' : 'text-gray-600 hover:bg-gray-50', 'group flex items-center px-3 py-2 text-sm font-medium rounded-md']" :aria-current="item.current ? 'page' : undefined">
                <component :is="item.icon" :class="[item.current ? 'text-gray-500' : 'text-gray-400 group-hover:text-gray-500', 'flex-shrink-0 -ml-1 mr-3 h-6 w-6']" aria-hidden="true" />
                <span class="truncate">
                  {{ item.name }}
                </span>
              </a>
            </div>
            <!--<div class="pt-10">
              <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider" id="communities-headline">
                Explore
              </p>
              <div class="mt-3 space-y-2" aria-labelledby="communities-headline">
                <a v-for="community in communities" :key="community.name" :href="community.href" class="group flex items-center px-3 py-2 text-sm font-medium text-gray-600 rounded-md hover:text-gray-900 hover:bg-gray-50">
                  <span class="truncate">
                    {{ community.name }}
                  </span>
                </a>
              </div>
            </div>-->
          </nav>
        </div>
        <main class="lg:col-span-9 xl:col-span-6">
          <div>
            <div class="artist-list">
                <div class="">

                    <div class="">
                        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                            <div class="mb-6">
                                <h2 id="create-artist-heading" class="text-base font-medium text-gray-900">
                                    Booking
                                </h2>
                                  <div class="flow-root mt-6">
                                    <ul role="list" class="-my-5 divide-y divide-gray-200">
                                      <li class="py-5">
                                        <div class="relative focus-within:ring-2 focus-within:ring-indigo-500">
                                          <h3 class="text-sm font-semibold text-gray-800">
                                            <div>
                                              <!-- Extend touch target to entire panel -->
                                              <span class="absolute inset-0" aria-hidden="true" />
                                              Tower 74 offers booking services to Artists & Venues. 
                                            </div>
                                          </h3>
                                          <p class="mt-1 text-sm text-gray-600 line-clamp-2">
                                           
                                          </p>
                                        </div>
                                      </li>
                                    </ul>
                                  </div>
                                  <div class="mt-6">
                                    <a href="https://tower74agency.com/services/artist-booking" class="w-full flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-white bg-primary hover:bg-gray-50 hover:text-gray-900" target="_blank">
                                      Visit the website
                                    </a>
                                  </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
          </div>
        </main>
        <aside class="hidden xl:block xl:col-span-4">
          <div class="sticky top-4 space-y-4">
            <!-- 
              Right Col Here
            -->
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
      { name: 'Home', href: '/', icon: HomeIcon, current: false },
      { name: 'Concerts', href: '/', icon: TicketIcon, current: false },
      { name: 'Booking', href: '/booking', icon: CalendarIcon, current: true },
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
