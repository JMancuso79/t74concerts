<template>
  <div class="min-h-full">

    <!-- 
      Top Nav Here
    -->
    <Header />

    <div class="py-10">
      <div class="max-w-3xl mx-auto sm:px-6 lg:max-w-7xl lg:px-8 lg:grid lg:grid-cols-12 lg:gap-8">
        
          <!-- 
            Side Nav Here
          -->

        <main class="col-span-12 lg:col-span-8">
          <div>
            <div class="artist-list">
                <div class="">

                    <div class="">

                        <div v-if="isLoading === false">
                            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10 mb-4">
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
                        <div v-else>
                            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10 mb-4">
                                <div>
                                    <h2 id="create-artist-heading" class="text-base font-medium text-gray-900">
                                        Sending...
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </main>
        <aside class="col-span-12 lg:col-span-4">
          <div class="sticky top-4 space-y-4">
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

