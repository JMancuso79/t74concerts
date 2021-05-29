<template>
    <div>
       
        <div>
            <nav class="nav-bg shadow fixed w-full">
                <!-- Primary Navigation Menu -->
                <div class="max-width mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="flex-shrink-0 flex items-center">
                                <inertia-link href="/" class="lg-logo">
                                    <img class="header-logo" src="/images/tower-logo-black.jpg" />
                                </inertia-link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex text-white">
                                <jet-nav-link href="/">
                                    Concerts
                                </jet-nav-link>
                                <jet-nav-link href="/about">
                                    About
                                </jet-nav-link>
                                <jet-nav-link href="/booking">
                                    Booking
                                </jet-nav-link>
                                <jet-nav-link href="/contact">
                                    Contact
                                </jet-nav-link>
                            </div>
                        </div>


                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button @click="showingNavigationDropdown = ! showingNavigationDropdown" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-white focus:outline-none focus:white transition duration-150 ease-in-out">
                                <svg class="h-6 w-6 hamburger" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <jet-responsive-nav-link href="/">
                            Concerts
                        </jet-responsive-nav-link>
                        <jet-responsive-nav-link href="/about">
                            About
                        </jet-responsive-nav-link>
                        <jet-responsive-nav-link href="/booking">
                            Booking
                        </jet-responsive-nav-link>
                        <jet-responsive-nav-link href="/contact">
                            Contact
                        </jet-responsive-nav-link>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-white shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header"></slot>
                </div>
            </header>


        </div>
    </div>
</template>

<script>
    import JetApplicationMark from '@/Jetstream/ApplicationMark'
    import JetBanner from '@/Jetstream/Banner'
    import JetDropdown from '@/Jetstream/Dropdown'
    import JetDropdownLink from '@/Jetstream/DropdownLink'
    import JetNavLink from '@/Jetstream/NavLink'
    import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink'

    export default {
        components: {
            JetApplicationMark,
            JetBanner,
            JetDropdown,
            JetDropdownLink,
            JetNavLink,
            JetResponsiveNavLink,
        },

        data() {
            return {
                showingNavigationDropdown: false,
            }
        },

        methods: {
            switchToTeam(team) {
                this.$inertia.put(route('current-team.update'), {
                    'team_id': team.id
                }, {
                    preserveState: false
                })
            },

            logout() {
                this.$inertia.post(route('logout'));
            },
        }
    }
</script>
    <style>
      .header-logo {
        width:60px;
      }
    </style>