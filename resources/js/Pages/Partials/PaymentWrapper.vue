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
								<div>
									<span class="font-bold text-lg">
										Buy Tickets | {{concert.title}}
									</span>
								</div>
							</slot>
						</div>

						<div class="modal-body">
							<slot name="body">
								<!-- 
									Select Tickets 
								-->
								<div v-if="step === 0">
									<p class="font-bold mb-2">Select Ticket(s)</p>
									<div v-for="ticket in onSaleTix">
										<div class="grid grid-flow-col gap-1 mb-1 border-bottom pb-1">
											<div class="row-span-2 col-span-2 capitalize">${{ticket.price}} {{ticket.label}}</div>
											<div class="row-span-2 text-right">
												<button class="pt-2 pb-2 pr-4 pl-4 text-sm bg-green text-white" @click.prevent="addItem(ticket)">
													Select
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
								<div v-if="step === 1">
									<!--  -->
									<div v-if="showPromoCode === null">
										Do you have a promo code?
	                                    <div class="grid grid-cols-2 gap-2 mt-3">
	                                        <div>
	                                            <!-- Group -->
	                                            <div class="w-full pb-2">
	                                                <button class="w-full bg-primary p-2 text-white" @click.prevent="showPromoCode = true">
	                                                	Yes
	                                                </button>
	                                            </div>
	                                        </div>
	                                        <div>
	                                            <div class="w-full pb-2">
	                                                <button class="w-full bg-gray-200 p-2" @click.prevent="showPromoCode = false">
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
						                        <button v-if="promoMsg === null || promoMsg == 'fail'" class="bg-gray-400 text-white pt-2 pb-2 w-full font-bold"  @click.prevent="step = 2">
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
                                    <p class="font-bold mb-2">Contact Information</p>
                                    <p style="font-size:14px; color:#444444;" class="mb-2">Please enter the name of the person who will be checking in the day of the concert.</p>
                                    <!-- Single -->
                                    <div class="w-full pb-2">
                                        <input type="text" class="form-input w-full" v-model="ticketHolder" placeholder="Name of ticket holder">
                                    </div>
                                    <!-- Group -->
                                    <div class="w-full pb-2">
                                        <input type="text" class="form-input w-full" v-model="email" placeholder="email*">
                                        <p class="text-sm">We only use your email to contact you about your order.</p>
                                    </div>
			                        <button v-if="items.length > 0" class="bg-primary text-white pt-2 pb-2 w-full font-bold" @click.prevent="step = 3">
			                            Check Out
			                        </button>

								</div>
								<!-- 
									Payment Info 
								-->
								<div v-if="step === 3">
                                    <p class="font-bold mb-2">Payment Information</p>
                                    <p style="font-size:14px; color:#444444;" class="mb-2">Your payment is processed securely through Stripe. Your card details are never stored on our servers.</p>
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
			                        <button v-if="items.length > 0" class="bg-primary text-white pt-2 pb-2 w-full font-bold" @click.prevent="step = 4">
			                            Review Order
			                        </button>
                                </div>
								<!-- 
									Review Order 
								-->
								<div v-if="step === 4">
									<p class="font-bold mb-2">Review Order</p>
									<p class="text-right">
										<button @click.prevent="step = 0">Edit Order</button>
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
									<div class="font-bold mt-4 mb-4">
										{{items.length}} Ticket(s)<br><span class="font-bold ">Total: ${{total}}</span>
									</div>
									<div>
										<input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">

										<label class="mb-2 text-xs"> I understand that all ticket sales are final and only refundable if the concert is canceled.</label>
									</div>
			                        <button v-if="items.length > 0" class="bg-primary text-white mt-4 pt-2 pb-2 w-full font-bold" @click.prevent="step = 5">
			                            Submit Payment
			                        </button>
								</div>
								<!-- 
									Payment submitted 
								-->
								<div v-if="step === 5">
									<div class="pb-3">
										<span class="text-success bold text-xl">
											Your tickets have been purchased!
										</span>
									</div>
									<div class="pb-3">
										<span class="text-lg">Which artist are you most excited to see?</span>
									</div>
                                    <div class="grid grid-cols-2 gap-2">
                                        <div>
                                        	<button class="w-full p-2 bg-primary text-white" @click.prevent="checkAll()">
                                        		Check All
                                        	</button>
                                        </div>
                                        <div>
                                        	<button class="w-full p-2 bg-gray-200 text-dark" @click.prevent="artists = []">
                                        		Reset
                                        	</button>
                                        </div>
                                    </div>
									<div v-for="(artist, index) in concert.artists" :key="artist">
										<input type="checkbox" :id="'artist-'+index" :name="'artist '+index" :value="artist.id" v-model="artists">

										<label class="ml-2 mb-2">{{artist.name}}</label>
									</div>
			                        <button v-if="artists.length > 0" class="bg-primary text-white mt-4 pt-2 pb-2 w-full font-bold" @click.prevent="step = 6">
			                            Submit
			                        </button>
								</div>
								<!-- 
									Payment submitted 
								-->
								<div v-if="step === 6">
									Done
								</div>
							</slot>
						</div>

						<!--<div class="modal-footer">
							<slot name="footer">
								

							</slot>
						</div>-->
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
                ticketHolder: null
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
            		} 
            		console.log(discountAmount) 		
            	}
            },
            checkAll: function() {
            	if(this.concert.artists) {
            		this.artists = []
            		for(var i=0;i<this.concert.artists.length;i++) {
            			this.artists.push(this.concert.artists[i].id)
            		}
            	}
            }         
        },
        watch: {
        	items: {
        		handler() {
        			this.total = 0
        			this.showPromo = false
	                for(var x=0;x<this.items.length;x++) {
	                	this.total = parseInt(this.items[x].price) + parseInt(this.total)
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
        	}
        }
    }
</script>