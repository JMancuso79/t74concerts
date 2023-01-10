<template>
  <div>
    <div class="bg-white rounded-lg shadow p-6 mb-4">
      <!--
        Right Col Here
      -->
      <a href="/contact">
          <img src="https://tower74concerts.com/storage/images/T74-MARKETING-WINTER-22.jpg" style="width:100%!important;" />
      </a>
      <button @click.prevent="goTo('/contact')" type="button" class="mt-4 w-full px-4 py-2 border border-gray-300 shadow-sm text-center font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Contact</button>
    </div>
    <div class="bg-white rounded-lg shadow p-6 mb-4">
        <!--
          Right Col Here
        -->
        <a href="/product/4">
            <img src="https://tower74concerts.com/storage/images/628d5902e11b8_back-tee-1.jpg" style="width:100%!important;" />
        </a>
        <button @click.prevent="goTo('/product/4')" type="button" class="mt-4 w-full px-4 py-2 border border-gray-300 shadow-sm text-center font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Shop</button>
    </div>
  </div>
</template>


<script>
import { } from 'vue';

import { PlusSmIcon, ChatAltIcon } from '@heroicons/vue/solid'



export default {
  components: {
    PlusSmIcon,
    ChatAltIcon
  },
  setup() {

    function goTo(URL) {
        window.location = URL
    }

    return {
      goTo,

    }
  },
}

</script>
