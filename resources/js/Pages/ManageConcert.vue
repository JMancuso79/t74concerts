<template>
    <app-layout>
        <template #header>
            <a href="/dashboard" class="font-semibold text-gray-800 leading-tight">
                Dashboard
            </a>
        </template>

        <div class="py-12">
            <div v-if="concert" class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <div class="p-6 sm:px-20 bg-white border-b border-gray-200">

                        <div class="mt-4">
                            <p class="text-xl font-bold">{{concert.title}} </p>
                            <p>ID: #{{concert.id}}</p>
                        </div>

                    </div>
                    <div class="p-6 sm:px-20">
                        <button @click.prevent="showPromoCodes = !showPromoCodes" class="bg-gray-200 p-2 mr-1 text-sm">
                            <span>Promo Codes</span>
                        </button>
                        <button @click.prevent="showArtists = !showArtists" class="bg-gray-200 p-2 mr-1 text-sm">
                            <span>Artists</span>
                        </button>
                        <a :href="'/box-office/'+concert.id" class="bg-gray-200 p-2 mr-1 text-sm inline-block">
                            <span>Box Office</span>
                        </a>
                    </div>
                    <!--
                        Promo Codes
                    -->
                    <div v-if="showPromoCodes === true" class="p-6 sm:px-20">
                        <div>
                            <span class="text-lg bold">Create Promo Code</span>
                        </div>
                        <PromoCodeForm :concert-id="id" />
                        <div v-if="promoCodes && promoCodes.length > 0">
                            <div>
                                <span class="text-lg bold">Promo Codes</span>
                            </div>
                            <div v-for="code in promoCodes" :key="code" class="mb-2">
                                <div class="grid grid-cols-2 gap-2 border-bottom">
                                    <div>
                                        <!-- Group -->
                                        <div class="w-full pb-2">
                                            {{code.code}}
                                        </div>
                                    </div>
                                    <div>
                                        <div class="w-full pb-2 text-right">
                                            <span v-if="code.status === 0" class="text-sm">Not Active</span>
                                            <span v-if="code.status === 1" class="text-sm">Active</span>
                                        </div>
                                    </div>
                                </div>
                           </div>
                        </div>
                    </div>
                    <!--
                        Artists
                    -->
                    <div v-if="showArtists === true" class="p-6 sm:px-20">
                        <div class="mb-2">
                            <span class="text-lg font-bold">Artists</span>
                        </div>
                        
                        <div v-if="customerArtists">
                            <div v-for="item in customerArtists" class="grid grid-cols-2 gap-1 border-bottom mb-1 pb-1">
                                <div>
                                    {{item.name}} 
                                </div>
                                <div class="text-right">
                                    {{item.records.length}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--
                        Totals
                    -->
                    <div class="p-6 sm:px-20 bg-gray-200 bg-opacity-25">

                        <div>
                            <!-- Totals -->
                            <div class="pt-4 text-xl">
                                <div class="border-bottom">
                                    Tickets Sold: {{ticketsSold}} 
                                </div>
                                <div class="border-bottom">
                                    Gross Sales: ${{grossSales}}
                                </div>
                            </div>
                            <!-- Name Search -->
                            <div class="pt-4 pb-4">
                                <input type="text" placeholder="Enter name" v-model="keyword" class="w-full" />
                            </div>
                            <!-- Reset -->
                            <div v-if="keyword != null && keyword != ''" class="pt-4">
                                <button class="w-full bg-gray-800 pt-2 pb-2 text-white" @click.prevent="resetItems()">Reset</button>
                            </div>
                            <div v-if="items.length > 0">
                                <!-- List -->
                                <div v-for="order in items" class="border-bottom mb-2">
                                    <div v-if="order.ticket_holder != null && order.ticket_holder != ''">
                                        <strong>{{order.ticket_holder}}</strong>
                                    </div>
                                    <div v-if="order.name_on_card != null && order.name_on_card != ''">
                                        Name on card: {{order.name_on_card}}
                                    </div>
                                    <div>
                                        Purchased: {{getDate(order.created_at)}}
                                    </div>
                                    <div>
                                        Tickets: {{order.num_of_tickets}} | Paid: ${{order.total_sale}}
                                    </div>
                                    <div class="text-center pt-3 pb-3">
                                        <button class="secondary-button w-full">Check In</button>
                                    </div>
                                </div>
                            </div>
                            <!-- Empty Object -->
                            <div v-else class="p-4">
                                There are no orders
                            </div>
                        </div>   
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    //import Welcome from '@/Jetstream/Welcome'
    import { format } from 'date-fns'
    import PromoCodeForm from '@/Pages/Partials/PromoCodeForm.vue'

    export default {
        props: ['id'],
        components: {
            AppLayout,
            PromoCodeForm
            //Welcome,
        },
        mounted() {
            this.getPromoCodes()
            this.getOrders()
            this.getConcert()
        },
        data() {
            return {
                title: null,
                ticketsSold: 0,
                grossSales: 0,
                keyword: null,
                orders: [],
                items: [],
                concert: [],
                artists: [],
                customerArtists: [],
                promoCodes: null ,
                showPromoCodes: false,
                showArtists: false
            }
        },

        methods: {
            getOrders: function() {
                axios.get('/web-api/get-concert-orders/' + this.id)
                .then((response) => {
                    if(response.data) {
                       this.doData(response.data) 
                    }

                }).catch(error => {
                    console.log(error)
                });
            },
            getConcert: function() {
                axios.get('https://api.artistwave.com/api/get/concert-by-id/' + this.id)
                .then((response) => {
                    if(response.data) {
                       this.concert = response.data 
                       this.doArtists()
                    }

                }).catch(error => {
                    console.log(error)
                });
            },
            getArtistCustomers: function(artistId, artistName) {

                axios.get('/web-api/get-customer-artists/artist/'+artistId+'/concert/'+this.concert.id) 
                .then((response) => {
                    this.customerArtists.push({
                        id: artistId,
                        name: artistName,
                        records: response.data
                    })
                }).catch(error => {
                    console.log(error)
                });

            },
            doData: function(data) {
                this.orders = data.orders
                this.title = data.title
                this.ticketsSold = data.tickets_sold
                this.grossSales = data.gross_sales
                this.items = this.orders
            },
            doArtists: function() {
                this.artists = []
                if(this.concert.artists) {
                    for(var i=0;i<this.concert.artists.length;i++) {
                        this.getArtistCustomers(this.concert.artists[i].id, this.concert.artists[i].name)
                    }
                }
            }, 
            getDate: function(d) {
                return format(Date.parse(d), 'eeee, MMMM dd yyyy')
            },
            resetItems: function() {
                this.items = this.orders
                this.keyword = null
            },
            getPromoCodes: function() {
                axios.get('/api/get/promo-codes-all/' + this.id)
                .then((response) => {
                    this.promoCodes = response.data
                }).catch(error => {
                    console.log(error)
                });
            },           
        },
        watch: {
            keyword: function() {
                if(this.keyword != null && this.keyword != '') {
                    this.items = []
                    if(this.orders) {
                        for(var i=0;i<this.orders.length;i++) {
                            if(this.orders[i].name_on_card.toLowerCase().includes(this.keyword.toLowerCase())) {
                                this.items.push(this.orders[i])
                            }
                        }
                    }

                }
            },
            showArtists: function() {
                if(this.showArtists === true) {
                    this.showPromoCodes = false
                }
            },
            showPromoCodes: function() {
                if(this.showPromoCodes === true) {
                    this.showArtists = false
                }
            }
        }
    }
</script>
