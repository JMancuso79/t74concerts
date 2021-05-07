<template>
    <div>

        <div v-if="orders.length > 0">
            <div v-for="order in orders" :key="order" class="mb-3">
                <h3 class="text-lg font-bold mb-3">{{order.title}}</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 md:gap-4">
                    <div class="text-center bg-gray-200 p-2 mb-3">
                        <span class="font-bold">Tickets Sold</span><br>
                        <span class="text-2xl">{{order.tickets_sold}}</span>
                    </div>
                    <div class="text-center bg-gray-200 p-2 mb-3">
                        <span class="font-bold">Gross Sales</span><br>
                        <span class="text-2xl">${{order.gross_sales}}</span>
                    </div>
                    <div class="mb-3">
                        <a class="block p-2 border-2 border-black pointer text-center font-bold" :href="'/manage/concert/'+order.id">
                            Manage
                        </a>
                    </div>
                </div> 
            </div>
        </div> 
        <div v-else>
            There are currently no ticket sales
        </div>    

    </div>
</template>

<script>
    /*import JetDropdown from '@/Jetstream/Dropdown'
    import JetDropdownLink from '@/Jetstream/DropdownLink'
    import JetNavLink from '@/Jetstream/NavLink'
    import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink'*/

    export default {
        components: {
            /*JetDropdown,
            JetDropdownLink,
            JetNavLink,
            JetResponsiveNavLink,*/
        },
        mounted() {
            this.getOrdersByConcert()
        },
        data() {
            return {
                orders: [],
            }
        },

        methods: {
            getOrdersByConcert: function(id) {
                axios.get('/web-api/orders-by-concert')
                .then((response) => {
                    this.orders = response.data
                }).catch(error => {
                    console.log(error)
                });
            },            
        }
    }
</script>
