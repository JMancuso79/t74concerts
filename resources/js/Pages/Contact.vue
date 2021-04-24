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
            <div class="max-width mx-auto">
                <div class="dark:bg-gray-200 ml-4 mr-4 mb-4 md:m-0">
                    <div class="p-2">
                        <div>
                            <p class="font-bold mb-2">Contact </p>
                            <p v-if="errCode == 'success'" class="mb-4">
                                {{errMsg}}
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
                            <div v-if="isValidated === true">
                                <button @click="sendMessage()" class="buy-now-button w-full">Send</button>
                            </div>
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
