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
            <!-- Event -->
            <div v-for="concert in concerts" class="max-width mx-auto mb-4">

                <div class="md:hidden bg-black mb-4 ml-4 mr-4 p-2 text-white">
                    <img class="w-full" :src="concert.imageFull" :alt="concert.title">
                        <div class="p-4 w-full">
                            <div class="uppercase tracking-wide text-sm text-white font-semibold">
                                {{concert.title}}
                            </div>
                            <a :href="'/venue/'+concert.venue[0].slug" class="block mt-1 text-lg leading-tight font-medium text-gray-500 hover:underline">
                                {{concert.venue[0].name}}
                            </a>
                            <p class="mt-2 text-gray-500">{{concert.details}}</p>
                            <p class="mt-2 text-gray-500">
                                <a :href="'/tickets/'+concert.slug">Buy Tickets</a>
                            </p>
                        </div>
                </div>


                <div class="hidden md:flex bg-black p-2">
                    <div class="flex-none w-48">
                        <!-- This item will not grow -->
                        <div class="grid justify-items-center items-center">
                            <img class="w-full" :src="concert.image" :alt="concert.title">
                        </div>
                    </div>
                    <div class="flex-grow">
                         <div class="p-4 w-full">
                            <div class="uppercase tracking-wide text-sm text-white font-semibold">
                                {{concert.title}}
                            </div>
                            <a :href="'/venue/'+concert.venue[0].slug" class="block mt-1 text-lg leading-tight font-medium text-gray-500 hover:underline">
                                {{concert.venue[0].name}}
                            </a>
                            <p class="mt-2 text-gray-500">{{concert.details}}</p>
                            <p class="mt-2 text-gray-500">
                                <a :href="'/tickets/'+concert.slug">Buy Tickets</a>
                            </p>
                        </div>
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
        props: {
            canLogin: Boolean,
            canRegister: Boolean,
        },
        data() {
            return {
                // Concerts
                concerts: [
                    {
                        id: '1000',
                        date: '2021-05-21',
                        time: '7:00 pm',
                        title: 'Kyle Smith W/The B Foundation',
                        slug: 'kyle-smith-the-b-foundation',
                        venue: [
                            {
                                name: 'Tiki Bar',
                                slug: 'tiki-bar',
                                address: '1700 Placentia Ave', 
                                city: 'Costa Mesa',
                                state: 'CA',
                                zipCode: 92627,
                                website: 'https://tikibaroc.com/'
                            },
                        ],
                        artists: [
                            {
                                name: 'Kyle Smith',
                                url: 'https://artistwave.com',
                                image: '/images/tower-74-concert-1.jpg'
                            },
                            {
                                name: 'The B Foundation',
                                url: 'https://artistwave.com',
                                image: '/images/tower-74-concert-1.jpg',
                            }
                        ],
                        details: 'Kyle Smith, The B Foundation, Rebel Shakedown & Die Criminal. This is a 21+ show. Capacity will be determined by COVID guidelines on the day of the show.',
                        url: 'https://artistwave.com',
                        ticketLink: 'https://artistwave.com',
                        image: '/images/tower74-ks-bf.jpg',
                        imageFull: '/images/tower74-ks-bf-full.jpg',
                        ticket: 35
                    },
                    {
                        id: '1001',
                        date: '2021-06-05',
                        time: '7:00 pm',
                        title: 'Sammy Ramone',
                        slug: 'sammy-ramone',
                        venue: [
                            {
                                name: 'Tiki Bar',
                                slug: 'tiki-bar',
                                address: '1700 Placentia Ave', 
                                city: 'Costa Mesa',
                                state: 'CA',
                                zipCode: 92627,
                                website: 'https://tikibaroc.com/'
                            },
                        ],
                        artists: [
                            {
                                name: 'Sammy Ramone',
                                url: 'https://artistwave.com',
                                image: '/images/tower-74-concert-2.jpg'
                            },
                            {
                                name: 'Noble Savage',
                                url: 'https://artistwave.com',
                                image: '/images/tower-74-concert-2.jpg'
                            }
                        ],
                        details: 'Sammy Ramone, Velvateen, Noble Savage & Doahs Daydream. This is a 21+ show. Capacity will be determined by COVID guidelines on the day of the show.',
                        url: 'https://artistwave.com',
                        ticketLink: 'https://artistwave.com',
                        image: '/images/tower-74-sammy-ramone.jpg',
                        imageFull: '/images/tower-74-sammy-ramone-full.jpg',
                        ticket: 15
                    },
                ]
            }
        },
        mounted() {
            
        }
    }
</script>
