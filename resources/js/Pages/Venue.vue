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
                <div class="dark:bg-gray-200 ml-4 mr-4 mb-4 md:m-0">
                    <!-- Concert -->
                    <div v-if="venue != null && venue != undefined && venue != []">
                        <div>
                            <div class="p-2">
                                <div>
                                    <p class="text-lg leading-tight font-bold">
                                        {{venue.name}}
                                    </p>
                                    <p>
                                        {{venue.address}}<br>
                                        {{venue.city}}, {{venue.state}} {{venue.zipCode}}
                                    </p>
                                    <p v-if="venue.website">Website: <a :href="venue.website" target="_blank">{{venue.website}}</a></p>
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
        <div class="mt-4">
            <ArtistWave />
        </div>
    </div>
</template>

<script>
    import Header from '@/Pages/Partials/Header'
    import ArtistWave from '@/Pages/Partials/ArtistWave'

    export default {
        components: {
            Header, ArtistWave
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
                        name: 'Red Flag STL',
                        slug: 'red-flag-stl',
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


