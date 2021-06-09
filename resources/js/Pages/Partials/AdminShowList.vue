<template>
    <div>

        <div v-for="concert in concerts" :key="concert" class="mb-3 pb-3" style="border-bottom:1px solid #eeeeee;">
            <h3 class="text-xl font-bold">{{concert.title}}</h3>
            <p>{{concert.human_date}} {{concert.event.venue.name}}</p>
            <div class="grid grid-cols-1 mt-2 md:grid-cols-3 md:gap-4">
                <div class="text-center bg-gray-200 p-2 mb-3">
                    <span class="font-bold">Tickets Sold</span><br>
                    <span class="text-2xl">{{concert.orders[0].tickets_sold}}</span>
                </div>
                <div class="text-center bg-gray-200 p-2 mb-3">
                    <span class="font-bold">Gross Sales</span><br>
                    <span class="text-2xl">${{concert.orders[0].gross_sales}}</span>
                </div>
                <div class="mb-3">
                    <a class="block p-2 border-2 border-black pointer text-center font-bold" :href="'/manage/concert/'+concert.id">
                        Manage
                    </a>
                </div>
            </div>
        </div>

        <!--<div v-if="orders.length > 0">
            <div v-for="order in orders" :key="order" class="mb-3">
                <h3 class="text-lg font-bold mb-3">#{{order.id}}</h3>
 
            </div>
        </div> 
        <div v-else>
            There are currently no ticket sales
        </div>  -->  

    </div>
</template>

<script>
    /*import JetDropdown from '@/Jetstream/Dropdown'
    import JetDropdownLink from '@/Jetstream/DropdownLink'
    import JetNavLink from '@/Jetstream/NavLink'
    import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink'*/
    import { parseISO, format } from 'date-fns'
    export default {
        components: {
            /*JetDropdown,
            JetDropdownLink,
            JetNavLink,
            JetResponsiveNavLink,*/
        },
        mounted() {
            this.getOrdersByConcert()
            this.getConcerts()
        },
        data() {
            return {
                orders: [],
                concerts: []
            }
        },

        methods: {
            getConcerts: function() {
                //this.isLoading = true
                axios.get('https://api.artistwave.com/api/get/all-page-concerts/91')
                .then((response) => {
                    console.log(response.data)
                    if(response.data) {
                        this.concerts = response.data
                        this.doList()
                        //this.isLoading = false
                    }

                }).catch(error => {
                    //this.isLoading = false
                    console.log(error)
                });

            },
            getOrdersByConcert: function(id) {
                axios.get('/web-api/orders-by-concert')
                .then((response) => {
                    this.orders = response.data
                }).catch(error => {
                    console.log(error)
                });
            },
            doList: function() {
                if(this.concerts) {
                    // Loop through concerts
                    for(var i=0;i<this.concerts.length;i++) {
                        this.concerts[i].orders = []
                        this.concerts[i].human_date = format(parseISO(this.concerts[i].event.date_time), 'MMMM dd, yyyy')
                        // for each concert loop through orders and locate concert/order
                        for(var x=0;x<this.orders.length;x++) {
                            if(this.concerts[i].id === this.orders[x].id) {
                                this.concerts[i].orders.push(this.orders[x])
                            }
                        }
                    }
                }
            }            
        }
    }
</script>
