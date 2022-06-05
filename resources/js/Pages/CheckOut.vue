<template>
  <div id="page-top" class="bg-gray-50">
    <Header />

    <div v-if="isLoading === false" class="max-w-2xl mx-auto pt-16 pb-24 px-4 sm:px-6 lg:max-w-7xl lg:px-8">
      <h2 class="sr-only">Checkout</h2>

      <!-- Errors -->
      <div v-if="errors && errors.length" class="rounded-md bg-red-50 p-4 mb-4">
        <div class="flex">
          <div class="flex-shrink-0">
            <XCircleIcon class="h-5 w-5 text-red-400" aria-hidden="true" />
          </div>
          <div class="ml-3">
            <h3 v-if="errors.length != 1" class="text-sm font-medium text-red-800">There were {{errors.length}} errors in your submission</h3>
            <h3 v-else class="text-sm font-medium text-red-800">There was 1 error in your submission</h3>
            <div class="mt-2 text-sm text-red-700">
              <ul role="list" class="list-disc pl-5 space-y-1">
                <li v-for="error in errors" :key="error">{{error}}</li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <form class="lg:grid lg:grid-cols-2 lg:gap-x-12 xl:gap-x-16">
        <div>
          <div>
            <h2 class="text-lg font-medium text-gray-900">Contact information</h2>

            <div class="mt-4">
              <label for="email-address" class="block text-sm font-medium text-gray-700">Email address</label>
              <div class="mt-1">
                <input v-model="email" type="email" id="email-address" name="email-address" autocomplete="email" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
              </div>
            </div>
            <div class="mt-4">
              <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
              <div class="mt-1">
                <input v-model="phone" type="text" name="phone" id="phone" autocomplete="tel" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
              </div>
            </div>
          </div>

          <div class="mt-10 border-t border-gray-200 pt-10">
            <h2 class="text-lg font-medium text-gray-900">Shipping information</h2>

            <div class="mt-4 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
              <div>
                <label for="first-name" class="block text-sm font-medium text-gray-700">First name</label>
                <div class="mt-1">
                  <input v-model="fName" type="text" id="first-name" name="first-name" autocomplete="given-name" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                </div>
              </div>

              <div>
                <label for="last-name" class="block text-sm font-medium text-gray-700">Last name</label>
                <div class="mt-1">
                  <input v-model="lName" type="text" id="last-name" name="last-name" autocomplete="family-name" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                </div>
              </div>

              <div class="sm:col-span-2">
                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                <div class="mt-1">
                  <input v-model="streetAddress" type="text" name="address" id="address" autocomplete="street-address" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                </div>
              </div>

              <div class="sm:col-span-2">
                <label for="apartment" class="block text-sm font-medium text-gray-700">Apartment, suite, etc.</label>
                <div class="mt-1">
                  <input v-model="unit" type="text" name="apartment" id="apartment" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                </div>
              </div>

              <div>
                <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                <div class="mt-1">
                  <input v-model="city" type="text" name="city" id="city" autocomplete="address-level2" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                </div>
              </div>

              <div>
                <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
                <div class="mt-1">
                  <select v-model="country" id="country" name="country" autocomplete="country-name" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="US">United States</option>
                    <!--<option>Canada</option>
                    <option>Mexico</option>-->
                  </select>
                </div>
              </div>

              <div>
                <label for="region" class="block text-sm font-medium text-gray-700">State</label>
                <div class="mt-1">
                  <input v-model="state" type="text" name="region" id="region" autocomplete="address-level1" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                </div>
              </div>

              <div>
                <label for="postal-code" class="block text-sm font-medium text-gray-700">Postal code</label>
                <div class="mt-1">
                  <input v-model="zip" type="text" name="postal-code" id="postal-code" autocomplete="postal-code" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                </div>
              </div>

            </div>
          </div>

          <div class="mt-10 border-t border-gray-200 pt-10">
            <RadioGroup v-model="selectedDeliveryMethod">
              <RadioGroupLabel class="text-lg font-medium text-gray-900"> Delivery method </RadioGroupLabel>

              <div class="mt-4 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                <RadioGroupOption as="template" v-for="deliveryMethod in deliveryMethods" :key="deliveryMethod.id" :value="deliveryMethod" v-slot="{ checked, active }">
                  <div :class="[checked ? 'border-transparent' : 'border-gray-300', active ? 'ring-2 ring-indigo-500' : '', 'relative bg-white border rounded-lg shadow-sm p-4 flex cursor-pointer focus:outline-none']">
                    <span class="flex-1 flex">
                      <span class="flex flex-col">
                        <RadioGroupLabel as="span" class="block text-sm font-medium text-gray-900">
                          {{ deliveryMethod.title }}
                        </RadioGroupLabel>
                        <RadioGroupDescription as="span" class="mt-1 flex items-center text-sm text-gray-500">
                          {{ deliveryMethod.turnaround }}
                        </RadioGroupDescription>
                        <RadioGroupDescription as="span" class="mt-6 text-sm font-medium text-gray-900">
                          {{ deliveryMethod.price }}
                        </RadioGroupDescription>
                      </span>
                    </span>
                    <CheckCircleIcon v-if="checked" class="h-5 w-5 text-indigo-600" aria-hidden="true" />
                    <span :class="[active ? 'border' : 'border-2', checked ? 'border-indigo-500' : 'border-transparent', 'absolute -inset-px rounded-lg pointer-events-none']" aria-hidden="true" />
                  </div>
                </RadioGroupOption>
              </div>
            </RadioGroup>
          </div>

          <!-- Payment -->
          <div class="mt-10 border-t border-gray-200 pt-10">
            <h2 class="text-lg font-medium text-gray-900">Payment</h2>

            <!--<fieldset class="mt-4">
              <legend class="sr-only">Payment type</legend>
              <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                <div v-for="(paymentMethod, paymentMethodIdx) in paymentMethods" :key="paymentMethod.id" class="flex items-center">
                  <input v-if="paymentMethodIdx === 0" :id="paymentMethod.id" name="payment-type" type="radio" checked="" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" />
                  <input v-else :id="paymentMethod.id" name="payment-type" type="radio" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" />
                  <label :for="paymentMethod.id" class="ml-3 block text-sm font-medium text-gray-700">
                    {{ paymentMethod.title }}
                  </label>
                </div>
              </div>
            </fieldset>-->

            <div class="mt-6 grid grid-cols-4 gap-y-6 gap-x-4">
              <div class="col-span-4">
                <label for="card-number" class="block text-sm font-medium text-gray-700">Card number</label>
                <div class="mt-1">
                  <input v-model="cardNumber" type="text" id="card-number" name="card-number" autocomplete="cc-number" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                </div>
              </div>

              <div class="col-span-4">
                <label for="name-on-card" class="block text-sm font-medium text-gray-700">Name on card</label>
                <div class="mt-1">
                  <input v-model="nameOnCard" type="text" id="name-on-card" name="name-on-card" autocomplete="cc-name" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                </div>
              </div>

              <div class="col-span-3">
                <label for="expiration-date" class="block text-sm font-medium text-gray-700">Expiration date (MM/YY)</label>
                <div class="mt-1">
                  <input v-model="expiration" type="text" name="expiration-date" id="expiration-date" autocomplete="cc-exp" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                </div>
              </div>

              <div>
                <label for="cvc" class="block text-sm font-medium text-gray-700">CVC</label>
                <div class="mt-1">
                  <input v-model="cvc" type="text" name="cvc" id="cvc" autocomplete="csc" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Order summary -->
        <div class="mt-10 lg:mt-0">
          <h2 class="text-lg font-medium text-gray-900">Order summary</h2>

          <div v-if="products && products.length" class="mt-4 bg-white border border-gray-200 rounded-lg shadow-sm">
            <h3 class="sr-only">Items in your cart</h3>
            <ul role="list" class="divide-y divide-gray-200">
              <li v-for="(product, productIdx) in products" :key="product.id" class="flex py-6 px-4 sm:px-6">
                <div class="flex-shrink-0">
                  <img :src="product.imageSrc" :alt="product.imageAlt" class="w-20 rounded-md" />
                </div>

                <div class="ml-6 flex-1 flex flex-col">
                  <div class="flex">
                    <div class="min-w-0 flex-1">
                      <h4 class="text-sm">
                        <a :href="product.href" class="font-medium text-gray-700 hover:text-gray-800">
                          {{ product.name }}
                        </a>
                      </h4>
                      <p class="mt-1 text-sm text-gray-500 capitalize">
                        {{ product.color }}
                      </p>
                      <p class="mt-1 text-sm text-gray-500 capitalize">
                        {{ product.size }}
                      </p>
                    </div>

                    <div class="ml-4 flex-shrink-0 flow-root">
                      <button @click.prevent="removeFromCart(product, productIdx)" type="button" class="-m-2.5 bg-white p-2.5 flex items-center justify-center text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Remove</span>
                        <TrashIcon class="h-5 w-5" aria-hidden="true" />
                      </button>
                    </div>
                  </div>

                  <div class="flex-1 pt-2 flex items-end justify-between">
                    <p class="mt-1 text-sm font-medium text-gray-900">{{ product.price }}</p>

                    <div class="ml-4">
                      <label for="quantity" class="sr-only">Quantity</label>
                      <select v-model="product.quantity" id="quantity" name="quantity" class="rounded-md border border-gray-300 text-base font-medium text-gray-700 text-left shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                      </select>
                    </div>
                  </div>
                </div>
              </li>
            </ul>

            <dl class="border-t border-gray-200 py-6 px-4 space-y-6 sm:px-6">
              <div class="flex items-center justify-between">
                <dt class="text-sm">Subtotal</dt>
                <dd class="text-sm font-medium text-gray-900">${{subTotal}}.00</dd>
              </div>
              <div class="flex items-center justify-between">
                <dt class="text-sm">Shipping</dt>
                <dd class="text-sm font-medium text-gray-900">${{shipping}}.00</dd>
              </div>
              <div class="flex items-center justify-between">
                <dt class="text-sm">Taxes</dt>
                <dd class="text-sm font-medium text-gray-900">${{taxes}}</dd>
              </div>
              <div class="flex items-center justify-between border-t border-gray-200 pt-6">
                <dt class="text-base font-medium">Total</dt>
                <dd class="text-base font-medium text-gray-900">${{total}}</dd>
              </div>
            </dl>

            <div class="border-t border-gray-200 py-6 px-4 sm:px-6">
              <button @click.prevent="submitted = true" type="submit" class="w-full bg-indigo-600 border border-transparent rounded-md shadow-sm py-3 px-4 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50 focus:ring-indigo-500">Confirm order</button>
            </div>
          </div>
          <!-- No products in cart -->
          <div v-else class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
            <div class="flex">
              <div class="flex-shrink-0">
              </div>
              <div class="ml-3">
                <p class="text-sm text-yellow-700">
                  Your cart is empty!
                  {{ ' ' }}
                  <a href="/product/4" class="font-medium underline text-yellow-700 hover:text-yellow-600"> Click here to visit the shop </a>
                </p>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
    <!-- Loading -->
    <div v-else class="max-w-2xl mx-auto pt-24 pb-24 px-4 sm:px-6 lg:max-w-7xl lg:px-8 text-center">
      <button disabled type="button" class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="animate-spin h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
            </svg>
            Processing...
      </button>



        
    
    </div>
    <!-- Footer -->
    <footer aria-labelledby="footer-heading">
        <div class="border-t border-gray-100 py-10 text-center">
          <p class="text-sm text-gray-500">&copy; 2022 Tower 74 LLC. All rights reserved.</p>
        </div>
    </footer>
  </div>
