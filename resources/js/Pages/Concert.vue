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
                <div v-if="concert" class="bg-gray-200 m-4 p-4">
                    <div class="pb-4">
                        <a class="bg-gray-400 pt-2 pb-2 pl-4 pr-4 text-sm capitalize" href="/concerts">
                             back to calendar
                        </a>
                    </div>
                    <div v-if="concert.filename != null">
                        <img :src="concert.filename" />
                    </div>
                    <!-- Date -->
                    <div class="font-bold mt-4 text-dark">
                        {{dateText}} 
                    </div>
                    <!-- Title -->
                    <div class="font-bold pb-2 text-xl">
                        {{concert.title}}
                    </div>
                    <!-- Tickets -->
                    <div class="pb-2">
                        <span class="font-bold">Tickets</span>
                        <div v-if="concert.onsale === true">
                            <div v-for="ticket in concert.tickets">
                                <div v-if="ticket.status === 1" class="capitalize mb-1">
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
                        <span class="chip-medium text-sm mr-1" v-for="genre in concert.genres">
                            {{genre.name}}
                        </span>
                    </div>
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
                showModal: false,
                dateText: null,
                isOnSale: false
            }
        },
        mounted() {
            if(this.concert) {
                this.dateText = format(parseISO(this.concert.event.date_time), 'MMMM dd, yyyy')
                this.doTickets()
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