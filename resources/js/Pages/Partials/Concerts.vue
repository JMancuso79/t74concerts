<template>
    <div>
        <div v-for="concert in concerts" class="bg-gray-200 mb-4">
            <!-- Image
            <img v-if="concert.filename != null && concert.filename != ''" class="w-full" :src="concert.filename" :alt="concert.title">
             -->
            <!-- Date -->
            <div>
                {{concert.event.date_time}}
            </div>
            <!-- Title -->
            <div>
                Title: {{concert.title}}
            </div>
            <!-- Tickets -->
            <div v-if="concert.tickets">
                Tickets
                <div v-for="ticket in concert.tickets">
                    {{ticket.label}}: {{ticket.price}}
                </div>
            </div>
            <!-- Ticket Link -->
            <div v-if="concert.event.ticket_link">
                {{concert.event.ticket_link}}
            </div>
            <!-- Artists -->
            <div v-if="concert.artists">
                Artists
                <div v-for="artist in concert.artists">
                    {{artist.name}}
                    <div v-if="artist.image">
                        <!--<img :src="artist.image" />-->
                    </div>
                </div>
            </div>
            <!-- Details -->
            <div>
                Details: {{concert.body}}
            </div>
            <!-- Venue -->
            <div v-if="concert.event.venue">
                Venue 
                <div v-if="concert.event.venue.image">
                    <!--<img :src="concert.event.venue.image" />-->
                </div>
                <div>
                    {{concert.event.venue.name}}
                </div>
                <div>
                    {{concert.event.venue.street_address}}
                </div>
                <div>
                    {{concert.event.venue.city}}, {{concert.event.venue.state}} {{concert.event.venue.zip_code}}
                </div>
            </div>
            <!-- Genres -->
            <div v-if="concert.genres">
                <div v-for="genre in concert.genres">
                    {{genre.name}}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        components: {
        },
        data() {
            return {  
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