</template>

<script>


import { ref, onMounted } from 'vue'
import { RadioGroup, RadioGroupDescription, RadioGroupLabel, RadioGroupOption } from '@headlessui/vue'
import { CheckCircleIcon, TrashIcon, XCircleIcon } from '@heroicons/vue/solid'
import Header from '@/Pages/Partials/Header'

export default {
  components: {
    Header,CheckCircleIcon, TrashIcon,RadioGroup, RadioGroupDescription, RadioGroupLabel, RadioGroupOption, XCircleIcon

  },
  props: ['cartItems'],
  setup(props) {
    const subTotal = ref(0)
    const discount = { code: 'CHEAPSKATE', amount: '$24.00' }
    const taxes = ref(0)
    const shipping = ref(0)
    const total = ref(0)
    const products = ref([])
    
    const email = ref(null)
    const phone = ref(null)
    const fName = ref(null)
    const lName = ref(null)
    const streetAddress = ref(null)
    const unit = ref(null)
    const city = ref(null)
    const state = ref(null)
    const country = ref('US')
    const zip = ref(null)

    const deliveryMethod = ref('standard')

    const cardNumber = ref(null)
    const nameOnCard = ref(null)
    const expiration = ref(null)
    const cvc = ref(null)

    const isLoading = ref(false)

    const errors = ref([])

    const submitted = ref(false)

    const deliveryMethods = [
      { id: 1, title: 'Standard', turnaround: '4–10 business days', price: '$5.00' },
      //{ id: 2, title: 'Express', turnaround: '2–5 business days', price: '$16.00' },
    ]
    const paymentMethods = [
      { id: 'credit-card', title: 'Credit card' },
      { id: 'paypal', title: 'PayPal' },
      { id: 'etransfer', title: 'eTransfer' },
    ]

    const selectedDeliveryMethod = ref(deliveryMethods[0])

    onMounted(() => {
      doCartItems()
    })

    function doCartItems() {
      if(props.cartItems && props.cartItems.length) {
        //subTotal.value = 0
        for(var i=0;i<props.cartItems.length;i++) {
          products.value.push({
            id: props.cartItems[i].id,
            name: props.cartItems[i].name,
            href: '/product/'+props.cartItems[i].id,
            price: props.cartItems[i].price,
            color: props.cartItems[i].color,
            inStock: props.cartItems[i].inStock,
            size: props.cartItems[i].size,
            imageSrc: props.cartItems[i].image,
            imageAlt: props.cartItems[i].name,
            quantity: props.cartItems[i].quantity,
            category: props.cartItems[i].category
          })
          // Calculations
          /*if(props.cartItems[i].quantity && props.cartItems[i].quantity > 0) {
            calculateSubTotal(props.cartItems[i].quantity, props.cartItems[i].price.replace('$', ''))
            doShipping()
            calculateTaxes()
            calculateTotal()
          } */
        }
      } else {
        //resetTotal()
      }
    }

    function removeFromCart(p, index) {
      axios.post('/web-api/v1/remove-item-from-cart', {
        id: p.id,
        size: p.size,
        color: p.color
      }).then((response) => {
        products.value.splice(index, 1)
      })
    }

    function updateCart(c) {
      axios.post('/web-api/v1/update-cart', {
        products: c,
        subTotal: subTotal.value,
        shipping: shipping.value,
        taxes: taxes.value,
        total: total.value
      }).then((response) => {
        console.log(response)
      })
    }

    function calculateTotal() {
      let t = subTotal.value + shipping.value + parseFloat(taxes.value)
      total.value = t.toFixed(2)
    }

    function calculateSubTotal(q, p) {
      subTotal.value += parseInt(q) * parseInt(p)
    }

    function doShipping() {
      if(subTotal.value > 0) {
        shipping.value = 5
      }
    }

    function calculateTaxes() {
      let tempTotal = subTotal.value + shipping.value
      if(tempTotal && tempTotal > 0) {
        let tax = parseFloat(7.25) / 100 * tempTotal
        taxes.value = tax.toFixed(2)
      }
    }

    function resetTotal() {
      subTotal.value = 0
      shipping.value = 0
      taxes.value = 0
      total.value = 0
      errors.value = []
    }

    function validateForm() {
      let isValidated = true
      // Email
      if(email.value == null || email.value == '') {
        errors.value.push(['A valid email is required'])
        isValidated = false
      }
      // First Name
      if(fName.value == null || fName.value == '') {
        errors.value.push(['First name is required'])
        isValidated = false
      }
      // Last Name
      if(lName.value == null || lName.value == '') {
        errors.value.push(['Last name is required'])
        isValidated = false
      }
      // Street Address
      if(streetAddress.value == null || streetAddress.value == '') {
        errors.value.push(['Street address is required'])
        isValidated = false
      }
      // City
      if(city.value == null || city.value == '') {
        errors.value.push(['City is required'])
        isValidated = false
      }
      // State
      if(state.value == null || state.value == '') {
        errors.value.push(['State is required'])
        isValidated = false
      }
      // Country
      if(country.value == null || country.value == '') {
        errors.value.push(['Country is required'])
        isValidated = false
      }
      // Zip
      if(zip.value == null || zip.value == '') {
        errors.value.push(['Postal Code is required'])
        isValidated = false
      }
      // Delivery Method
      if(deliveryMethod.value == null || deliveryMethod.value == '') {
        errors.value.push(['Delivery Method is required'])
        isValidated = false
      }
      // Card Number
      if(cardNumber.value == null || cardNumber.value == '') {
        errors.value.push(['Card number is required'])
        isValidated = false
      }
      // Name on card
      if(nameOnCard.value == null || nameOnCard.value == '') {
        errors.value.push(['Name on card is required'])
        isValidated = false
      }
      // Expiration
      if(expiration.value == null || expiration.value == '') {
        errors.value.push(['Expiration is required'])
        isValidated = false
      }
      // CVC
      if(cvc.value == null || cvc.value == '') {
        errors.value.push(['The security code is required'])
        isValidated = false
      }

      submitted.value = false

      return isValidated
    }

    function submit() {
      isLoading.value = true
      axios.post('/web-api/v1/product-payment', {
        products: products.value,
        total: total.value,
        discount: discount.value,
        promo_code: null,
        email: email.value,
        phone: phone.value,
        first_name: fName.value,
        last_name: lName.value,
        street_address: streetAddress.value,
        unit: unit.value,
        city: city.value,
        state: state.value,
        zip: zip.value,
        country: country.value,
        delivery_method: deliveryMethod.value,
        card_number: cardNumber.value,
        name_on_card: nameOnCard.value,
        //exp_month: expMonth.value,
        //exp_year: expYear.value,
        cvc: cvc.value
      }).then((response) => {
        if(response.data.message == 'success') {
          window.location = '/thank-you'
        } else {
          errors.value = response.data.errors
          const element = document.getElementById('page-top');
          element.scrollIntoView();
        }
      }).catch(error => {
        console.log(error)
      })
      isLoading.value = false
    }

    return {
      products,
      deliveryMethods,
      selectedDeliveryMethod,
      total,
      shipping,
      taxes,
      discount,
      subTotal,
      paymentMethods,
      removeFromCart,
      updateCart,
      calculateSubTotal,
      doShipping,
      resetTotal,
      calculateTaxes,
      calculateTotal,
      email, 
      phone,
      fName,
      lName,
      streetAddress,
      unit, 
      city,
      state,
      zip,
      country,
      deliveryMethod,
      cardNumber,
      nameOnCard,
      expiration,
      cvc,
      submitted,
      submit,
      errors,
      validateForm,
      isLoading
    }
  },
  watch: {
    products: {
      handler() {
        let cart = []
        if(this.products && this.products.length) {
          this.subTotal = 0
          for(var i=0;i<this.products.length;i++) {
            cart.push({
              id: this.products[i].id,
              name:  this.products[i].name,
              price:  this.products[i].price,
              category:  this.products[i].category,
              size:  this.products[i].size,
              color:  this.products[i].color,
              image:  this.products[i].imageSrc,
              inStock: true,
              quantity:  this.products[i].quantity
            })
            // Calculations
            if(this.products[i].quantity && this.products[i].quantity > 0) {
              this.calculateSubTotal(this.products[i].quantity, this.products[i].price.replace('$', ''))
              this.doShipping()
              this.calculateTaxes()
              this.calculateTotal()
            } 
          } 
        } else {
          this.resetTotal()
        }
        this.updateCart(cart)
      },
      deep:true
    },
    submitted: function() {
      if(this.submitted === true) {
        this.errors = []
        if(this.validateForm() === true) {
          this.submit()
        } else {
          const el = document.getElementById('page-top');
          el.scrollIntoView();
        }
      }
    }
  }
}





</script>

<style>
animate-spin {
 animation: spin 1s linear infinite; 
}  

@keyframes spin {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(360deg);
  }
}
</style>