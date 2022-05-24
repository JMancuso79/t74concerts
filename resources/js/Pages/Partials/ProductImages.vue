<template>
  <div>
    <!-- Errors -->
    <div v-if="errors && errors.length" class="rounded-md bg-red-50 p-4 mb-4">
      <div class="flex">
        <div class="flex-shrink-0">
          <XCircleIcon class="h-5 w-5 text-red-400" aria-hidden="true" />
        </div>
        <div class="ml-3">
          <h3 v-if="errors.length != 1" class="text-sm font-medium text-red-800">There were {{errors.length}} errors with your upload</h3>
          <h3 v-else class="text-sm font-medium text-red-800">There was 1 error with your upload</h3>
          <div class="mt-2 text-sm text-red-700">
            <ul role="list" class="list-disc pl-5 space-y-1">
              <li v-for="error in errors" :key="error">{{error}}</li>
            </ul>
          </div>
        </div>
      </div>
    </div>                  
    <label for="cover-photo" class="block text-sm font-medium text-gray-700"> Upload photo </label>
    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
      <div class="space-y-1 text-center">
        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
          <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        <div class="flex text-sm text-gray-600">
          <label @click="initUpload()" for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
            <span>Upload a file</span>
            <input ref="uploadimage" id="file-upload" @change="upload" name="file-upload" type="file" class="sr-only" />
          </label>
          <p class="pl-1">or drag and drop</p>
        </div>
        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
      </div>
    </div>
                        
  </div>
</template>

<script>
import { watch, ref, onMounted } from 'vue';
import { XCircleIcon } from '@heroicons/vue/solid'
export default {
  components: {
    XCircleIcon
  },
  props: [],
  setup() {
    const image = ref(null);
    const imgData = ref(null);
    const errors = ref([]);

    onMounted(() => {

    })

    return {
      image,
      imgData,
      errors
    }
  },
  methods: {
    initUpload: function() {
      this.$refs.uploadimage.click()  
    },
    upload: function(event) {
      let imageData = new FormData();
      let file = event.target.files[0];

      let config = {
          header : {
              'Content-Type' : 'multipart/form-data'
          }
      }
           
      imageData.append('file', file)

      axios.post('/web-api/v1/image', imageData, config).then((response) => {
        if(response.data.message == 'success') {
          this.image = response.data.filepath
          this.$emit('get-file-name', this.image)
        } else {
          this.errors = response.data.errors
        }
      })
    }
  },
  watch: {

  }
}
</script>