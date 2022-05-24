<template>
  <div class="min-h-full">
    <Disclosure as="nav" class="bg-gray-800" v-slot="{ open }">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <img class="h-8" src="/images/t74-white-wp.png" alt="Tower 74 Logo" />
            </div>
            <div class="hidden md:block">
              <div class="ml-10 flex items-baseline space-x-4">
                <a v-for="item in navigation" :key="item.name" :href="item.href" :class="[item.current ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'px-3 py-2 rounded-md text-sm font-medium']" :aria-current="item.current ? 'page' : undefined">{{ item.name }}</a>
              </div>
            </div>
          </div>
          <div class="hidden md:block">
            <div class="ml-4 flex items-center md:ml-6">
              <button type="button" class="bg-gray-800 p-1 rounded-full text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
                <span class="sr-only">View notifications</span>
                <BellIcon class="h-6 w-6" aria-hidden="true" />
              </button>

              <!-- Profile dropdown -->
              <Menu as="div" class="ml-3 relative">
                <div>
                  <MenuButton class="max-w-xs bg-gray-800 rounded-full flex items-center text-sm text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
                    <span class="sr-only">Open user menu</span>
                    <img class="h-8 w-8 rounded-full" :src="user.imageUrl" alt="" />
                  </MenuButton>
                </div>
                <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                  <MenuItems class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                    <MenuItem v-for="item in userNavigation" :key="item.name" v-slot="{ active }">
                      <a :href="item.href" :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">{{ item.name }}</a>
                    </MenuItem>
                  </MenuItems>
                </transition>
              </Menu>
            </div>
          </div>
          <div class="-mr-2 flex md:hidden">
            <!-- Mobile menu button -->
            <DisclosureButton class="bg-gray-800 inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
              <span class="sr-only">Open main menu</span>
              <MenuIcon v-if="!open" class="block h-6 w-6" aria-hidden="true" />
              <XIcon v-else class="block h-6 w-6" aria-hidden="true" />
            </DisclosureButton>
          </div>
        </div>
      </div>

      <DisclosurePanel class="md:hidden">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
          <DisclosureButton v-for="item in navigation" :key="item.name" as="a" :href="item.href" :class="[item.current ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'block px-3 py-2 rounded-md text-base font-medium']" :aria-current="item.current ? 'page' : undefined">{{ item.name }}</DisclosureButton>
        </div>
        <div class="pt-4 pb-3 border-t border-gray-700">
          <div class="flex items-center px-5">
            <div class="flex-shrink-0">
              <img class="h-10 w-10 rounded-full" :src="user.imageUrl" alt="" />
            </div>
            <div class="ml-3">
              <div class="text-base font-medium text-white">{{ user.name }}</div>
              <div class="text-sm font-medium text-gray-400">{{ user.email }}</div>
            </div>
            <button type="button" class="ml-auto bg-gray-800 flex-shrink-0 p-1 rounded-full text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
              <span class="sr-only">View notifications</span>
              <BellIcon class="h-6 w-6" aria-hidden="true" />
            </button>
          </div>
          <div class="mt-3 px-2 space-y-1">
            <DisclosureButton v-for="item in userNavigation" :key="item.name" as="a" :href="item.href" class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700">{{ item.name }}</DisclosureButton>
          </div>
        </div>
      </DisclosurePanel>
    </Disclosure>

    <header class="bg-white shadow-sm">
      <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
        <h1 class="text-lg leading-6 font-semibold text-gray-900">Dashboard</h1>
      </div>
    </header>
    <main>
      <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Replace with your content -->
        <div class="px-4 py-4 sm:px-0">

          <div class="grid grid-cols-12 gap-4">
            <!-- Form -->
            <div class="col-span-12 lg:col-span-8">
              <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                  <!-- Success -->
                  <div v-if="success">
                    <div class="rounded-md bg-green-50 p-4">
                      <div class="flex">
                        <div class="flex-shrink-0">
                          <CheckCircleIcon class="h-5 w-5 text-green-400" aria-hidden="true" />
                        </div>
                        <div class="ml-3">
                          <h3 class="text-sm font-medium text-green-800">Product saved</h3>
                          <div class="mt-4">
                            <div class="-mx-2 -my-1.5 flex">
                              <button type="button" class="bg-green-50 px-2 py-1.5 rounded-md text-sm font-medium text-green-800 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-green-50 focus:ring-green-600">View product</button>
                              <button @click.prevent="success = false" type="button" class="ml-3 bg-green-50 px-2 py-1.5 rounded-md text-sm font-medium text-green-800 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-green-50 focus:ring-green-600">Dismiss</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Form -->
                  <form class="space-y-8 divide-y divide-gray-200">
                    <div class="space-y-8 divide-y divide-gray-200">
                      <div>
                        <div>
                          <h3 class="text-lg leading-6 font-medium text-gray-900">Product</h3>
                          <p class="mt-1 text-sm text-gray-500">Create a new product here.</p>
                        </div>

                        <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                          <!-- Name -->
                          <div v-if="category != 'ticket'" class="sm:col-span-4">
                            <label for="name" class="block text-sm font-medium text-gray-700"> Name </label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                              <input v-model="name" type="text" name="name" id="name" class="flex-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full min-w-0 rounded-md  sm:text-sm border-gray-300" />
                            </div>
                          </div>
                          <div v-else class="sm:col-span-4">
                            <label for="name" class="block text-sm font-medium text-gray-700"> Name </label>
                            <div class="mt-1">
                              <select v-model="name" id="category" name="category" autocomplete="category" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                <option value="day-of-show">Day of Show</option>
                                <option value="advance">Advance</option>
                                <option value="general-admission">General Admission</option>
                                <option value="vip">VIP</option>
                                <option value="table">Table</option>
                                <option value="booth">Booth</option>
                              </select>
                            </div>
                          </div>
                          <!-- Short Description -->
                          <div class="sm:col-span-6">
                            <label for="shortDescription" class="block text-sm font-medium text-gray-700"> Short Description </label>
                            <div class="mt-1">
                              <textarea v-model="shortDescription" id="shortDescription" name="shortDescription" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border border-gray-300 rounded-md" />
                            </div>
                            <p class="mt-2 text-sm text-gray-500">Write a short description about the product.</p>
                          </div>
                          <!-- Description -->
                          <div class="sm:col-span-6">
                            <label for="description" class="block text-sm font-medium text-gray-700"> Description </label>
                            <div class="mt-1">
                              <textarea v-model="description" id="description" name="description" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border border-gray-300 rounded-md" />
                            </div>
                            <p class="mt-2 text-sm text-gray-500">Write a description about the product.</p>
                          </div>
                          <!-- Inventory -->
                          <div class="sm:col-span-4">
                            <label for="inventory" class="block text-sm font-medium text-gray-700"> Inventory </label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                              <input v-model="inventory" type="text" name="inventory" id="inventory" class="flex-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full min-w-0 rounded-md  sm:text-sm border-gray-300" />
                            </div>
                          </div>
                          <!-- Price -->
                          <div class="sm:col-span-4">
                            <label for="price" class="block text-sm font-medium text-gray-700"> Price </label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                              <input v-model="price" type="text" name="price" id="price" class="flex-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full min-w-0 rounded-md  sm:text-sm border-gray-300" />
                            </div>
                          </div>


                          <!-- Sizes -->
                          <div v-if="category != 'ticket'" class="sm:col-span-4">
                            <label for="sizes" class="block text-sm font-medium text-gray-700"> Sizes </label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                              <input v-model="sizeString" type="text" name="sizes" id="sizes" class="flex-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full min-w-0 rounded-md  sm:text-sm border-gray-300" />
                            </div>
                            <!-- Sizes -->
                            <div class="text-right pt-2">
                              <button @click.prevent="addSize()" type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">Add</button>
                            </div>
                          </div>   
                          <div class="sm:col-span-6">
                            <div class="pt-2">
                              <span v-for="(size, index) in sizes" :key="size" class="inline-flex items-center py-0.5 pl-2 pr-0.5 mr-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-700">{{size}}
                                <button @click.prevent="removeSize(index)" type="button" class="flex-shrink-0 ml-0.5 h-4 w-4 rounded-full inline-flex items-center justify-center text-indigo-400 hover:bg-indigo-200 hover:text-indigo-500 focus:outline-none focus:bg-indigo-500 focus:text-white">
                                  <span class="sr-only">Remove small option</span>
                                  <svg class="h-2 w-2" stroke="currentColor" fill="none" viewBox="0 0 8 8">
                                    <path stroke-linecap="round" stroke-width="1.5" d="M1 1l6 6m0-6L1 7" />
                                  </svg>
                                </button>
                              </span>
                            </div>
                          </div> 

                          <!-- Colors -->
                          <div v-if="category != 'ticket'" class="sm:col-span-4">
                            <label for="colors" class="block text-sm font-medium text-gray-700"> Colors </label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                              <input v-model="colorString" type="text" name="colors" id="colors" class="flex-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full min-w-0 rounded-md  sm:text-sm border-gray-300" />
                            </div>
                            <!-- Color -->
                            <div class="text-right pt-2">
                              <button @click.prevent="addColor()" type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">Add</button>
                            </div>
                          </div>   
                          <div class="sm:col-span-6">
                            <div class="pt-2">
                              <span v-for="(color, index) in colors" :key="color" class="inline-flex items-center py-0.5 pl-2 pr-0.5 mr-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-700">{{color}}
                                <button @click.prevent="removeColor(index)" type="button" class="flex-shrink-0 ml-0.5 h-4 w-4 rounded-full inline-flex items-center justify-center text-indigo-400 hover:bg-indigo-200 hover:text-indigo-500 focus:outline-none focus:bg-indigo-500 focus:text-white">
                                  <span class="sr-only">Remove small option</span>
                                  <svg class="h-2 w-2" stroke="currentColor" fill="none" viewBox="0 0 8 8">
                                    <path stroke-linecap="round" stroke-width="1.5" d="M1 1l6 6m0-6L1 7" />
                                  </svg>
                                </button>
                              </span>
                            </div>
                          </div>  


                          <!-- Tags -->
                          <div class="sm:col-span-4">
                            <label for="sizes" class="block text-sm font-medium text-gray-700"> Tags </label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                              <input v-model="tagString" type="text" name="sizes" id="sizes" class="flex-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full min-w-0 rounded-md  sm:text-sm border-gray-300" />
                            </div>
                            <!-- Sizes -->
                            <div class="text-right pt-2">
                              <button @click.prevent="addTag()" type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">Add</button>
                            </div>
                          </div>   
                          <div class="sm:col-span-6">
                            <div class="pt-2">
                              <span v-for="(tag, index) in tags" :key="tag" class="inline-flex items-center py-0.5 pl-2 pr-0.5 mr-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-700">{{tag}}
                                <button @click.prevent="removeTag(index)" type="button" class="flex-shrink-0 ml-0.5 h-4 w-4 rounded-full inline-flex items-center justify-center text-indigo-400 hover:bg-indigo-200 hover:text-indigo-500 focus:outline-none focus:bg-indigo-500 focus:text-white">
                                  <span class="sr-only">Remove small option</span>
                                  <svg class="h-2 w-2" stroke="currentColor" fill="none" viewBox="0 0 8 8">
                                    <path stroke-linecap="round" stroke-width="1.5" d="M1 1l6 6m0-6L1 7" />
                                  </svg>
                                </button>
                              </span>
                            </div>
                          </div> 

                          <!-- Images -->
                          <div class="sm:col-span-6">

                            <ProductImages @get-file-name="getImage" />

                            <div class="pt-6">
                              <ul role="list" class="grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8">
                                <li v-for="(file, index) in images" :key="file.filepath" class="relative">
                                  <div class="group block w-full aspect-w-10 aspect-h-7 rounded-lg bg-gray-100 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-gray-100 focus-within:ring-indigo-500 overflow-hidden">
                                    <img :src="file.filepath" alt="" class="object-cover pointer-events-none group-hover:opacity-75" />
                                    <button type="button" class="absolute inset-0 focus:outline-none">
                                      <span class="sr-only">image</span>
                                    </button>
                                  </div>

                                  <p v-if="file.featured === 0" class="">
                                    <button @click.prevent="featureImage(index)" type="button" class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Make Featured</button>
                                  </p>
                                  <p v-if="file.featured === 1" class="">
                                    <button @click.prevent="removeFeatureImage(index)" type="button" class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Remove Featured</button>
                                  </p>
                                  <p class="">
                                    <button @click.prevent="removeImage(index)" type="button" class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Remove</button>
                                  </p>
                                </li>
                              </ul>
                            </div>
                          </div>

                        </div>
                      </div>
                      <div class="pt-8">
                        <div>
                          <h3 class="text-lg leading-6 font-medium text-gray-900">Featured</h3>
                        </div>
                        <div>
                          <fieldset class="mt-6">
                            <div class="space-y-4">
                              <div class="flex items-center">
                                <input v-model="featured" :value="1" id="featured" name="featured" type="radio" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" />
                                <label for="featured" class="ml-3 block text-sm font-medium text-gray-700"> Featured </label>
                              </div>
                              <div class="flex items-center">
                                <input v-model="featured" :value="0" id="not-featured" name="featured" type="radio" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" />
                                <label for="not-featured" class="ml-3 block text-sm font-medium text-gray-700"> Not Featured </label>
                              </div>
                            </div>
                          </fieldset>
                        </div>
                      </div>
                      <div class="pt-8">
                        <div>
                          <h3 class="text-lg leading-6 font-medium text-gray-900">Visibility</h3>
                        </div>
                        <div>
                          <fieldset class="mt-6">
                            <div class="space-y-4">
                              <div class="flex items-center">
                                <input v-model="status" value="published" id="published" name="status" type="radio" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" />
                                <label for="published" class="ml-3 block text-sm font-medium text-gray-700"> Published </label>
                              </div>
                              <div class="flex items-center">
                                <input v-model="status" value="not-published" id="not-published" name="status" type="radio" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" />
                                <label for="not-published" class="ml-3 block text-sm font-medium text-gray-700"> Not Published </label>
                              </div>
                              <div class="flex items-center">
                                <input v-model="status" value="out-of-stock" id="out-of-stock" name="status" type="radio" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" />
                                <label for="out-of-stock" class="ml-3 block text-sm font-medium text-gray-700"> Out of Stock </label>
                              </div>
                            </div>
                          </fieldset>
                        </div>
                      </div>
                    </div>

                    <div class="pt-5">
                      <div class="flex justify-end">
                        <button @click.prevent="deleteProduct()" type="button" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Delete</button>
                        <button @click.prevent="submit()" type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Save</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <!-- List -->
          </div>
        </div>
        <!-- /End replace -->
      </div>
    </main>
  </div>
