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
            <!-- Event -->
            <div class="max-width mx-auto pt-4">
                <div class="bg-black ml-4 mr-4 mb-4 md:m-0">
                    <!-- Not Loading -->
                    <div v-if="isLoading === false">
                        <!-- Buttons Artist -->
                        <div v-if="type === 'artist'">
                            <div v-if="step > 1 && step < 7">
                                <button @click="step --" class="back-button mt-4 ml-4 mr-4">
                                    Back
                                </button>
                            </div>
                            <!-- Cancel -->
                            <div v-if="step === 1 || step === 7">
                                <button @click="resetForm()" class="back-button mt-4 ml-4 mr-4">
                                    Cancel
                                </button>
                            </div>
                        </div>
                        <!-- Buttons Venue -->
                        <div v-if="type === 'venue'">
                            <div v-if="step > 1">
                                <button @click="step --" class="back-button mt-4 ml-4 mr-4">
                                    Back
                                </button>
                            </div>
                            <!-- Cancel -->
                            <div v-if="step === 1">
                                <button @click="resetForm()" class="back-button mt-4 ml-4 mr-4">
                                    Cancel
                                </button>
                            </div>
                        </div>
                        <!-- Errors -->
                        <div v-if="errCode != null" class="mt-4 ml-4 mr-4 pt-4">
                            <p v-if="errCode == 'success'" class="text-white">
                                {{errMsg}}
                            </p>
                            <p v-if="errCode == 'fail'" class="text-white">
                                {{errMsg}}
                            </p>
                            <div v-if="errCode == 'fail-validation'">
                                <span class="text-white">{{errMsg}}</span>
                                <!-- Email -->
                                <div class="w-full pt-4">
                                    <label class="text-white">Email*</label>
                                    <input type="email" class="form-input w-full" v-model="email" placeholder="Enter your email">
                                </div>
                            </div>                        
                        </div>
                        <!-- Type -->
                        <div v-if="type === null" class="bg-black p-4">
                            <div class="uppercase text-title pb-4">
                                Choose a booking type
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 md:gap-4 text-white text-center">
                                <div>
                                    <button @click="type = 'artist'" class="booking-button w-full mb-4 md:m-0">
                                        Artist Booking
                                    </button>
                                </div>
                                <div>
                                    <button @click="type = 'venue'" class="booking-button w-full mb-4 md:m-0">
                                        Venue Booking
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Form -->
                        <div v-if="type === 'artist'" class="bg-black p-4">
                            <div class="pb-4">
                                <!-- Step 1 -->
                                <div v-if="step === 1">
                                    <p class="text-white pb-4">If you'd like to be booked by Tower74, please fill out the form.</p>
                                    <!-- Name -->
                                    <div class="w-full pb-2">
                                        <label class="text-white">Artist Name*</label>
                                        <input type="text" class="form-input w-full" v-model="name" placeholder="Enter artist name">
                                    </div>
                                    <!-- Name -->
                                    <div class="w-full pb-2">
                                        <label class="text-white">Contact*</label>
                                        <input type="text" class="form-input w-full" v-model="contactName" placeholder="Enter contact name">
                                    </div>
                                    <!-- Email -->
                                    <div class="w-full pb-2">
                                        <label class="text-white">Email*</label>
                                        <input type="email" class="form-input w-full" v-model="email" placeholder="Enter your email">
                                    </div>
                                    <!-- Phone -->
                                    <div class="w-full pb-2">
                                        <label class="text-white">Phone</label>
                                        <input type="text" class="form-input w-full" v-model="phone" placeholder="Enter your phone">
                                    </div>
                                    <!-- City -->
                                    <div class="w-full pb-2">
                                        <label class="text-white">City</label>
                                        <input type="text" class="form-input w-full" v-model="city" placeholder="City">
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <!-- Group -->
                                            <div class="w-full pb-2">
                                                <label class="text-white">State</label>
                                                <input type="text" class="form-input w-full" v-model="state" placeholder="State*">
                                            </div>
                                        </div>
                                        <div>
                                            <div class="w-full pb-2">
                                                <label class="text-white">Zip Code</label>
                                                <input type="text" class="form-input w-full" v-model="zipCode" placeholder="Zip Code*">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- URL -->
                                    <div class="w-full pb-2">
                                        <label class="text-white">Website</label>
                                        <input type="text" class="form-input w-full" v-model="url" placeholder="Enter your website">
                                    </div>  
                                    <!-- Can Submit -->
                                    <div v-if="name != null && contactName != null && email != null && phone != null && city != null && state != null && zipCode != null">
                                        <button @click="step = 2" class="booking-button w-full">Next</button>
                                    </div>
                                </div>
                                <!-- Step 2 -->
                                <div v-if="step === 2">
                                    <!-- Genres -->
                                    <div class="w-full pb-2">
                                        <label class="text-white">List your genres*</label>
                                        <textarea class="form-input w-full" v-model="genres" placeholder="Enter your genre(s)"></textarea>
                                    </div> 
                                    <button v-if="genres != null && genres != ''" @click="step = 3" class="booking-button w-full">Next</button>
                                </div>  
                                <!-- Step 3 -->
                                <div v-if="step === 3">
                                    <!-- Availability -->
                                    <div class="w-full pb-2">
                                        <label class="text-white">List your availability*</label>
                                        <textarea class="form-input w-full" v-model="availability" placeholder="Enter your availability"></textarea>
                                    </div> 
                                    <button v-if="availability != null && availability != ''" @click="step = 4" class="booking-button w-full">Next</button>
                                </div>  
                                <!-- Step 4 -->
                                <div v-if="step === 4">
                                    <div class="uppercase text-title pb-4">
                                        Would you like to trade shows with artists in your region?
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 md:gap-4 text-white text-center">
                                        <div>
                                            <button @click="gigSwap = 1" class="booking-button w-full mb-4 md:m-0">
                                                Yes
                                            </button>
                                        </div>
                                        <div>
                                            <button @click="gigSwap = 0" class="booking-button w-full mb-4 md:m-0">
                                                No
                                            </button>
                                        </div>
                                    </div> 
                                </div> 
                                <!-- Step 5 -->
                                <div v-if="step === 5 && gigSwap === 1">
                                    <!-- Availability -->
                                    <div class="w-full pb-2">
                                        <label class="text-white">List cities you can travel to*</label>
                                        <textarea class="form-input w-full" v-model="gigSwapAway" placeholder="Enter cities you can travel to"></textarea>
                                    </div> 
                                    <button v-if="gigSwapAway != null && gigSwapAway != ''" @click="step = 6" class="booking-button w-full">Next</button>
                                </div>
                                <!-- Step 6 -->
                                <div v-if="step === 6 && gigSwap === 1">
                                    <!-- Availability -->
                                    <div class="w-full pb-2">
                                        <label class="text-white">Where can you book shows to trade?*</label>
                                        <textarea class="form-input w-full" v-model="gigSwapHome" placeholder="Enter cities you can book"></textarea>
                                    </div> 
                                    <button v-if="gigSwapHome != null && gigSwapHome != ''" @click="step = 7" class="booking-button w-full">Next</button>
                                </div>
                                <!-- Step 7 -->
                                <div v-if="step === 7">
                                    <!-- Availability -->
                                    <div class="w-full pb-2">
                                        <label class="text-white">Leave a message</label>
                                        <textarea class="form-input w-full" v-model="message" placeholder="Enter a message"></textarea>
                                    </div> 
                                    <button v-if="isValidated === true" @click="submit()" class="booking-button w-full">Submit</button>
                                </div>
                            </div>
                        </div>
                        <!-- Venue -->
                        <div v-if="type === 'venue'" class="bg-black p-4">
                            <div class="pb-4">
                                <!-- Step 1 -->
                                <div v-if="step === 1">
                                    <p class="text-white pb-4">If you're a representative of a venue and would like Tower74 to book your venue, please fill out the form.</p>
                                    <!-- Name -->
                                    <div class="w-full pb-2">
                                        <label class="text-white">Venue Name*</label>
                                        <input type="text" class="form-input w-full" v-model="name" placeholder="Enter venue name">
                                    </div>
                                    <!-- Name -->
                                    <div class="w-full pb-2">
                                        <label class="text-white">Contact*</label>
                                        <input type="text" class="form-input w-full" v-model="contactName" placeholder="Enter contact name">
                                    </div>
                                    <!-- Email -->
                                    <div class="w-full pb-2">
                                        <label class="text-white">Email*</label>
                                        <input type="email" class="form-input w-full" v-model="email" placeholder="Enter your email">
                                    </div>
                                    <!-- Phone -->
                                    <div class="w-full pb-2">
                                        <label class="text-white">Phone</label>
                                        <input type="text" class="form-input w-full" v-model="phone" placeholder="Enter your phone">
                                    </div>
                                    <!-- Address -->
                                    <div class="w-full pb-2">
                                        <label class="text-white">Address</label>
                                        <input type="text" class="form-input w-full" v-model="address" placeholder="Enter your address">
                                    </div>
                                    <!-- City -->
                                    <div class="w-full pb-2">
                                        <label class="text-white">City</label>
                                        <input type="text" class="form-input w-full" v-model="city" placeholder="City">
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <!-- Group -->
                                            <div class="w-full pb-2">
                                                <label class="text-white">State</label>
                                                <input type="text" class="form-input w-full" v-model="state" placeholder="State*">
                                            </div>
                                        </div>
                                        <div>
                                            <div class="w-full pb-2">
                                                <label class="text-white">Zip Code</label>
                                                <input type="text" class="form-input w-full" v-model="zipCode" placeholder="Zip Code*">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- URL -->
                                    <div class="w-full pb-2">
                                        <label class="text-white">Website</label>
                                        <input type="text" class="form-input w-full" v-model="url" placeholder="Enter your website">
                                    </div>  
                                    <!-- Can Submit -->
                                    <div v-if="name != null && contactName != null && email != null && phone != null && city != null && state != null && zipCode != null">
                                        <button @click="step = 2" class="booking-button w-full">Next</button>
                                    </div>
                                </div>
                                <!-- Step 2 -->
                                <div v-if="step === 2">
                                    <!-- Availability -->
                                    <div class="w-full pb-2">
                                        <label class="text-white">What dates do you have available?</label>
                                        <textarea class="form-input w-full" v-model="availability" placeholder="Enter your availability"></textarea>
                                    </div> 
                                    <button v-if="availability != null && availability != ''" @click="step = 3" class="booking-button w-full">Next</button>                                
                                </div>
                                <!-- Step 3 -->
                                <div v-if="step === 3">
                                    <!-- Genres -->
                                    <div class="w-full pb-2">
                                        <label class="text-white">What genres can be booked?*</label>
                                        <textarea class="form-input w-full" v-model="genres" placeholder="Enter your genre(s)"></textarea>
                                    </div> 
                                    <button v-if="genres != null && genres != ''" @click="step = 4" class="booking-button w-full">Next</button>                                
                                </div>
                                <!-- Step 4 -->
                                <div v-if="step === 4">
                                    <!-- Availability -->
                                    <div class="w-full pb-2">
                                        <label class="text-white">Additional information</label>
                                        <textarea class="form-input w-full" v-model="message" placeholder="Enter a message"></textarea>
                                    </div> 
                                    <button v-if="isValidated === true" @click="submit()" class="booking-button w-full">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Loading -->
                    <div v-else class="pt-4 pb-4 text-white">
                        <div style="width:100%;max-width:120px;margin:0 auto;">
                            <div class="loading">
                                <svg xmlns="http://www.w3.org/2000/svg"  fill="none" viewBox="0 0 24 24" stroke="white">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                </svg>
                            </div>
                        </div>
                        <div class="text-center">
                            Submitting your information
                        </div>   
                    </div> 
                </div>
            </div> 
        </div>

        <Footer page="booking" />
    </div>
