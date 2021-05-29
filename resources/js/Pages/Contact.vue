<template>
    <div class="feat-bg bottom-spacer">
        <!-- 
            Header
        -->
        <Header />
        <!-- 
            Content 
        -->
        <div class="top-spacer mb-4">
            <!-- Event -->
            <div class="max-width mx-auto pt-4">
                <div class="bg-black ml-4 mr-4 mb-4 md:m-0">
                    <div class="pl-4 pr-4">
                        <div>
                            <div class="uppercase text-title pt-4">
                                Contact Tower74
                            </div>
                            <p v-if="errCode == 'success'" class="mb-4 text-white">
                                {{errMsg}}
                            </p>
                            <p v-if="errCode == 'fail'" class="mb-4 text-white">
                                {{errMsg}}
                            </p>
                            <p v-if="errCode == 'fail-validation'" class="mb-4 text-white">
                                {{errMsg}}
                            </p>
                            <!-- Name -->
                            <div class="w-full pb-2">
                                <label class="text-white">Name*</label>
                                <input type="text" class="form-input w-full" v-model="name" placeholder="Enter your name">
                            </div>
                            <!-- Email -->
                            <div class="w-full pb-2">
                                <label class="text-white">Email*</label>
                                <input type="email" class="form-input w-full" v-model="email" placeholder="Enter your email">
                            </div>
                            <!-- Phone -->
                            <div class="w-full pb-2">
                                <label class="text-white">Phone</label>
                                <input type="text" class="form-input w-full" v-model="phone" placeholder="Enter your phone">
                            </div>
                            <!-- Message -->
                            <div class="w-full pb-2">
                                <label class="text-white">Message*</label>
                                <textarea class="form-input w-full" v-model="message" placeholder="Enter your message"></textarea>
                            </div> 
                            <!-- Can Submit -->
                            <div v-if="isValidated === true" class="pb-4">
                                <button @click="sendMessage()" class="buy-now-button w-full">Send</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>

        <Footer page="contact" />
    </div>
</template>

<script>
    import Header from '@/Pages/Partials/Header'
    import Footer from '@/Pages/Partials/Footer'

    export default {
        components: {
            Header, Footer
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
