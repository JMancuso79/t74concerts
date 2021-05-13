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

                        <div class="mt-8 text-2xl">
                            Welcome Tower74!
                        </div>

                    </div>

                    <div class="p-6 sm:px-20 bg-gray-200 bg-opacity-25">
                        <a class="block p-2 border-2 border-black pointer text-center font-bold" :href="'/box-office/'+id">
                            Box Office
                        </a>

                        <div v-if="orders">
                            <div v-if="orders.tickets_sold && orders.gross_sales" class="pt-4 text-xl">
                                <strong>Tickets Sold: {{orders.tickets_sold}}</strong><br> 
                                <strong>Gross Sales: ${{orders.gross_sales}}</strong>
                            </div>
                            <div v-for="order in orders.orders" class="border-bottom">
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

    export default {
        props: ['id'],
        components: {
            AppLayout,
            //Welcome,
        },
        mounted() {
            this.getOrders()
        },
        data() {
            return {
                orders: [],
            }
        },

        methods: {
            getOrders: function() {
                axios.get('/web-api/get-concert-orders/' + this.id)
                .then((response) => {
                    this.orders = response.data
                }).catch(error => {
                    console.log(error)
                });
            }, 
            getDate(d) {
                return format(Date.parse(d), 'eeee, MMMM dd yyyy | h:MM')
            }           
        }
    }
</script>
