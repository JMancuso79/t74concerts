<template>
    <div>
        <div v-if="pass === null || pass != 'venuepass'">
            <div class="feat-bg">
                <img src="/images/tower-grey-trans.png" style="max-width:200px; width:100%;" class="mx-auto" />
            </div>
            <div class="max-width mx-auto p-4">
                <!-- Pass -->
                <div class="w-full pb-2">
                    <input type="password" class="form-input w-full" v-model="pass" placeholder="Enter password">
                </div>
            </div>
        </div>
        <div v-else>
            <div class="feat-bg">
                <div class="showcase-logo p-4 text-center w-full">
                    Tower74 Presents
                </div>
            </div>
            <div class="text-white">
                <div v-for="concert in concerts">
                    <div class="text-white">
                        <img v-if="concert.filename != null && concert.filename != ''" class="w-full" :src="concert.filename" :alt="concert.title">
                        <div>
                            {{concert.event.date_time}}
                        </div>
                        <div>
                            Title: {{concert.title}}
                        </div>
                        <div v-if="concert.tickets">
                            Tickets
                            <div v-for="ticket in concert.tickets">
                                {{ticket.label}}: {{ticket.price}}
                            </div>
                        </div>
                        <div>
                            {{concert.event.ticket_link}}
                        </div>
                        <div v-if="concert.artists">
                            Artists
                            <div v-for="artist in concert.artists">
                                {{artist.name}}
                                <div v-if="artist.image">
                                    <img :src="artist.image" />
                                </div>
                            </div>
                        </div>

                        <div>
                            Details: {{concert.description}}
                        </div>

                        <div v-if="concert.event.venue">
                            Venue 
                            <div v-if="concert.event.venue.image">
                                <img :src="concert.event.venue.image" />
                            </div>
                            <div>
                                {{concert.event.venue.name}}
                            </div>
                            <div>
                                {{concert.event.venue.street_address}}
                            </div>
                            <div>
                                {{concert.event.venue.city}}
                            </div>
                            <div>
                                {{concert.event.venue.state}}
                            </div>
                            <div>
                                {{concert.event.venue.zip_code}}
                            </div>
                            <div>
                                {{concert.event.venue.country}}
                            </div>
                        </div>
                        <div v-if="concert.genres">
                            <div v-for="genre in concert.genres">
                                {{genre.name}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    //import ArtistWave from '@/Pages/Partials/ArtistWave'

    export default {
        components: {
            //ArtistWave
        },

        data() {
            return {  
                pass: 'venuepass',
                concerts: []
            }
        },
        mounted() {
            this.getConcerts()
        },
        methods: {
            getConcerts: function() {
                axios.get('http://api.artistwave.com/api/get/page-concerts/91')
                .then((response) => {
                    console.log(response.data)
                    if(response.data) {
                        this.concerts = response.data
                    }

                }).catch(error => {
                    console.log(error)
                });
            },
        },
        watch: {

        }
    }
</script>
