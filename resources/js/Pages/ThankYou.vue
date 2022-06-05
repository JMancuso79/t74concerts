<template>
  <div class="bg-white">
    <Header />

    <main class="max-w-2xl mx-auto pt-16 pb-24 px-4 sm:px-6 lg:max-w-7xl lg:px-8">
      <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">Thank You!</h1>

      <div class="rounded-md bg-green-50 p-4 mt-4">
        <div class="flex">
          <div class="flex-shrink-0">
            <CheckCircleIcon class="h-5 w-5 text-green-400" aria-hidden="true" />
          </div>
          <div class="ml-3">
            <h3 class="text-sm font-medium text-green-800">Order completed</h3>
            <div class="mt-2 text-sm text-green-700">
              <p>Your order has been completed! We sent a confirmation to your email. Please check your spam if you do not see the email. Feel free to contact us with questions about your order.</p>
            </div>
            <div class="mt-4">
              <div class="-mx-2 -my-1.5 flex">
                <button @click.prevent="goTo()" type="button" class="bg-green-50 px-2 py-1.5 rounded-md text-sm font-medium text-green-800 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-green-50 focus:ring-green-600">Contact</button>
              </div>
            </div>
          </div>
        </div>
      </div>
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
import { CheckCircleIcon } from '@heroicons/vue/solid'

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
    Header, CheckCircleIcon
  },
  props: [],
  setup(props) {


    onMounted(() => {

    })

    function goTo() {
      window.location = '/contact'
    }

    return {
      goTo
    }
  },
  watch: {

  }
}


</script>