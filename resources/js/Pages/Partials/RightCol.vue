<template> 
  <div class="bg-white rounded-lg shadow p-6 mb-4">
      <!-- 
        Right Col Here
      -->
      <a href="https://tower74agency.com" target="_blank">
          <img src="/images/tower74.jpg" style="width:100%!important;" />
      </a>
      <button @click.prevent="goTo('https://tower74agency.com')" type="button" class="mt-4 w-full px-4 py-2 border border-gray-300 shadow-sm text-center font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Booking Info</button>
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

    function goTo() {
        window.location = 'https://tower74agency.com'
    }

    return {
      goTo,

    }
  },
}

</script>