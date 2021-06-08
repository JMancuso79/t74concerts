<template>
    <div class="feat-bg">
        <!-- 
            Header
        -->
        <Header />
        <!-- 
            Content 
        -->
        <div class="top-spacer">
            <div class="max-width mx-auto pt-4">
                <div class="md:m-0">
                    <!-- 
                        Not Loading 
                    -->
                    <div v-if="isLoading === false">

                    </div>
                    <!-- Loading -->
                    <div v-else class="p-4">
                        <div style="width:100%;max-width:120px;margin:0 auto;">
                            <div class="loading">
                                <svg xmlns="http://www.w3.org/2000/svg"  fill="none" viewBox="0 0 24 24" stroke="black">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                </svg>
                            </div>
                        </div>
                        <div class="text-center">
                            Loading
                        </div> 
                    </div>
                </div>
            </div>
        </div>

        <Footer page="concerts" />
    </div>
</template>

<script>
    import Header from '@/Pages/Partials/Header'
    import Footer from '@/Pages/Partials/Footer'

    export default {
        components: {
            Header, Footer
        },
        mounted() {
            this.getConcerts()
        },
        data() {
            return {
                // Concerts
                concerts: [],
                matchedItems: [],
                region: 'default',
                defaultClass: 'active-location-tab',
                westCoastClass: 'location-tab',
                midWestClass: 'location-tab',
                isLoading: false,
            }
        },
        methods: {
            getConcerts: function() {
                axios.get('/data/concerts.json')
                .then((response) => {
                    if(response.data) {
                        this.concerts = response.data
                    }
                }).catch(error => {
                    console.log(error)
                });
            },
            filterConcerts() {
                // Default
                if(this.region == 'default') {
                    this.matchedItems = []
                    for(var i=0;i<this.concerts.length;i++) {
                        if(this.concerts[i].venue) {
                            if(this.concerts[i].venue[0]) {
                                if(this.concerts[i].status == 'active') {
                                    this.matchedItems.push(this.concerts[i])
                                }
                            }  
                        }
                    }
                } 
                // Selected Region
                else {
                    this.matchedItems = []
                    for(var i=0;i<this.concerts.length;i++) {
                        if(this.concerts[i].venue) {
                            if(this.concerts[i].venue[0]) {
                                if(this.concerts[i].venue[0].region == this.region) {
                                    if(this.concerts[i].status == 'active') {
                                        this.matchedItems.push(this.concerts[i])
                                    }
                                    
                                }
                            }  
                        }

                    }
                }
            }
        },
        watch: {
            concerts: {
                handler() {
                    if(this.concerts) {
                        if(this.concerts.length > 0) {
                            this.matchedItems = []
                            for(var i=0;i<this.concerts.length;i++) {
                                if(this.concerts[i].venue) {
                                    if(this.concerts[i].venue[0]) {
                                        if(this.concerts[i].status == 'active') {
                                            this.matchedItems.push(this.concerts[i])
                                        }
                                    }  
                                }
                            }
                        }
                    }
                },
                deep:true
            },
            region: function() {
                // Default
                if(this.region == 'default') {
                    this.defaultClass = 'active-location-tab'
                    this.westCoastClass = 'location-tab'
                    this.midWestClass = 'location-tab'
                }
                // West Coast
                if(this.region == 'west-coast') {
                    this.defaultClass = 'location-tab'
                    this.westCoastClass = 'active-location-tab'
                    this.midWestClass = 'location-tab'
                }
                // Midwest
                if(this.region == 'midwest') {
                    this.defaultClass = 'location-tab'
                    this.westCoastClass = 'location-tab'
                    this.midWestClass = 'active-location-tab'
                }
                this.filterConcerts()
            }
        }
    }
</script>
