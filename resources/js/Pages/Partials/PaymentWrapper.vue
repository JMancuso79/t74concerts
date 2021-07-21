<template>
	<div id="modal-template">
		<transition name="modal">
			<div class="modal-mask">
				<div class="modal-wrapper">
					<div class="modal-container">

						<div class="modal-header">
							<slot name="header">
								<button class="modal-default-button" @click="$emit('close')">
									<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
								 		<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
									</svg>
								</button>

							</slot>
						</div>

						<div class="modal-body">
							<slot name="body">
								<div v-if="isLoading === false">

									<!-- 
										Select Tickets 
									-->
									<div v-if="step === 0">
										<p class="font-bold mb-2 text-dark">Select Ticket(s)</p>
										<div v-for="ticket in onSaleTix">
											<div class="grid grid-flow-col gap-1 mb-1 border-bottom pb-1">
												<div class="row-span-2 col-span-2 capitalize">${{ticket.price}} {{ticket.label}}</div>
												<div class="row-span-2 text-right">
													<button class="pt-2 pb-2 pr-4 pl-4 text-sm bg-green text-white" @click.prevent="addItem(ticket)">
														<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
															<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
														</svg>
													</button>
												</div>
											</div>
											
										</div>

										<div v-for="(item, index) in items">
											<div class="grid grid-flow-col gap-1 mb-1 border-bottom pb-1 text-sm">
												<div class="capitalize">
													{{item.label}}
												</div>
												<div class="text-right">
													${{item.price}}
													<button class="ml-2 mr-2" @click.prevent="removeItem(index)">
														<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" :stroke="currentColor">
														  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
														</svg>
													</button>
												</div>
											</div>
										</div>
										<div class="mt-4 mb-4">
											{{items.length}} Ticket(s)<br><span class="font-bold ">Total: ${{total}}</span>
										</div>
				                        <button v-if="items.length > 0" class="bg-primary text-white pt-2 pb-2 w-full font-bold" @click.prevent="step = 1">
				                            Continue
				                        </button>
									</div>
									<!-- 
										Promo Code 
									-->
									<div v-if="step === 1 && promoCode != 'success'">
										<!--  -->
										<div v-if="showPromoCode === null">
											<p class="font-bold text-dark mb-2">Do you have a promo code?</p>
		                                    <div class="grid grid-cols-2 gap-2">
		                                        <div>
		                                            <!-- Group -->
		                                            <div class="w-full pb-2">
		                                                <button class="w-full bg-primary p-2 text-white font-bold" @click.prevent="showPromoCode = true">
		                                                	Yes
		                                                </button>
		                                            </div>
		                                        </div>
		                                        <div>
		                                            <div class="w-full pb-2">
		                                                <button class="w-full bg-gray-200 p-2 font-bold" @click.prevent="showPromoCode = false">
		                                                	No
		                                                </button>         
		                                            </div>
		                                        </div>
		                                    </div>
										</div>

										<!-- Promo Code Form -->
										<div v-if="showPromoCode === true">
											<div v-if="items.length > 0" class="mt-4">
												<!-- Promo Code -->
												<div>
													<p class="font-bold text-dark mb-2">Promo Code</p>
													<!-- Promo Code -->
			                                        <div v-if="promoMsg != null" class="mt-2 mb-4 font-bold">
			                                            <span class="text-danger" v-if="promoMsg == 'fail'">That didn't work!</span>
			                                            <span class="text-success" v-if="promoMsg == 'success'">Your discount has been applied!</span>
			                                        </div>
			                                        <div v-if="promoMsg === null || promoMsg == 'fail'">
			                                        	<input type="text" class="form-input" v-model="promoCode" placeholder="Enter promo code">
			                             
			                                        	<button v-if="promoCode != null && promoCode != ''" class="ml-1 bg-secondary p-2 text-white" @click.prevent="doPromoCode()">
			                                            	Apply
			                                        	</button>
			                                        </div>
			                                        <!--<p class="text-sm mt-2">Promo code discounts are only applied to "General Admission" tickets</p>-->
			                                    </div>
												<div class="mt-4">
													{{items.length}} Ticket(s)<br><span class="font-bold ">Total: ${{total}}</span>
												</div>
		                                        <div class="mt-4">
							                        <button v-if="promoMsg === null || promoMsg == 'fail'" class="bg-gray-200 pt-2 pb-2 w-full font-bold"  @click.prevent="step = 2">
							                            Skip
							                        </button>
							                        <button v-else class="bg-primary text-white pt-2 pb-2 w-full font-bold"  @click.prevent="step = 2">
							                            Continue
							                        </button>
							                    </div>
											</div>
										</div>
									</div>
									<!-- 
										Ticket Holder Info 
									-->
									<div v-if="step === 2">
	                                    <p class="font-bold mb-2 text-dark">Contact Information</p>
	                                    <div v-if="email && ticketHolder && contactFormValidated === false">
	                                    	<span class="text-danger">Email must be valid.</span>
	                                    </div>
	                                    <p class="text-sm mb-2 text-medium">Please enter the name of the person who will be checking in the day of the concert.</p>
	                                    <!-- Single -->
	                                    <div class="w-full pb-2">
	                                        <input type="text" class="form-input w-full" v-model="ticketHolder" placeholder="Name of ticket holder">
	                                    </div>
	                                    <!-- Group -->
	                                    <div class="w-full pb-2">
	                                        <input type="text" class="form-input w-full" v-model="email" placeholder="email*">
	                                        <p class="text-sm mt-2 text-medium">We only use your email to contact you about your order.</p>
	                                    </div>
				                        <button v-if="contactFormValidated === true" class="bg-primary text-white pt-2 pb-2 w-full font-bold" @click.prevent="step = 3">
				                            Check Out
				                        </button>

									</div>
									<!-- 
										Payment Info 
									-->
									<div v-if="step === 3">
	                                    <p class="font-bold text-dark mb-2">Payment Information</p>
	                                    <p class="text-sm mb-2 text-medium">Your payment is processed securely through Stripe. Your card details are never stored on our servers.</p>
		                                <p v-if="errCode" class="mb-4 pb-2 text-xl" style="border-bottom:2px solid #eeeeee;">
		                                    <span v-if="errCode == 'success'" class="text-success">{{errMsg}}</span>
		                                    <span v-else class="text-danger">{{errMsg}}</span>
		                                </p>
	                                    <!-- Single -->
	                                    <div class="w-full pb-2">
	                                        <input type="text" class="form-input w-full" v-model="nameOnCard" placeholder="Name on card*">
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
	                                    <div class="w-full pb-2">
	                                        <input type="text" class="form-input w-full" v-model="zip" placeholder="Zip Code*">
	                                    </div>
				                        <button v-if="paymentFormValidated === true" class="bg-primary text-white pt-2 pb-2 w-full font-bold" @click.prevent="step = 4">
				                            Review Order
				                        </button>
	                                </div>
									<!-- 
										Review Order 
									-->
									<div v-if="step === 4">
										<p class="font-bold text-dark mb-2">Review Order</p>
										<p class="text-right">
											<button @click.prevent="step = 0" class="text-primary">Edit Order</button>
										</p>
										<p>Ticket Holder: {{ticketHolder}}</p>
										<div v-for="(item, index) in items">
											<div class="grid grid-flow-col gap-1 mb-1 border-bottom pb-1 text-sm">
												<div class="capitalize">
													{{item.label}}
												</div>
												<div class="text-right">
													${{item.price}}
													<button class="ml-2 mr-2" @click.prevent="removeItem(index)">
														<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" :stroke="currentColor">
														  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
														</svg>
													</button>
												</div>
											</div>
										</div>
										<div v-if="promoMsg == 'success'" class="mt-4 mb-4">
											Promo code discount: ${{promoDiscount}}
										</div>
										<div class="font-bold mt-4 mb-4">
											{{items.length}} Ticket(s)<br><span class="font-bold ">Total: ${{total}}</span>
										</div>
										<div>
											<input type="checkbox" id="agreement" name="agreement" v-model="iAgree" :value="true">
											<label class="ml-2 mb-2 text-xs"> I understand that all ticket sales are final and only refundable if the concert is canceled.</label>
										</div>
				                        <button v-if="paymentFormValidated === true && iAgree === true" class="bg-primary text-white mt-4 pt-2 pb-2 w-full font-bold" @click.prevent="sendPayment()">
				                            Submit Payment
				                        </button>
									</div>
									<!-- 
										Payment submitted 
									-->
									<div v-if="step === 5">
										<p class="text-success text-xl font-bold mb-2">
											Your purchase is complete.  
										</p>
										<p class="text-medium mb-2">
											Your name has been added to the will call list. We've also emailed a confirmation to you. 
										</p>
										<p class="text-medium mb-2">
											<a class="font-bold" href="/contact">Click here</a> if you have a question about your order.
										</p>
										<div class="mb-2">
											<span class="font-bold text-dark">Which artist are you most excited to see?</span>
										</div>



	                                    <div class="grid grid-cols-2 gap-2 mb-4 pb-2 pt-2" style="border-top:1px solid #eeeeee;border-bottom:1px solid #eeeeee;">
	                                        <div>
	                                        	<button class="text-dark" @click.prevent="checkAll()">
													<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
													  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
													</svg>
	                                        		Check All
	                                        	</button>
	                                        </div>
	                                        <div class="text-right">
	                                        	<button class="text-dark" @click.prevent="artists = []">
													<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
													  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
													</svg>
	                                        		Reset
	                                        	</button>
	                                        </div>
	                                    </div>


										<div v-for="(artist, index) in concert.artists" :key="artist">
											<input type="checkbox" :id="'artist-'+index" :name="'artist '+index" :value="artist.id" v-model="artists">

											<label class="ml-2 mb-2">{{artist.name}}</label>
										</div>
				                        <button v-if="artists.length > 0" class="bg-primary text-white mt-4 pt-2 pb-2 w-full font-bold" @click.prevent="storeCustomerArtists()">
				                            Submit
				                        </button>
									</div>
									<!-- 
										Payment submitted 
									-->
									<div v-if="step === 6">
										<p class="text-dark text-xl font-bold mb-4">
											Thank you for supporting live music! 
										</p>

										<button class="w-full bg-gray-200 p-2 font-bold text-dark" @click.prevent="$emit('close')">
											Close
										</button>
									</div>
								</div>
								<!-- loading -->
								<div v-else class="p-4">
                                    <div style="width:100%;max-width:120px;margin:0 auto;">
                                        <div class="loading">
                                            <svg xmlns="http://www.w3.org/2000/svg"  fill="none" viewBox="0 0 24 24" stroke="black">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div v-if="step == 4" class="text-center">
                                        Purchasing your ticket
                                    </div> 
                                    <div v-else class="text-center">
                                        Loading
                                    </div> 
								</div>
							</slot>

							<!--<div class="modal-footer">
								<slot name="footer">
									

								</slot>
							</div>-->
						</div>
					</div>
				</div>
			</div>
		</transition>
	</div>
