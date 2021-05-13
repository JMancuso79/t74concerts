<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Box Office
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 sm:px-20 bg-white border-b border-gray-200">

                        <div v-if="concert" class="mt-8 text-2xl">
                            {{concert.title}}
                        </div>
                        
                    </div>

                    <div class="p-6 sm:px-20 bg-gray-200 bg-opacity-25">
                        <a class="block p-2 border-2 border-black pointer text-center font-bold" :href="'/manage/concert/'+id">
                            Manage
                        </a>
                        <div class="pt-4">
                            <p v-if="concert" class="font-bold">Tickets: ${{concert.ticket}}.00</p>
                            <p class="mb-2">How many tickets do you want to purchase?</p>
                        </div>

                        <div>
                            <div style="display:inline-block;width:15%;margin-right:5%;">
                                <input type="number" class="form-input w-full " min="0" max="10" v-model="ticketNumber">
                            </div>
                            <div style="display:inline-block;width:35%;margin-right:5%;">
                                <button :disabled="ticketNumber < 1" class="w-full ticket-number-button" @click.prevent="ticketNumber --">-</button>
                            </div>
                            <div style="display:inline-block;width:40%;">
                                <button class="w-full ticket-number-button" @click.prevent="ticketNumber ++">+</button>
                            </div>
                        </div>

                        <p class="font-bold mt-2 mb-4">Total: ${{total = ticketNumber * concert.ticket}}.00</p>
                        <!-- Group -->
                        <div class="w-full pb-2">
                            <input type="text" class="form-input w-full" v-model="ticketHolder" placeholder="Ticket holder"> 
                        </div>
                        <!-- Group -->
                        <div class="w-full pb-2">
                            <input type="text" class="form-input w-full" v-model="name" placeholder="name">
                        </div>
                        <!-- Group -->
                        <div class="w-full pb-2">
                            <input type="text" class="form-input w-full" v-model="email" placeholder="email">
                        </div>
                        <div class="w-full pb-2">
                            <input type="text" class="form-input w-full" v-model="phone" placeholder="Phone">
                        </div>  

                        <!-- Single -->
                        <div class="w-full pb-2">
                            <input type="text" class="form-input w-full" v-model="city" placeholder="City">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <!-- Group -->
                                <div class="w-full pb-2">
                                    <input type="text" class="form-input w-full" v-model="state" placeholder="State">
                                </div>
                            </div>
                            <div>
                                <div class="w-full pb-2">
                                    <input type="text" class="form-input w-full" v-model="zip" placeholder="Zip Code">
                                </div>
                            </div>
                        </div> 
                        <!-- Can pay -->
                        <div v-if="ticketNumber > 0">
                            <button @click="storeOrder()" class="buy-now-button mt-2 w-full">Submit</button>
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

    export default {
        props: ['id'],
        components: {
            AppLayout,
            //Welcome,
        },
        mounted() {
            if(this.id > 0) {
                this.getConcerts()
            }
        },
        data() {
            return {
                ticketPrice: 0,
                name: null,
                // Payment
                email: null,
                phone: null,
                cardNumber: null,
                expMonth: null,
                expYear: null,
                cvv: null,
                address: null,
                city: null,
                state: null,
                zip: null,
                isPaymentFormValidated: false,
                // Misc
                isLoading: false,
                errCode: null,
                errMsg: null,
                // Tickets
                ticketNumber: 0,
                ticketHolder: null,
                total: 0,
                step: 0,
                // Concert
                concert: [],
                concerts: []
            }
        },
        methods: {
            getConcerts: function() {
                axios.get('/data/concerts.json')
                .then((response) => {
                    console.log(response.data)
                    if(response.data) {
                        this.concerts = response.data
                        this.doConcert()
                    }

                }).catch(error => {
                    console.log(error)
                });
            },
            doConcert: function() {
                if(this.concerts) {
                    if(this.concerts.length > 0) {
                        for(var i=0;i<this.concerts.length;i++) {
                            if(this.id === this.concerts[i].id) {
                                this.concert = this.concerts[i]
                            }
                        }
                    }
                }
            },
            storeOrder: function() {
                this.isLoading = true
                axios.post('/web-api/box-office-order', {
                    email: this.email,
                    phone: this.phone,
                    nameOnCard: this.name,
                    cardNumber: this.cardNumber,
                    expMonth: this.expMonth,
                    expYear: this.expYear,
                    cvv: this.cvv,
                    address: this.address,
                    city: this.city,
                    state: this.state,
                    zip: this.zip,
                    total: this.total,
                    ticketHolder: this.ticketHolder,
                    ticketNumber: this.ticketNumber,
                    concertId: this.concert.id,
                    concertDate: this.concert.date,
                    concertTime: this.concert.time,
                    concertPrice: this.concert.ticket,
                    concertTitle: this.concert.title,
                    concertVenue: this.concert.venue[0].name,
                    venueAddress: this.concert.venue[0].address,
                    venueCity: this.concert.venue[0].city,
                    venueState:this.concert.venue[0].state,
                    venueZip: this.concert.venue[0].zipCode
                }).then((response) => {

                    // Validation error
                    if(response.data.code == 'fail-validation' ) {
                        this.errCode = 'fail-validation'
                        this.errMsg = response.data.errors
                    } 
                    // All others
                    else {
                        this.errCode = response.data.code
                        this.errMsg = response.data.message
                        // Success
                        if(this.errCode == 'success') {
                            this.step = 3
                            this.resetForm()
                        }
                    }

                    this.isLoading = false  
                }).catch(error => {
                    
                    // Something went wrong
                    this.errCode = error.code
                    this.errMsg = error.message
                    this.isLoading = false 
                });
            },
            resetForm: function() {
                this.email = null
                this.phone = null
                this.name = null
                this.cardNumber = null
                this.expMonth = null
                this.expYear = null
                this.cvv = null
                this.address = null
                this.city = null
                this.state = null
                this.zip = null
                this.total = null
                this.isPaymentFormValidated = false
                this.ticketNumber = 0
                this.ticketHolder = null
                this.total = 0
                this.errCode = null
                this.errMsg = null
            }
        }
    }
</script>

