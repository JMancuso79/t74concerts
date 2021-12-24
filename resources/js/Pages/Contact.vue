<template>
  <div class="min-h-full">

    <!-- 
      Top Nav Here
    -->
    <Header />

    <div class="py-10">
      <div class="max-w-3xl mx-auto sm:px-6 lg:max-w-7xl lg:px-8 lg:grid lg:grid-cols-12 lg:gap-8">
        <div class="hidden lg:block lg:col-span-3 xl:col-span-2">
          <!-- 
            Side Nav Here
          -->
          <nav aria-label="Sidebar" class="sticky top-4 divide-y divide-gray-300">
            <div class="pb-8 space-y-1">
              <a v-for="item in navigation" :key="item.name" :href="item.href" :class="[item.current ? 'bg-gray-200 text-gray-900' : 'text-gray-600 hover:bg-gray-50', 'group flex items-center px-3 py-2 text-sm font-medium rounded-md']" :aria-current="item.current ? 'page' : undefined">
                <component :is="item.icon" :class="[item.current ? 'text-gray-500' : 'text-gray-400 group-hover:text-gray-500', 'flex-shrink-0 -ml-1 mr-3 h-6 w-6']" aria-hidden="true" />
                <span class="truncate">
                  {{ item.name }}
                </span>
              </a>
            </div>
            <!--<div class="pt-10">
              <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider" id="communities-headline">
                Explore
              </p>
              <div class="mt-3 space-y-2" aria-labelledby="communities-headline">
                <a v-for="community in communities" :key="community.name" :href="community.href" class="group flex items-center px-3 py-2 text-sm font-medium text-gray-600 rounded-md hover:text-gray-900 hover:bg-gray-50">
                  <span class="truncate">
                    {{ community.name }}
                  </span>
                </a>
              </div>
            </div>-->
          </nav>
        </div>
        <main class="lg:col-span-9 xl:col-span-6">
          <div>
            <div class="artist-list">
                <div class="">

                    <div class="">
                        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                            <div class="mb-6">
                                <h2 id="create-artist-heading" class="text-base font-medium text-gray-900">
                                    Contact Tower74
                                </h2>

                                <!-- Event -->
                                <div class="max-width mx-auto mt-4">
                                    <div>
                                        <div>
                                            <div>

                                                <p v-if="errCode == 'success'" class="mb-4">
                                                  <div class="rounded-md bg-green-50 p-4">
                                                    <div class="flex">
                                                      <div class="flex-shrink-0">
                                                        <CheckCircleIcon class="h-5 w-5 text-green-400" aria-hidden="true" />
                                                      </div>
                                                      <div class="ml-3">
                                                        <h3 class="text-sm font-medium text-green-800">
                                                          Success!
                                                        </h3>
                                                        <div class="mt-2 text-sm text-green-700">
                                                          <p>
                                                            {{errMsg}}
                                                          </p>
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </p>
                                                <p v-if="errCode == 'fail'" class="mb-4">
                                                    {{errMsg}}
                                                </p>
                                                <p v-if="errCode == 'fail-validation'" class="mb-4">
                                                    {{errMsg}}
                                                </p>
                                                <!-- Name -->
                                                <div class="w-full pb-2">
                                                    <label>Name*</label>
                                                    <input type="text" class="form-input w-full" v-model="name" placeholder="Enter your name">
                                                </div>
                                                <!-- Email -->
                                                <div class="w-full pb-2">
                                                    <label>Email*</label>
                                                    <input type="email" class="form-input w-full" v-model="email" placeholder="Enter your email">
                                                </div>
                                                <!-- Phone -->
                                                <div class="w-full pb-2">
                                                    <label>Phone</label>
                                                    <input type="text" class="form-input w-full" v-model="phone" placeholder="Enter your phone">
                                                </div>
                                                <!-- Message -->
                                                <div class="w-full pb-2">
                                                    <label>Message*</label>
                                                    <textarea class="form-input w-full" v-model="message" placeholder="Enter your message"></textarea>
                                                </div> 
                                                <!-- Can Submit -->
                                                <div v-if="isValidated === true" class="pb-4">
                                                    <button @click="sendMessage()" class="bg-primary text-white w-full p-2">Send</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
          </div>
        </main>
        <aside class="hidden xl:block xl:col-span-4">
          <div class="sticky top-4 space-y-4">
            <!-- 
              Right Col Here
            -->
            <RightCol />
          </div>
        </aside>
      </div>
    </div>
  </div>

</template>

<script>
    import Header from '@/Pages/Partials/Header'
    import RightCol from '@/Pages/Partials/RightCol'
    import { parseISO, format } from 'date-fns'
    import { TicketIcon, HomeIcon, MailIcon, CalendarIcon } from '@heroicons/vue/outline'
    import { CheckCircleIcon } from '@heroicons/vue/solid'
    const navigation = [
      { name: 'Home', href: '/', icon: HomeIcon, current: false },
      { name: 'Concerts', href: '/', icon: TicketIcon, current: false },
      { name: 'Booking', href: '/booking', icon: CalendarIcon, current: false },
      { name: 'Contact', href: '/contact', icon: MailIcon, current: true },
    ]

    const communities = []
    export default {
        components: {
            Header, 
            TicketIcon, 
            HomeIcon, 
            MailIcon,
            CalendarIcon,
            RightCol,
            CheckCircleIcon
        },
        data() {
            return {  
                name: null,
                email: null,
                phone: null,
                message: null,
                isLoading: false,
                isValidated: false,
                errCode: null,
                errMsg: null,
            }
        },
        mounted() {

        },
        setup() {
          return {
            navigation
          }
        },
        methods: {
            sendMessage: function() {
                this.isLoading = true
                axios.post('/api/send-message', {
                    name: this.name,
                    email: this.email,
                    phone: this.phone,
                    message: this.message
                }).then((response) => {
                    // Success
                    if(response.data.message == 'success') {
                        this.errCode = 'success'
                        this.errMsg = 'Your message has been sent and we will be in touch.'
                        this.resetForm()
                    }
                    // Something went wrong
                    if(response.data.message == 'fail' ) {
                        this.errCode = 'fail'
                        this.errMsg = 'Something went wrong!'
                    }
                    // Something went wrong
                    if(response.data.message == 'fail-validation' ) {
                        this.errCode = 'fail-validation'
                        this.errMsg = 'Please make sure your email address is a valid email.'
                    }
                    this.isLoading = false  
                }).catch(error => {
                    // Something went wrong
                    this.errCode = 'fail'
                    this.errMsg = 'Something went wrong!'
                    this.isLoading = false 
                });
            },
            validateForm: function() {
                if(this.name != null && this.name != '') {
                    if(this.email != null && this.email != '') {
                        if(this.message != null && this.message != '') {
                            this.isValidated = true
                        } else {
                            this.isValidated = false
                        }
                    } else {
                        this.isValidated = false
                    }
                } else {
                    this.isValidated = false
                 }
            },
            resetForm: function() {
                this.name = null
                this.email = null
                this.phone = null
                this.message = null
                this.isValidated = false
            }
        },
        watch: {
            email: function() {
                this.validateForm()
            },
            message: function() {
                this.validateForm()
            },
            name: function() {
                this.validateForm()
            },
            phone: function() {
                this.validateForm()
            }
        }
    }
</script>

