<template>
  <div class="bg-white">
    <Header />

    <main class="max-w-2xl mx-auto pt-16 pb-24 px-4 sm:px-6 lg:max-w-7xl lg:px-8">
      <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">Shopping Cart</h1>

      <form class="mt-12 lg:grid lg:grid-cols-12 lg:gap-x-12 lg:items-start xl:gap-x-16">
        <section aria-labelledby="cart-heading" class="lg:col-span-7">
          <h2 id="cart-heading" class="sr-only">Items in your shopping cart</h2>

          <ul v-if="products && products.length" role="list" class="border-t border-b border-gray-200 divide-y divide-gray-200">
            <li v-for="(product, productIdx) in products" :key="product.id" class="flex py-6 sm:py-10">
              <div class="flex-shrink-0">
                <img :src="product.imageSrc" :alt="product.imageAlt" class="w-24 h-24 rounded-md object-center object-cover sm:w-48 sm:h-48" />
              </div>

              <div class="ml-4 flex-1 flex flex-col justify-between sm:ml-6">
                <div class="relative pr-9 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:pr-0">
                  <div>
                    <div class="flex justify-between">
                      <h3 class="text-sm">
                        <a :href="product.href" class="font-medium text-gray-700 hover:text-gray-800">
                          {{ product.name }}
                        </a>
                      </h3>
                    </div>
                    <div class="mt-1 flex text-sm">
                      <p class="text-gray-500">
                        {{ product.color }}
                      </p>
                      <p v-if="product.size" class="ml-4 pl-4 border-l border-gray-200 text-gray-500 capitalize">
                        {{ product.size }}
                      </p>
                    </div>
                    <p class="mt-1 text-sm font-medium text-gray-900">{{ product.price }}</p>
                  </div>

                  <div class="mt-4 sm:mt-0 sm:pr-9">
                    <label :for="`quantity-${productIdx}`" class="sr-only">Quantity, {{ product.name }}</label>
                    <select v-model="product.quantity" :id="`quantity-${productIdx}`" :name="`quantity-${productIdx}`" class="max-w-full rounded-md border border-gray-300 py-1.5 text-base leading-5 font-medium text-gray-700 text-left shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                      <option :value="1">1</option>
                      <option :value="2">2</option>
                      <option :value="3">3</option>
                      <option :value="4">4</option>
                      <option :value="5">5</option>
                      <option :value="6">6</option>
                      <option :value="7">7</option>
                      <option :value="8">8</option>
                    </select>

                    <div class="absolute top-0 right-0">
                      <button @click.prevent="removeFromCart(product, productIdx)" type="button" class="-m-2 p-2 inline-flex text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Remove</span>
                        <XIconSolid class="h-5 w-5" aria-hidden="true" />
                      </button>
                    </div>
                  </div>
                </div>

                <p class="mt-4 flex text-sm text-gray-700 space-x-2">
                  <CheckIcon v-if="product.inStock" class="flex-shrink-0 h-5 w-5 text-green-500" aria-hidden="true" />
                  <ClockIcon v-else class="flex-shrink-0 h-5 w-5 text-gray-300" aria-hidden="true" />
                  <span>{{ product.inStock ? 'In stock' : `Ships in ${product.leadTime}` }}</span>
                </p>
              </div>
            </li>
          </ul>
          <!-- Cart is empty -->
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
        </section>

        <!-- Order summary -->
        <section aria-labelledby="summary-heading" class="mt-16 bg-gray-50 rounded-lg px-4 py-6 sm:p-6 lg:p-8 lg:mt-0 lg:col-span-5">
          <h2 id="summary-heading" class="text-lg font-medium text-gray-900">Order summary</h2>

          <dl class="mt-6 space-y-4">
            <div class="flex items-center justify-between">
              <dt class="text-sm text-gray-600">Subtotal</dt>
              <dd class="text-sm font-medium text-gray-900">${{subTotal}}.00</dd>
            </div>
            <div class="border-t border-gray-200 pt-4 flex items-center justify-between">
              <dt class="flex items-center text-sm text-gray-600">
                <span>Shipping estimate</span>
                <a href="#" class="ml-2 flex-shrink-0 text-gray-400 hover:text-gray-500">
                  <span class="sr-only">Learn more about how shipping is calculated</span>
                  <QuestionMarkCircleIcon class="h-5 w-5" aria-hidden="true" />
                </a>
              </dt>
              <dd class="text-sm font-medium text-gray-900">${{shipping}}.00</dd>
            </div>
            <div class="border-t border-gray-200 pt-4 flex items-center justify-between">
              <dt class="flex text-sm text-gray-600">
                <span>Tax estimate</span>
                <a href="#" class="ml-2 flex-shrink-0 text-gray-400 hover:text-gray-500">
                  <span class="sr-only">Learn more about how tax is calculated</span>
                  <QuestionMarkCircleIcon class="h-5 w-5" aria-hidden="true" />
                </a>
              </dt>
              <dd class="text-sm font-medium text-gray-900">${{taxes}}</dd>
            </div>
            <div class="border-t border-gray-200 pt-4 flex items-center justify-between">
              <dt class="text-base font-medium text-gray-900">Order total</dt>
              <dd class="text-base font-medium text-gray-900">${{total}}</dd>
            </div>
          </dl>

          <div class="mt-6">
            <button type="submit" @click.prevent="checkOut()" class="w-full bg-indigo-600 border border-transparent rounded-md shadow-sm py-3 px-4 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50 focus:ring-indigo-500">Checkout</button>
          </div>
        </section>
      </form>

      <!-- Related products
      <section aria-labelledby="related-heading" class="mt-24">
        <h2 id="related-heading" class="text-lg font-medium text-gray-900">You may also like&hellip;</h2>

        <div class="mt-6 grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
          <div v-for="relatedProduct in relatedProducts" :key="relatedProduct.id" class="group relative">
            <div class="w-full min-h-80 aspect-w-1 aspect-h-1 rounded-md overflow-hidden group-hover:opacity-75 lg:h-80 lg:aspect-none">
              <img :src="relatedProduct.imageSrc" :alt="relatedProduct.imageAlt" class="w-full h-full object-center object-cover lg:w-full lg:h-full" />
            </div>
            <div class="mt-4 flex justify-between">
              <div>
                <h3 class="text-sm text-gray-700">
                  <a :href="relatedProduct.href">
                    <span aria-hidden="true" class="absolute inset-0" />
                    {{ relatedProduct.name }}
                  </a>
                </h3>
                <p class="mt-1 text-sm text-gray-500">{{ relatedProduct.color }}</p>
              </div>
              <p class="text-sm font-medium text-gray-900">{{ relatedProduct.price }}</p>
            </div>
          </div>
        </div>
      </section> -->
    </main>

    <footer aria-labelledby="footer-heading">
        <div class="border-t border-gray-100 py-10 text-center">
          <p class="text-sm text-gray-500">&copy; 2022 Tower 74 LLC. All rights reserved.</p>
        </div>
    </footer>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue'