</template>

<script>
    import Header from '@/Pages/Partials/Header'
    import Footer from '@/Pages/Partials/Footer'

    export default {
        components: {
            Header, Footer 
        },

        data() {
            return {  
                step: 0,
                type: null,
                name: null,
                contactName: null,
                email: null,
                phone: null,
                city: null,
                state: null,
                message: null,
                address: null,
                zipCode: null,
                url: null,
                genres: null,
                gigSwap: null,
                gigSwapAway: null,
                gigSwapHome: null,
                availability: null,
                isLoading: false,
                isValidated: false,
                errCode: null,
                errMsg: null
            }
        },
        mounted() {
            
        },
        methods: {
            submit: function() {
                this.isLoading = true
                axios.post('/api/booking-request', {
                    type: this.type,
                    name: this.name,
                    contact_name: this.contactName,
                    email: this.email,
                    phone: this.phone,
                    address: this.address,
                    city: this.city,
                    state: this.state,
                    zip: this.zipCode,
                    url: this.url,
                    genres: this.genres,
                    gig_swap: this.gigSwap,
                    gig_swap_home: this.gigSwapHome,
                    gig_swap_away: this.gigSwapAway,
                    dates: this.availability,
                    message: this.message
                }).then((response) => {
                    // Success
                    if(response.data.message == 'success') {
                        this.errCode = 'success'
                        this.errMsg = 'Your information has been sent and we will be in touch.'
                        this.resetForm()
                    }
                    // Something went wrong
                    if(response.data.message == 'fail' ) {
                        this.errCode = 'fail'
                        this.errMsg = 'Something went wrong!'
                    }
                    // Something went wrong
                    if(response.data.message == 'fail-validation' ) {
                        this.errCode = 'fail-validation'
                        this.errMsg = 'Please make sure your email address is a valid email.'
                    }
                    this.isLoading = false  
                }).catch(error => {
                    // Something went wrong
                    this.errCode = 'fail'
                    this.errMsg = 'Something went wrong!'
                    this.isLoading = false 
                });
            },
            validateForm: function() {
                if(this.name != null && this.name != '') {
                    if(this.email != null && this.email != '') {
                        if(this.phone != null && this.phone != '') {
                            if(this.contactName != null && this.contactName != '') {
                               
                                if(this.city != null && this.city != '') {
                                    if(this.state != null && this.state != '') {
                                        if(this.zipCode != null && this.zipCode != '') {
                                            if(this.genres != null && this.genres != '') {
                                                this.isValidated = true
                                            } else {
                                                this.isValidated = false
                                            }
                                        } else {
                                            this.isValidated = false
                                        }
                                    } else {
                                        this.isValidated = false
                                    }
                                } else {
                                    this.isValidated = false
                                }

                            } else {
                                this.isValidated = false
                            }
                        } else {
                            this.isValidated = false
                        }
                    } else {
                        this.isValidated = false
                    }
                } else {
                    this.isValidated = false
                 }
            },
            resetForm: function() {
                this.step = 0
                this.type = null
                this.name = null
                this.contactName = null
                this.email = null
                this.phone = null
                this.message = null
                this.city = null
                this.state = null
                this.address = null
                this.zipCode = null
                this.url = null
                this.genres = null
                this.gigSwap = null
                this.gigSwapHome = null
                this.gigSwapAway = null
                this.isValidated = false
                this.availability = null
            }
        },
        watch: {
            type: function() {
                if(this.type != null) {
                    this.step = 1
                }
            },
            email: function() {
                this.validateForm()
            },
            message: function() {
                this.validateForm()
            },
            name: function() {
                this.validateForm()
            },
            address: function() {
                this.validateForm()
            },
            contactName: function() {
                this.validateForm()
            },
            city: function() {
                this.validateForm()
            },
            availability: function() {
                this.validateForm()
            },
            genres: function() {
                this.validateForm()
            },
            url: function() {
                this.validateForm()
            },
            state: function() {
                this.validateForm()
            },
            zipCode: function() {
                this.validateForm()
            },
            phone: function() {
                this.validateForm()
            },
            gigSwap: function() {
                if(this.gigSwap != null) {
                    if(this.gigSwap === 1) {
                        this.step = 5
                    }
                    if(this.gigSwap === 0) {
                        this.step = 7
                    }
                }
            }
        }
    }
</script>
