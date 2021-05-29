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

                <!-- Concert -->
                <div v-if="concert != null && concert != undefined && concert != []">
                   
                    <div class="mt-4">
                        <img class="w-full" :src="concert.imageFull" :alt="concert.title">
                        <div class="p-4 w-full bg-black">
                            <p class="text-date font-bold uppercase">{{concert.dateHuman}} | {{concert.time}}</p>
                            <div class="uppercase text-title">
                                {{concert.title}}
                            </div>
                            <span v-if="concert.venue" class="block text-venue text-gray-400">
                                Venue: {{concert.venue[0].name}}
                            </span>
                            <p v-if="concert.venue" class="text-gray-400" style="font-size:14px;">{{concert.venue[0].address}}</p>
                            <p v-if="concert.venue" class="text-gray-400" style="font-size:14px;">{{concert.venue[0].city}}, {{concert.venue[0].state}} {{concert.venue[0].zipCode}}</p>
                            <p class="mt-2 text-gray-400">{{concert.details}}</p>
                        </div>
                    </div>
       

                    <div class="mb-4">
                        <div>
                            <div class="dark:bg-gray-200 shadow-md overflow-hidden">
                                <!-- Not Loading -->
                                <div v-if="isLoading === false">
                                    <div class="p-4">
                                        <!-- Number of tickets -->
                                        <div v-if="step === 0">
                                            <!-- Tickets On Sale -->
                                            <div v-if="onSale === true">
                                                <p class="font-bold">Tickets: ${{concert.ticket}}.00</p>
                                                <p class="mb-0">How many tickets would you like to purchase?</p>
                                                <p class="mb-2 text-xs">You can enter a promo code after selecting the number of tickets.</p>

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
                                                <!-- Promo Code -->
                                                <div v-if="ticketNumber > 0" class="mt-4 mb-4">
                                                    <div v-if="promoMsg != null" class="mt-2 mb-2 font-bold">
                                                        {{promoMsg}}
                                                    </div>
                                                    <label>If you have a promo code, please enter it.</label><br>
                                                    <input type="text" class="form-input" v-model="promoCode" placeholder="Promo Code">
                                         
                                                    <button class="ml-1 bg-gray-400 p-2" @click.prevent="doPromoCode(concert.ticket)">
                                                        Apply Code
                                                    </button>
                                                </div>

                                                <p class="font-bold mt-2">Total: ${{total = ticketNumber * concert.ticket - promoDiscount}}.00</p>
                                                <div v-if="ticketNumber > 0">
                                                    <p class="mb-2 text-xs">All ticket sales are final and only refundable if the concert is canceled.</p>
                                                    <button @click="step = 1" class="buy-now-button mt-2 w-full">
                                                        Buy Now
                                                    </button>
                                                </div>
                                            </div>
                                            <!-- Tickets Off Sale -->
                                            <div v-else>
                                                <p class="font-bold">Online sales have ended, but you can still get tickets at the door.</p>
                                                <ul>
                                                    <li>$35 without promo code.</li>
                                                    <li>$20 with promo code. </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- Ticket holder name -->
                                        <div v-if="step === 1">
                                            <p class="font-bold mb-2">Name of primary ticket holder</p>
                                            <p class="mb-2">The person who will claim the tickets at the venue the night of the show.</p>
                                            <input type="text" class="form-input w-full" v-model="ticketHolder"> 
                                            <div v-if="ticketHolder != null && ticketHolder != ''">
                                                <button @click="step = 2" class="buy-now-button mt-2 w-full">
                                                    Next
                                                </button>
                                            </div> 
                                        </div>
                                        <!-- Payment Form -->
                                        <div v-if="step === 2">

                                            <p v-if="errCode" class="mb-4 pb-2" style="border-bottom:2px solid #000000;">
                                                {{errMsg}}
                                            </p>
                                            <p class="font-bold mt-2 mb-2 text-lg border-bottom">Total: ${{total = ticketNumber * concert.ticket - promoDiscount}}.00</p>
                                            <p class="font-bold mb-2">Payment Information</p>
                                            <p style="font-size:14px; color:#444444;" class="mb-2">Your payment is processed securely through Stripe. Your card details are never stored on our servers.</p>
                                            <!-- Single -->
                                            <div class="w-full pb-2">
                                                <input type="text" class="form-input w-full" v-model="nameOnCard" placeholder="Name on card*">
                                            </div>
                                            <!-- Group -->
                                            <div class="w-full pb-2">
                                                <input type="text" class="form-input w-full" v-model="email" placeholder="email*">
                                            </div>
                                            <div class="w-full pb-2">
                                                <input type="text" class="form-input w-full" v-model="phone" placeholder="Phone*">
                                            </div>   
                                            <!-- Single -->
                                            <div class="w-full pb-2">
                                                <input type="text" class="form-input w-full" v-model="cardNumber" placeholder="Card Number*">
                                            </div>

                                            <div class="grid grid-cols-3 gap-4">
                                                <div>
                                                    <!-- Group -->
                                                    <div class="w-full pb-2">
                                                        <input type="text" class="form-input w-full" v-model="expMonth" placeholder="Month*">
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="w-full pb-2">
                                                        <input type="text" class="form-input w-full" v-model="expYear" placeholder="Year*">
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="w-full pb-2">
                                                        <input type="text" class="form-input w-full" v-model="cvv" placeholder="CVV*">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Single -->
                                            <div class="w-full pb-2">
                                                <input type="text" class="form-input w-full" v-model="address" placeholder="Address*">
                                            </div>
                                            <!-- Single -->
                                            <div class="w-full pb-2">
                                                <input type="text" class="form-input w-full" v-model="city" placeholder="City*">
                                            </div>

                                            <div class="grid grid-cols-2 gap-4">
                                                <div>
                                                    <!-- Group -->
                                                    <div class="w-full pb-2">
                                                        <input type="text" class="form-input w-full" v-model="state" placeholder="State*">
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="w-full pb-2">
                                                        <input type="text" class="form-input w-full" v-model="zip" placeholder="Zip Code*">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Can pay -->
                                            <div v-if="isPaymentFormValidated === true">
                                                <button @click="sendPayment()" class="buy-now-button mt-2 w-full">Submit</button>
                                            </div>
                                        </div>
                                        <!-- After Payment -->
                                        <div v-if="step === 3">
                                            <!-- Thank You -->
                                            <div class="pb-4">
                                                <h3 class="text-lg font-bold text-gray-900">Thank You For Purchasing A Ticket To A Tower74 Concert!</h3>
                                                <p>
                                                    Your support helps us book more concerts, creates revenue for venues and keeps artists working! Please check your email for your confirmation.
                                                </p>
                                            </div>
                                            <!-- Tickets -->
                                            <div class="pb-4">
                                                <h3 class="text-lg font-bold text-gray-900">Your Ticket(s)</h3>
                                                <p>
                                                    Your ticket(s) will be at will call the day of the concert. The primary ticket holder will need to present a valid ID to claim the tickets. 
                                                </p>
                                            </div>
                                            <!-- Contact -->
                                            <div class="pb-4">
                                                <h3 class="text-lg font-bold text-gray-900">Contact</h3>
                                                <p>
                                                    If you have questions or need to reach Tower74 please <a class="font-bold" href="/contact">click here to email</a> or text 949 205 9629. 
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Loading -->
                                <div v-else class="pt-4 pb-4">
                                    <div style="width:100%;max-width:120px;margin:0 auto;">
                                        <div class="loading">
                                            <svg xmlns="http://www.w3.org/2000/svg"  fill="none" viewBox="0 0 24 24" stroke="black">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        Purchasing your ticket
                                    </div>   
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Not found -->
                <div v-else>
                    <div>
                        There was a problem.
                    </div>
                </div>
            </div>

        </div>
        <Footer page="tickets" />
    </div>
