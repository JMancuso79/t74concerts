<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <div class="p-6 sm:px-20 bg-white border-b border-gray-200">

                        <div v-if="orders" class="mt-8 text-2xl">
                            Missing {{title}} 
                        </div>

                    </div>
                    <div class="p-6 sm:px-20">
                        <button @click.prevent="showPromoCodes = !showPromoCodes">
                            <span v-if="showPromoCodes === false">Open Promo Codes</span>
                            <span v-if="showPromoCodes === true">Close Promo Codes</span>
                        </button>
                    </div>
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

                    <div class="p-6 sm:px-20 bg-gray-200 bg-opacity-25">
                        <a class="block p-2 border-2 border-black pointer text-center font-bold" :href="'/box-office/'+id">
                            Box Office
                        </a>
                        <div>
                            <!-- Totals -->
                            <div class="pt-4 text-xl">
                                <div class="border-bottom">
                                    <strong>Tickets Sold: {{ticketsSold}}</strong> 
                                </div>
                                <div class="border-bottom">
                                    <strong>Gross Sales: ${{grossSales}}</strong>
                                </div>
                            </div>
                            <!-- Name Search -->
                            <div class="pt-4">
                                <input type="text" placeholder="Enter name" v-model="keyword" class="w-full" />
                            </div>
                            <!-- Reset -->
                            <div v-if="keyword != null && keyword != ''" class="pt-4">
                                <button class="w-full bg-gray-800 pt-2 pb-2 text-white" @click.prevent="resetItems()">Reset</button>
                            </div>
                            <div v-if="items.length > 0">
                                <!-- List -->
                                <div v-for="order in items" class="border-bottom">
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
        },
        data() {
            return {
                title: null,
                ticketsSold: 0,
                grossSales: 0,
                keyword: null,
                orders: [],
                items: [],
                promoCodes: null ,
                showPromoCodes: false
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
            doData: function(data) {
                this.orders = data.orders
                this.title = data.title
                this.ticketsSold = data.tickets_sold
                this.grossSales = data.gross_sales
                this.items = this.orders
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
            }
        }
    }
</script>