</template>

<script>
import { defineComponent, ref, onMounted } from 'vue'
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { BellIcon, MenuIcon, XIcon } from '@heroicons/vue/outline'
import ProductImages from '@/Pages/Partials/ProductImages'
import { CheckCircleIcon } from '@heroicons/vue/solid'

const user = {
  name: 'Tom Cook',
  email: 'tom@example.com',
  imageUrl:
    'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
}
const navigation = [
  { name: 'Dashboard', href: '/dashboard', current: false },
  { name: 'Products', href: '/manage/products', current: true },
]
const userNavigation = [
  { name: 'Your Profile', href: '#' },
  { name: 'Settings', href: '#' },
  { name: 'Sign out', href: '#' },
]

export default defineComponent({
  components: {
    Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems, BellIcon, MenuIcon, XIcon, ProductImages, CheckCircleIcon
  },
  props: ['id'],
  setup(props) {
    const name = ref(null);
    const slug = ref(null);
    const shortDescription = ref(null);
    const description = ref(null);
    const inventory = ref(null);
    const price = ref(null);
    const category = ref('tee-shirt');
    const status = ref('not-published');
    const featured = ref(0);
    const image = ref(null);
    const isLoading = ref(false);
    const success = ref(false);
    const colors = ref([]);
    const sizes = ref([]);
    const images = ref([]);
    const tags = ref([]);
    const sizeString = ref(null);
    const colorString = ref(null);
    const tagString = ref(null);
    const product = ref([]);

    onMounted(() => {
      getProduct()
    })

    function getProduct() {
      isLoading.value = true
      axios.get('/web-api/v1/product/'+props.id)
      .then((response) => {
        if(response.data) {
          doProduct(response.data)
        }
      })
    }

    function doProduct(data) {
      if(data && data.id != undefined) {
        name.value = data.name 
        slug.value = data.slug 
        shortDescription.value = data.short_description 
        description.value = data.description
        inventory.value = data.inventory
        price.value = data.price
        category.value = data.category
        status.value = data.status
        featured.value = data.featured
        image.value = data.image 
        doColors(data.colors)
        doTags(data.tags)
        doSizes(data.sizes) 
        images.value = data.images

      }
    }

    function doColors(c) {
      let arr = c.split(' ')

      for(var i=0;i<arr.length;i++) {
        colorString.value = arr[i]
        addColor()
      }
    }

    function doSizes(s) {
      let arr = s.split(' ')

      for(var i=0;i<arr.length;i++) {
        sizeString.value = arr[i]
        addSize()
      }
    }

    function doTags(t) {
      let arr = t.split(' ')

      for(var i=0;i<arr.length;i++) {
        tagString.value = arr[i].replace('#', '')
        addTag()
      }
    }

    function submit() {
      isLoading.value = true
      axios.post('/web-api/v1/update-product/'+props.id, {
        name: name.value,
        slug: slug.value,
        short_description: shortDescription.value,
        description: description.value,
        inventory: inventory.value,
        price: price.value,
        category: category.value,
        status: status.value,
        featured: featured.value,
        images: images.value,
        colors: doColorsString(),
        sizes: doSizesString(),
        tags: doTagsString()
      }).then((response) => {
        isLoading.value = false
        if(response.data.message == 'success') {
          success.value = true
        } else {

        }
      })
    }

    function deleteProduct() {
      isLoading.value = true
      axios.get('/web-api/v1/delete-product/'+props.id)
      .then((response)=> {
        if(response.data.message == 'success') {
          window.location = '/manage/products'
        }
      })
    }

    function doTagsString() {
      let s = ''
      for(var i=0;i<tags.value.length;i++) {
        s += tags.value[i]+' '
      }
      return s
    }

    function doSizesString() {
      let s = ''
      for(var i=0;i<sizes.value.length;i++) {
        s += sizes.value[i]+' '
      }
      return s
    }

    function doColorsString() {
      let s = ''
      for(var i=0;i<colors.value.length;i++) {
        s += colors.value[i]+' '
      }
      return s
    }

    function getImage(e) {
      images.value.push({
        filepath: '/storage/'+e,
        featured: 0
      })
    }

    function removeColor(i) {
      colors.value.splice(i, 1)
    }

    function addColor() {
      colors.value.push(colorString.value)
      colorString.value = null
    }

    function removeSize(i) {
      sizes.value.splice(i, 1)
    }

    function addSize() {
      sizes.value.push(sizeString.value)
      sizeString.value = null
    }

    function removeTag(i) {
      tags.value.splice(i, 1)
    }

    function addTag() {
      tagString.value.replace('#', '')
      tags.value.push('#'+tagString.value)
      tagString.value = null
    }

    function removeImage(i) {
      images.value.splice(i, 1)
    }

    function featureImage(i) {
      for(var x=0;x<images.value.length;x++) {
        images.value[x].featured = 0
      }
      images.value[i].featured = 1
    }

    function removeFeatureImage(i) {
      for(var x=0;x<images.value.length;x++) {
        images.value[x].featured = 0
      }
    }

    return {
      name,
      slug,
      shortDescription,
      description,
      user,
      navigation,
      userNavigation,
      inventory,
      price,
      category,
      status,
      featured,
      image,
      success,
      isLoading,
      submit,
      images,
      colors,
      sizes,
      tags,
      getImage,
      colorString,
      sizeString,
      removeColor,
      addColor,
      addSize,
      removeSize,
      addTag,
      removeTag,
      tagString,
      removeImage,
      featureImage,
      product,
      removeFeatureImage,
      deleteProduct
    }
  },
  watch: {

  }
});
</script>