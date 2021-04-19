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
                <div v-if="venue != null && venue != undefined && venue != []">
                    <div class="grid grid-cols-1 text-white">
                        <div class="p-2">
                            <div class="max-w-md mx-auto dark:bg-gray-800 rounded-xl shadow-md overflow-hidden md:max-w-2xl">
                                <a :href="'/venue/'+venue.slug" class="block mt-1 text-lg leading-tight font-medium text-gray-500 hover:underline">
                                    {{venue.name}}
                                </a>
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
            'slug'
        ],
        mounted() {
            if(this.slug) {
                this.getVenue()
            }
        },
        data() {
            return {
                // Venue
                venue: [],
                // Venues
                venues: [
                    {
                        name: 'Tiki Bar',
                        slug: 'tiki-bar',
                        address: '1700 Placentia Ave', 
                        city: 'Costa Mesa',
                        state: 'CA',
                        zipCode: 92627,
                        website: 'https://tikibaroc.com/'
                    },
                    {
                        name: 'Tiki Bar',
                        slug: 'tiki-bar',
                        address: '3040 Locust Street.', 
                        city: 'St. Louis',
                        state: 'MO',
                        zipCode: 63103,
                        website: 'https://redflagstl.com/'
                    },
                ],
            }
        },
        methods: {
            getVenue: function() {
                if(this.venues) {
                    if(this.venues.length > 0) {
                        for(var i=0;i<this.venues.length;i++) {
                            if(this.slug === this.venues[i].slug) {
                                this.venue = this.venues[i]
                            }
                        }
                    }
                }
            },
        }
    }
</script>