</template>

<script>
    import Header from '@/Pages/Partials/Header'
    import Footer from '@/Pages/Partials/Footer'

    export default {
        components: {
            Header, Footer
        },
        props: [
            'slug'
        ],
        mounted() {
            if(this.slug) {
                if(this.slug == 'kyle-smith-the-b-foundation') {
                    this.onSale = false
                }
                this.getConcert()
            }
        },
        data() {
            return {
                // Payment
                email: null,
                phone: null,
                nameOnCard: null,
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
                concerts: [],
                promoCode: null,
                promoMsg: null,
                promoDiscount: 0,
                onSale: true
            }
        },
        methods: {
            getConcert: function() {
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
                            if(this.slug === this.concerts[i].slug) {
                                this.concert = this.concerts[i]
                            }
                        }
                    }
                }
            },
            validatePaymentForm: function() {
                // Validate Name on card
                let isNameValidated = false
                if(this.nameOnCard != null && this.nameOnCard != '') {
                    isNameValidated = true
                }
                // Validate Email
                let isEmailValidated = false
                if(this.email != null && this.email != '') {
                    isEmailValidated = true
                }
                // Validate Phone
                let isPhoneValidated = false
                if(this.phone != null && this.phone != '') {
                    isPhoneValidated = true
                }
                // Validate Card Number
                let isCardNumberValidated = false
                if(this.cardNumber != null && this.cardNumber != '') {
                    isCardNumberValidated = true
                }
                // Validate Month
                let isMonthValidated = false
                if(this.expMonth != null && this.expMonth != '') {
                    isMonthValidated = true
                }
                // Validate Year
                let isYearValidated = false
                if(this.expYear != null && this.expYear != '') {
                    isYearValidated = true
                }
                // Validate CVV
                let isCvvValidated = false
                if(this.cvv != null && this.cvv != '') {
                    isCvvValidated = true
                }
                let isAddressValidated = false
                // Validate Address
                if(this.address != null && this.address != '') {
                    isAddressValidated = true
                }
                // Validate City
                let isCityValidated = false
                if(this.city != null && this.city != '') {
                    isCityValidated = true
                }
                // Validate State
                let isStateValidated = false
                if(this.state != null && this.state != '') {
                    isStateValidated = true
                }
                // Validate Zip
                let isZipValidated = false
                if(this.zip != null && this.zip != '') {
                    isZipValidated = true
                }
                // If there are no false validations
                if(isNameValidated !== false && isEmailValidated !== false && isPhoneValidated !== false && isCardNumberValidated !== false && isMonthValidated !== false && isYearValidated !== false && isCvvValidated !== false && isAddressValidated !== false && isCityValidated !== false && isStateValidated !== false && isZipValidated !== false) {
                    this.isPaymentFormValidated = true
                } else {
                    this.isPaymentFormValidated = false
                }
            },
            sendPayment: function() {
                this.isLoading = true
                    axios.post('/api/payment', {
                    email: this.email,
                    phone: this.phone,
                    nameOnCard: this.nameOnCard,
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
                this.nameOnCard = null
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
            },
            doPromoCode: function(tixPrice) {
                if(this.promoCode) {
                    if(this.promoCode.toLowerCase() == 'beyondfm' || this.promoCode.toLowerCase() == 'ramone') {
                        this.promoDiscount = 5 * this.ticketNumber
                        this.promoMsg = 'Success! Your total has been updated.'
                    } else {
                        this.promoMsg = 'That code does not match a valid promo code.'
                    }
                }
            }
        },
        watch: {
            slug: function() {
                if(this.slug) {
                    this.getConcert()
                }
            },
            nameOnCard: function() {
                this.validatePaymentForm()
            },
            email: function() {
                this.validatePaymentForm()
            },
            phone: function() {
                this.validatePaymentForm()
            },
            cardNumber: function() {
                this.validatePaymentForm()
            },
            expMonth: function() {
                this.validatePaymentForm()
            },
            expYear: function() {
                this.validatePaymentForm()
            },
            cvv: function() {
                this.validatePaymentForm()
            },
            address: function() {
                this.validatePaymentForm()
            },
            city: function() {
                this.validatePaymentForm()
            },
            state: function() {
                this.validatePaymentForm()
            },
            zip: function() {
                this.validatePaymentForm()
            },

        }
    }
</script>


