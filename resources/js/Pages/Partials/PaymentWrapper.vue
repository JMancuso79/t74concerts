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
										{{concert.title}}
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
									<div class="font-bold mt-4 mb-4">
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
									<div class="mt-4">
										{{items.length}} Ticket(s)<br><span class="font-bold ">Total: ${{total}}</span>
									</div>
									<div v-if="items.length > 0" class="mt-4">
										<!-- Promo Code -->
										<div v-if="showPromo === true">
											<!-- Promo Code -->
	                                        <div v-if="promoMsg != null" class="mt-2 mb-2 font-bold">
	                                            {{promoMsg}}
	                                        </div>
	                                        <label>If you have a promo code, please enter it.</label><br>
	                                        <input type="text" class="form-input" v-model="promoCode" placeholder="Promo Code">
	                             
	                                        <button v-if="promoCode != null && promoCode != ''" class="ml-1 bg-secondary p-2 text-white" @click.prevent="doPromoCode()">
	                                            Apply
	                                        </button>
	                                        <p class="text-sm">Promo code discounts are only applied to "General Admission" tickets</p>
	                                    </div>
                                        <div class="pt-4">

					                        <button class="bg-gray-400 text-white pt-2 pb-2 w-full font-bold"  @click.prevent="step = 2">
					                            Skip
					                        </button>
					                    </div>
									</div>
								</div>
								<!-- 
									Payment Info 
								-->
								<div v-if="step === 2">
                                    <p class="font-bold mt-2 mb-2 text-lg border-bottom">Total: ${{total}}</p>
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
                promoCode: null,
                promoMsg: null,
                promoDiscount: 0,
                showPromo: false,
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
        	}
        },
        mounted() {
            if(this.concert) {
                this.doTickets()
            }
        },
        methods: {
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
                /*if(this.promoCode) {
                    if(this.promoCode.toLowerCase() == 'beyondfm' || this.promoCode.toLowerCase() == 'ramone') {
                        this.promoDiscount = 5 * this.ticketNumber
                        this.promoMsg = 'Success! Your total has been updated.'
                    } else {
                        this.promoMsg = 'That code does not match a valid promo code.'
                    }
                }*/
            }         
        },
        watch: {
        	items: {
        		handler() {
        			this.total = 0
        			this.showPromo = false
	                for(var x=0;x<this.items.length;x++) {
	                	if(this.items[x].type == 'general-admission') {
	                		this.showPromo = true
	                	}
	                	this.total = parseInt(this.items[x].price) + parseInt(this.total)
	                }
        		},
        		deep: true
        	}
        }
    }
</script>