<template>
    <div class="feat-bg bottom-spacer">
        <!-- 
            Header
        -->
        <Header />
        <!-- 
            Content 
        -->
        <div class="container mx-auto">
            <div v-if="isLoading === false">
                <div v-if="concert" class="bg-white p-4">
                    <div class="pb-4">
                        <a class="bg-gray-200 pt-2 pb-2 pl-4 pr-4 text-sm capitalize" href="/concerts">
                             back to calendar
                        </a>
                    </div>

                    <!-- Image -->
                    <div v-if="concert.filename != null">

                        <div class="md:flex">
                            <div class="md:flex-shrink-0">
                                <img class="md:h-48 w-full md:h-full md:w-48" :src="concert.filename" :alt="concert.title">
                            </div>
                            <div class="md:pl-4">
                                <!-- Date -->
                                <div class="font-bold mt-4 md:mt-0 text-medium">
                                    {{dateText}} 
                                </div>
                                <!-- Title -->
                                <div class="font-bold pb-2 text-xl text-dark">
                                    {{concert.title}}
                                </div>
                                <!-- Tickets -->
                                <div>
                                    <span class="font-bold text-dark">Tickets</span>
                                    <div v-if="concert.onsale === true">
                                        <div v-for="ticket in concert.tickets">
                                            <div v-if="ticket.status === 1" class="capitalize mb-1 text-medium">
                                                ${{ticket.price}} {{ticket.label}}
                                            </div>
                                        </div>
                                        <!-- Buy Ticket -->
                                        <div class="pb-2">
                                            <button class="bg-primary w-full text-white pt-2 pb-2 text-center font-bold pointer" id="show-modal" @click.prevent="showModal = true">
                                                Buy Tickets
                                            </button>
                                        </div>
                                    </div>
                                    <!-- Off Sale -->
                                    <div v-else>
                                        Please buy tickets are the door. Online sales are no longer available for this concert.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- No Image -->
                    <div v-else>
                        <!-- Date -->
                        <div class="font-bold mt-4 text-medium">
                            {{dateText}} 
                        </div>
                        <!-- Title -->
                        <div class="font-bold pb-2 text-xl text-dark">
                            {{concert.title}}
                        </div>
                        <!-- Tickets -->
                        <div class="pb-2">
                            <span class="font-bold text-dark">Tickets</span>
                            <div v-if="concert.onsale === true">
                                <div v-for="ticket in concert.tickets">
                                    <div v-if="ticket.status === 1" class="capitalize mb-1 text-medium">
                                        ${{ticket.price}} {{ticket.label}}
                                    </div>
                                </div>
                                <!-- Buy Ticket -->
                                <div class="pb-2">
                                    <button class="bg-primary w-full text-white pt-2 pb-2 text-center font-bold pointer" id="show-modal" @click.prevent="showModal = true">
                                        Buy Tickets
                                    </button>
                                </div>
                            </div>
                            <!-- Off Sale -->
                            <div v-else>
                                Please buy tickets are the door. Online sales are no longer available for this concert.
                            </div>
                        </div>
                    </div>



                    <!-- Artists -->
                    <div v-if="concert.artists.length > 0" class="pb-2 md:pt-4">
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
        <Footer page="concert" />
        <!-- use the modal component, pass in the prop -->
        <PaymentWrapper :concert="concert" v-if="showModal" @close="showModal = false">
            <!--
            you can use custom content here to overwrite
            default content
            -->
            <h3 slot="header">custom header</h3>
        </PaymentWrapper>
    </div>
</template>

<script>
    import Header from '@/Pages/Partials/Header'
    import Footer from '@/Pages/Partials/Footer'
    import PaymentWrapper from '@/Pages/Partials/PaymentWrapper'
    import { parseISO, format } from 'date-fns'

    export default {
        components: {
            Header, Footer, PaymentWrapper
        },
        props: ['concert', 'slug'],
        data() {
            return {
                isLoading: false,
                showModal: false,
                dateText: null,
                isOnSale: false
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
                    if(this.concert.tickets[x].status === 1) {
                        this.isOnSale = true
                    }
                }
                
                this.concert.onsale = this.isOnSale
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
