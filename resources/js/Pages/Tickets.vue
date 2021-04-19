<template>
    <div class="feat-bg bottom-spacer">
        <!-- 
            Header
        -->
        <Header />
        <!-- 
            Content 
        -->
        <div class="top-spacer">
            <div class="max-width mx-auto">
                <!-- Concert -->
                <div v-if="concert != null && concert != undefined && concert != []">
                    <div class="grid grid-cols-1 text-white">
                        <div class="p-2">
                            <div class="max-w-md mx-auto dark:bg-gray-800 rounded-xl shadow-md overflow-hidden md:max-w-2xl">
                                <div class="md:flex">
                                    <div class="md:flex-shrink-0">
                                        <img class="h-48 w-full object-cover md:w-48" :src="concert.image" :alt="concert.title">
                                    </div>
                                    <div class="p-4 w-full">
                                        <div class="uppercase tracking-wide text-sm text-white font-semibold">
                                            {{concert.title}}
                                        </div>
                                        <a v-if="concert.venue" :href="'/venue/'+concert.venue[0].slug" class="block mt-1 text-lg leading-tight font-medium text-gray-500 hover:underline">
                                            {{concert.venue[0].name}}
                                        </a>
                                        <p class="mt-2 text-gray-500">{{concert.details}}</p>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1">
                        <div class="p-2">
                            <div class="max-w-md mx-auto dark:bg-gray-400 rounded-xl shadow-md overflow-hidden md:max-w-2xl">
                                <!-- Not Loading -->
                                <div v-if="isLoading === false">
                                    <div class="p-4">
                                        <!-- Number of tickets -->
                                        <div v-if="step === 0">
                                            <p>Tickets: ${{concert.ticket}}.00</p>
                                            <p>How many tickets?</p>
                                            <input type="number" class="form-input" min="0" max="10" v-model="ticketNumber">
                                            <p>${{total = ticketNumber * concert.ticket}}.00</p>
                                            <div v-if="ticketNumber > 0">
                                                <button @click="step = 1">Buy Now</button>
                                            </div>
                                        </div>
                                        <!-- Ticket holder name -->
                                        <div v-if="step === 1">
                                            <p>Name of primary ticket holder</p>
                                            <input type="text" class="form-input w-full" v-model="ticketHolder"> 
                                            <div v-if="ticketHolder != null && ticketHolder != ''">
                                                <button @click="step = 2">Next</button>
                                            </div> 
                                        </div>
                                        <!-- Payment Form -->
                                        <div v-if="step === 2">
                                            <!-- Single -->
                                            <div class="w-full pb-2">
                                                <input type="text" class="form-input w-full" v-model="nameOnCard" placeholder="Name on card">
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
                                                <input type="text" class="form-input w-full" v-model="cardNumber" placeholder="Card Number">
                                            </div>
                                            <!-- Group -->
                                            <div class="w-full pb-2">
                                                <input type="text" class="form-input w-full" v-model="expMonth" placeholder="Month">
                                            </div>
                                            <div class="w-full pb-2">
                                                <input type="text" class="form-input w-full" v-model="expYear" placeholder="Year">
                                            </div>
                                            <div class="w-full pb-2">
                                                <input type="text" class="form-input w-full" v-model="cvv" placeholder="CVV">
                                            </div>
                                            <!-- Single -->
                                            <div class="w-full pb-2">
                                                <input type="text" class="form-input w-full" v-model="address" placeholder="Address">
                                            </div>
                                            <!-- Single -->
                                            <div class="w-full pb-2">
                                                <input type="text" class="form-input w-full" v-model="city" placeholder="City">
                                            </div>
                                            <!-- Group -->
                                            <div class="w-full pb-2">
                                                <input type="text" class="form-input w-full" v-model="state" placeholder="State">
                                            </div>
                                            <div class="w-full pb-2">
                                                <input type="text" class="form-input w-full" v-model="zip" placeholder="Zip Code">
                                            </div>
                                            <!-- Can pay -->
                                            <div v-if="isPaymentFormValidated === true">
                                                <button @click="sendPayment()">Submit</button>
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

    </div>
</template>

<script>
    import Header from '@/Pages/Partials/Header'

    export default {
        components: {
            Header,
        },
        props: [
            'id'
        ],
        mounted() {
            if(this.id > 0) {
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
                // Concerts
                concerts: [
                    {
                        id: '1000',
                        date: '2021-05-21',
                        time: '7:00 pm',
                        title: 'Kyle Smith W/The B Foundation',
                        venue: [
                            {
                                name: 'Tiki Bar',
                                slug: 'tiki-bar',
                                address: '1700 Placentia Ave', 
                                city: 'Costa Mesa',
                                state: 'CA',
                                zipCode: 92627,
                                website: 'https://tikibaroc.com/'
                            },
                        ],
                        artists: [
                            {
                                name: 'Kyle Smith',
                                url: 'https://artistwave.com',
                                image: '/images/tower-74-concert-1.jpg'
                            },
                            {
                                name: 'The B Foundation',
                                url: 'https://artistwave.com',
                                image: '/images/tower-74-concert-1.jpg'
                            }
                        ],
                        details: 'This is some detail text',
                        url: 'https://artistwave.com',
                        ticketLink: 'https://artistwave.com',
                        image: '/images/tower-74-concert-1.jpg',
                        ticket: 35
                    },
                    {
                        id: '1001',
                        date: '2021-06-05',
                        time: '7:00 pm',
                        title: 'Sammy Ramone',
                        venue: [
                            {
                                name: 'Tiki Bar',
                                slug: 'tiki-bar',
                                address: '1700 Placentia Ave', 
                                city: 'Costa Mesa',
                                state: 'CA',
                                zipCode: 92627,
                                website: 'https://tikibaroc.com/'
                            },
                        ],
                        artists: [
                            {
                                name: 'Sammy Ramone',
                                url: 'https://artistwave.com',
                                image: '/images/tower-74-concert-2.jpg'
                            },
                            {
                                name: 'Noble Savage',
                                url: 'https://artistwave.com',
                                image: '/images/tower-74-concert-2.jpg'
                            }
                        ],
                        details: 'This is some detail text',
                        url: 'https://artistwave.com',
                        ticketLink: 'https://artistwave.com',
                        image: '/images/tower-74-concert-2.jpg',
                        ticket: 15
                    },
                ]
            }
        },
        methods: {
            getConcert: function() {
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
                    concertPrice: this.concert.ticket,
                    concertTitle: this.concert.title,
                    concertVenue: this.concert.venue[0].name,
                    venueAddress: this.concert.venue[0].address,
                    venueCity: this.concert.venue[0].city,
                    venueState:this.concert.venue[0].state,
                    venueZip: this.concert.venue[0].zipCode
                }).then((response) => {
                    // Success
                    if(response.data.message == 'success') {
                        this.step = 3
                        this.errCode = 'success'
                        this.errMsg = 'Your payment was successful'
                        this.resetForm()
                    }
                    // Something went wrong
                    if(response.data.message == 'fail' ) {
                        this.errCode = 'fail'
                        this.errMsg = 'Something went wrong! Please text or call to if you need assistance. 949 205 9629'
                    }
                    this.isLoading = false  
                }).catch(error => {
                    // Something went wrong
                    this.errCode = 'fail'
                    this.errMsg = 'Something went wrong! Please text or call to if you need assistance. 949 205 9629'
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
            }
        },
        watch: {
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


