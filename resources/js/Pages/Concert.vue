<template>
  <div class="min-h-full">

    <!--
      Top Nav Here
    -->
    <Header />
    <div v-if="concert" class="py-10">
      <div class="max-w-3xl mx-auto sm:px-6 lg:max-w-7xl lg:px-8 lg:grid lg:grid-cols-12 lg:gap-8">
        <div class="pl-4 pr-4 mb-4 md:pl-0 md:pr-0 md:block lg:col-span-3">
          <!--
            Side Nav Here
          -->
          <img class="h-18 w-18 rounded-md" :src="concert.filename" alt="" />
        </div>
        <main class="lg:col-span-5">
          <div>
            <div class="artist-list">
                <div class="">

                    <div>
                        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10 mb-4">
                            <!-- Date -->
                            <div class="font-bold text-medium">
                                {{dateText}}
                            </div>
                            <!-- Title -->
                            <div class="font-bold pb-2 text-xl text-dark">
                                {{concert.title}}
                            </div>
                            <!-- Tickets -->
                            <div class="pb-2">
                                <span class="font-bold text-dark">Tickets</span>
                                <div>
                                    <div v-for="ticket in concert.tickets">
                                        <div v-if="ticket.status === 1" class="capitalize mb-2 text-medium">
                                            ${{ticket.price}} {{ticket.label}}<br>
                                        </div>
                                    </div>
                                    <!-- Buy Ticket -->
                                    <div v-if="concert.onSale && concert.isFree === false" class="block lg:hidden mb-4">
                                        <a href="#buy-tickets" class="w-full block text-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                            Buy Tickets
                                        </a>
                                    </div>
                                </div>
                                <!-- Off Sale and not free -->
                                <div v-if="concert.onSale === false && concert.isFree === false">
                                    Online sales have ended or may not be available for this concert. Please get tickets at the door.
                                </div>
                                <!-- Free -->
                                <div v-if="concert.isFree" class="text-medium">
                                    This is a free concert.
                                </div>
                                <!-- Artists -->
                                <div v-if="concert.artists.length > 0" class="pb-2 pt-4">
                                    <span class="font-bold text-dark">Artists</span>
                                    <div v-for="artist in concert.artists" class="text-medium">
                                        {{artist.name}}
                                        <div v-if="artist.image">
                                            <!--<img :src="artist.image" />-->
                                        </div>
                                    </div>
                                </div>
                                <!-- Details -->
                                <div v-if="concert.body != null && concert.body != ''" class="pb-2">
                                    <div class="font-bold text-dark">Details</div>
                                    <div class="text-medium">
                                        {{concert.body}}
                                    </div>
                                </div>
                                <!-- Venue -->
                                <div v-if="concert.event.venue" class="pb-2">
                                    <span class="font-bold text-dark">Venue</span>
                                    <div v-if="concert.event.venue.image">
                                        <!--<img :src="concert.event.venue.image" />-->
                                    </div>
                                    <div class="text-medium">
                                        {{concert.event.venue.name}}
                                    </div>
                                    <div class="text-medium">
                                        {{concert.event.venue.street_address}}
                                    </div>
                                    <div class="text-medium">
                                        {{concert.event.venue.city}}, <span class="uppercase">{{concert.event.venue.state}}</span> {{concert.event.venue.zip_code}}
                                    </div>
                                </div>
                                <!-- Genres -->
                                <div v-if="concert.genres">
                                    <div class="chip-medium text-sm mr-1 mb-1 inline-block" v-for="genre in concert.genres">
                                        {{genre.name}}
                                    </div>
                                </div>
                                <div id="buy-tickets"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </main>
        <aside class="md:block lg:col-span-4">
          <div class="sticky top-4 space-y-4">
            <!--
              Right Col Here
            -->
            <div v-if="concert.onSale === true && concert.isFree === false">
                <PaymentWrapper :concert="concert" />
            </div>
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
    import PaymentWrapper from '@/Pages/Partials/PaymentWrapper'
    import { parseISO, format } from 'date-fns'

    export default {
        components: {
            Header, Footer, PaymentWrapper, RightCol
        },
        props: ['concert', 'slug'],
        data() {
            return {
                isLoading: false,
                showModal: false,
                dateText: null,
                isOnSale: false,
                isFree: true
            }
        },
        mounted() {
            this.isLoading = true
            if(this.concert) {
                this.dateText = format(parseISO(this.concert.event.date_time), 'MMMM dd, yyyy')
                this.doTickets()
                this.isLoading = false
            }
        },
        methods: {
            doTickets: function() {
                this.isOnSale = false
                for(var x=0;x<this.concert.tickets.length;x++) {
                    // Determine if show is on sale
                    if(this.concert.tickets[x].status === 1) {
                        this.isOnSale = true
                    }
                    // Determine if show is free
                    if(this.concert.tickets[x].price > 0) {
                        this.isFree = false
                    }
                }

                this.concert.onSale = this.isOnSale
                this.concert.isFree = this.isFree
            }
        },
        watch: {
            concert: {
                handler() {
                    if(this.concert) {
                        this.doTickets()
                    }
                },
                deep: true
            }
        }
    }
</script>