import Header from '@/Pages/Partials/Header'
import {
  Dialog,
  DialogPanel,
  Popover,
  PopoverButton,
  PopoverGroup,
  PopoverPanel,
  Tab,
  TabGroup,
  TabList,
  TabPanel,
  TabPanels,
  TransitionChild,
  TransitionRoot,
} from '@headlessui/vue'
import { MenuIcon, SearchIcon, ShoppingBagIcon, XIcon as XIconOutline } from '@heroicons/vue/outline'
import { CheckIcon, ClockIcon, QuestionMarkCircleIcon, XIcon as XIconSolid } from '@heroicons/vue/solid'

const relatedProducts = [
  {
    id: 1,
    name: 'Billfold Wallet',
    href: '#',
    imageSrc: 'https://tailwindui.com/img/ecommerce-images/shopping-cart-page-01-related-product-01.jpg',
    imageAlt: 'Front of Billfold Wallet in natural leather.',
    price: '$118',
    color: 'Natural',
  },
  // More products...
]


export default {
  components: {
    Header,
    Dialog,
    DialogPanel,
    Popover,
    PopoverButton,
    PopoverGroup,
    PopoverPanel,
    Tab,
    TabGroup,
    TabList,
    TabPanel,
    TabPanels,
    TransitionChild,
    TransitionRoot,
    MenuIcon, SearchIcon, ShoppingBagIcon, XIconOutline,
    CheckIcon, ClockIcon, QuestionMarkCircleIcon, XIconSolid
  },
  props: ['cartItems'],
  setup(props) {
    const open = ref(false)
    const products = ref([])
    const subTotal = ref(0)
    const total = ref(0)
    const shipping = ref(0)
    const taxes = ref(0)

    onMounted(() => {
      doCartItems()
    })

    function doCartItems() {
      if(props.cartItems && props.cartItems.length) {
        subTotal.value = 0
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
          if(props.cartItems[i].quantity && props.cartItems[i].quantity > 0) {
            calculateSubTotal(props.cartItems[i].quantity, props.cartItems[i].price.replace('$', ''))
            doShipping()
            calculateTaxes()
            calculateTotal()
          } 
        }
      } else {
        resetTotal()
      }
    }

    function checkOut() {
      window.location = '/check-out'
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
    }

    return {
      open,
      checkOut,
      products,
      relatedProducts,
      removeFromCart,
      total,
      updateCart,
      shipping,
      subTotal,
      taxes,
      calculateSubTotal,
      doShipping,
      resetTotal,
      calculateTaxes,
      calculateTotal
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
    }
  }
}


</script>