</template>

<script>
    export default {
        components: {
  
        },
        props: ['concert'],
        data() {
        	return {
        		step: 0,
        		onSaleTix: [],
        		items: [],
        		total: 0,
        		currentColor: 'red',
        		promoCodes: null,
                promoCode: null,
                promoMsg: null,
                promoDiscount: 0,
                showPromoCode: null,
                isPromoCode: false,
                artists: [],
                //
                nameOnCard: null,
                email: null,
                cardNumber: null,
                expMonth: null,
                expYear: null,
                cvv: null,
                address: null,
                city: null,
                state: null,
                zip: null,
                ticketHolder: null,
                contactFormValidated: false,
                paymentFormValidated: false,
                isLoading: false,
                errCode: null,
                errMsg: null,
                iAgree: false
        	}
        },
        mounted() {
        	
            if(this.concert) {
            	this.getPromoCodes()
                this.doTickets()
            }
        },
        methods: {
			getPromoCodes: function() {
                axios.get('/api/get/promo-codes/' + this.concert.id)
                .then((response) => {
                    this.promoCodes = response.data
                    if(this.promoCodes && this.promoCodes.length) {
                    	this.isPromoCode = true
                    }
                }).catch(error => {
                    console.log(error)
                });
			},
            doTickets: function() {
                this.onSaleTix = []
                for(var x=0;x<this.concert.tickets.length;x++) {
                    if(this.concert.tickets[x].status === 1) {
                        this.onSaleTix.push(this.concert.tickets[x])
                    }
                }
            },
            addItem: function(item) {
 				this.items.push(item)
            },
            removeItem: function(index) {
 				this.items.splice(index, 1)
            }, 
            doPromoCode: function() {
                if(this.promoCodes && this.promoCodes.length > 0) {
                	this.promoMsg = null
                	let x = 0
                	let promoData = null
                	for(var i=0;i<this.promoCodes.length;i++) {
                		if(this.promoCodes[i].code.toLowerCase() == this.promoCode.toLowerCase()) {
                			x = 1
                			promoData = this.promoCodes[i]
                		}
                	}
                	if(x === 0) {
                		this.promoMsg = 'fail'
                	}
                	if(x === 1) {
                		this.promoMsg = 'success'
                		// do calculation
                		this.doDiscount(promoData)
                	}
                }
            },
            doDiscount: function(promoData) {
            	if(promoData) {
            		let tixNum = this.items.length
            		let discountAmount = 0
            		if(promoData.discount_type == 'dollars') {
            			discountAmount = tixNum * promoData.discount
            		}
             		if(promoData.discount_type == 'percent') {
            			// Do percentage
            		}         
            		if(discountAmount > 0) {
            			this.total = this.total - discountAmount
            			this.promoDiscount = discountAmount
            		} 

            		//console.log(discountAmount) 		
            	}
            },
            checkAll: function() {
            	if(this.concert.artists) {
            		this.artists = []
            		for(var i=0;i<this.concert.artists.length;i++) {
            			this.artists.push(this.concert.artists[i].id)
            		}
            	}
            },
            storeCustomerArtists: function() {
            	this.isLoading = true
                axios.post('/api/store/customer-artists', {
                	artists: this.artists,
                	concert_id: this.concert.id,
                }).then((response) => {
                	if(response.data.code == 'complete') {
                		this.step = 6
                		this.artists = []
                		// reset form
                	}
                }).catch(error => {
                	console.log(error)
                })
                this.isLoading = false
            },
            validateContactForm: function() {
            	if(this.items.length > 0 && this.email && this.email != '' && this.ticketHolder && this.ticketHolder != '') {
            		if(this.validateEmail(this.email) === true) {
            			this.contactFormValidated = true
            		} else {
            			this.contactFormValidated = false
            		}
            	}	
            },
			validateEmail: function(val) {
				const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
				return re.test(val);
			},
            validatePaymentForm: function() {
                // Validate Name on card
                let isNameValidated = false
                if(this.nameOnCard != null && this.nameOnCard != '') {
                    isNameValidated = true
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
                // Validate Zip
                let isZipValidated = false
                if(this.zip != null && this.zip != '') {
                    isZipValidated = true
                }
                // If there are no false validations
                if(isNameValidated !== false && isCardNumberValidated !== false && isMonthValidated !== false && isYearValidated !== false && isCvvValidated !== false && isZipValidated !== false) {
                    this.paymentFormValidated = true
                } else {
                    this.paymentFormValidated = false
                }
            },   
            sendPayment: function() {
            	let pc = null;
            	if(this.promoMsg == 'success') {
            		pc = this.promoCode
            	}
                this.isLoading = true
                axios.post('/api/payment', {
	                email: this.email,
	                nameOnCard: this.nameOnCard,
	                cardNumber: this.cardNumber,
	                expMonth: this.expMonth,
	                expYear: this.expYear,
	                cvv: this.cvv,
	                zip: this.zip,
	                total: this.total,
	                ticketHolder: this.ticketHolder,
	                ticketNumber: this.items.length,
	                concertId: this.concert.id,
	                promo_code: pc,
	                concert: this.concert
                }).then((response) => {

                    // Validation error
                    if(response.data.code == 'fail-validation' ) {
                        this.errCode = 'fail-validation'
                        this.errMsg = response.data.errors
                        this.step = 3
                    } 
                    // All others
                    else {
                        this.errCode = response.data.code
                        this.errMsg = response.data.message
                        // Success
                        if(this.errCode == 'success') {
                            this.step = 5
                            //this.resetForm()
                        } else {
                        	this.step = 3
                        }
                    }

                    this.isLoading = false  
                }).catch(error => {
                    
                    // Something went wrong
                    this.errCode = error.code
                    this.errMsg = error.message
                    this.step = 3
                    this.isLoading = false 

                });
            },      
        },
        watch: {
        	items: {
        		handler() {
        			this.total = 0
        			this.showPromo = false
        			this.promoMsg = null
        			this.promoDiscount = 0
        			this.isPromoCode = false
                    if(this.promoCodes && this.promoCodes.length) {
                    	this.isPromoCode = true
                    }
        			//this.isPromoCode = false
        			if(this.items.length < 1) {
        				this.step = 0
        			} else {
		                for(var x=0;x<this.items.length;x++) {
		                	this.total = parseInt(this.items[x].price) + parseInt(this.total)
		                }	
        			}
        		},
        		deep: true
        	},
        	showPromoCode: function() {
        		if(this.showPromoCode === false) {
        			this.step = 2
        		}
        	},
        	step: function() {
        		if(this.step === 1) {
        			if(this.isPromoCode === false) {
        				this.step = 2
        			}
        		}

        	},
        	ticketHolder: function() {
        		this.validateContactForm()
        	},
        	email: function() {
        		this.validateContactForm()
        	},
        	nameOnCard: function() {
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
        	zip: function() {
        		this.validatePaymentForm()
        	},
        }
    }
</script>