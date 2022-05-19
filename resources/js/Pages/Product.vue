<template>
  <div class="bg-white">
    <Header />
    <main class="mt-8 max-w-2xl mx-auto pb-16 px-4 sm:pb-24 sm:px-6 lg:max-w-7xl lg:px-8">
      <div class="lg:grid lg:grid-cols-12 lg:auto-rows-min lg:gap-x-8">
        <div class="lg:col-start-8 lg:col-span-5">
          <div class="flex justify-between">
            <h1 class="text-xl font-medium text-gray-900">
              {{ product.name }}
            </h1>
            <p class="text-xl font-medium text-gray-900">
              {{ product.price }}
            </p>
          </div>
          <!-- Reviews 
          <div class="mt-4">
            <h2 class="sr-only">Reviews</h2>
            <div class="flex items-center">
              <p class="text-sm text-gray-700">
                {{ reviews.average }}
                <span class="sr-only"> out of 5 stars</span>
              </p>
              <div class="ml-1 flex items-center">
                <StarIcon v-for="rating in [0, 1, 2, 3, 4]" :key="rating" :class="[reviews.average > rating ? 'text-yellow-400' : 'text-gray-200', 'h-5 w-5 flex-shrink-0']" aria-hidden="true" />
              </div>
              <div aria-hidden="true" class="ml-4 text-sm text-gray-300">·</div>
              <div class="ml-4 flex">
                <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">See all {{ reviews.totalCount }} reviews</a>
              </div>
            </div>
          </div>-->
        </div>

        <!-- Image gallery -->
        <div class="mt-8 lg:mt-0 lg:col-start-1 lg:col-span-7 lg:row-start-1 lg:row-span-3">
          <h2 class="sr-only">Images</h2>

          <div class="grid grid-cols-1 lg:grid-cols-2 lg:grid-rows-3 lg:gap-8">
            <img v-for="image in product.images" :key="image.id" :src="image.imageSrc" :alt="image.imageAlt" :class="[image.primary ? 'lg:col-span-2 lg:row-span-2' : 'hidden lg:block', 'rounded-lg']" />
          </div>
        </div>

        <div class="mt-8 lg:col-span-5">
          <form>
            <!-- Color picker -->
            <div>
              <h2 class="text-sm font-medium text-gray-900">Color</h2>

              <RadioGroup v-model="selectedColor" class="mt-2">
                <RadioGroupLabel class="sr-only"> Choose a color </RadioGroupLabel>
                <div class="flex items-center space-x-3">
                  <RadioGroupOption as="template" v-for="color in product.colors" :key="color.name" :value="color" v-slot="{ active, checked }">
                    <div :class="[color.selectedColor, active && checked ? 'ring ring-offset-1' : '', !active && checked ? 'ring-2' : '', '-m-0.5 relative p-0.5 rounded-full flex items-center justify-center cursor-pointer focus:outline-none']">
                      <RadioGroupLabel as="span" class="sr-only">
                        {{ color.name }}
                      </RadioGroupLabel>
                      <span aria-hidden="true" :class="[color.bgColor, 'h-8 w-8 border border-black border-opacity-10 rounded-full']" />
                    </div>
                  </RadioGroupOption>
                </div>
              </RadioGroup>
            </div>

            <!-- Size picker -->
            <div class="mt-8">
              <div class="flex items-center justify-between">
                <h2 class="text-sm font-medium text-gray-900">Size</h2>
                <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">See sizing chart</a>
              </div>

              <RadioGroup v-model="selectedSize" class="mt-2">
                <RadioGroupLabel class="sr-only"> Choose a size </RadioGroupLabel>
                <div class="grid grid-cols-3 gap-3 sm:grid-cols-6">
                  <RadioGroupOption as="template" v-for="size in product.sizes" :key="size.name" :value="size" :disabled="!size.inStock" v-slot="{ active, checked }">
                    <div :class="[size.inStock ? 'cursor-pointer focus:outline-none' : 'opacity-25 cursor-not-allowed', active ? 'ring-2 ring-offset-2 ring-indigo-500' : '', checked ? 'bg-indigo-600 border-transparent text-white hover:bg-indigo-700' : 'bg-white border-gray-200 text-gray-900 hover:bg-gray-50', 'border rounded-md py-3 px-3 flex items-center justify-center text-sm font-medium uppercase sm:flex-1']">
                      <RadioGroupLabel as="span">
                        {{ size.name }}
                      </RadioGroupLabel>
                    </div>
                  </RadioGroupOption>
                </div>
              </RadioGroup>
            </div>

            <button type="submit" class="mt-8 w-full bg-indigo-600 border border-transparent rounded-md py-3 px-8 flex items-center justify-center text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Add to cart</button>
          </form>

          <!-- Product details -->
          <div class="mt-10">
            <h2 class="text-sm font-medium text-gray-900">Description</h2>

            <div class="mt-4 prose prose-sm text-gray-500" v-html="product.description" />
          </div>

          <div class="mt-8 border-t border-gray-200 pt-8">
            <h2 class="text-sm font-medium text-gray-900">Fabric &amp; Care</h2>

            <div class="mt-4 prose prose-sm text-gray-500">
              <ul role="list">
                <li v-for="item in product.details" :key="item">{{ item }}</li>
              </ul>
            </div>
          </div>

          <!-- Policies -->
          <section aria-labelledby="policies-heading" class="mt-10">
            <h2 id="policies-heading" class="sr-only">Our Policies</h2>

            <dl class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-1 xl:grid-cols-2">
              <div v-for="policy in policies" :key="policy.name" class="bg-gray-50 border border-gray-200 rounded-lg p-6 text-center">
                <dt>
                  <component :is="policy.icon" class="mx-auto h-6 w-6 flex-shrink-0 text-gray-400" aria-hidden="true" />
                  <span class="mt-4 text-sm font-medium text-gray-900">
                    {{ policy.name }}
                  </span>
                </dt>
                <dd class="mt-1 text-sm text-gray-500">
                  {{ policy.description }}
                </dd>
              </div>
            </dl>
          </section>
        </div>
      </div>

      <!-- Reviews 
      <section aria-labelledby="reviews-heading" class="mt-16 sm:mt-24">
        <h2 id="reviews-heading" class="text-lg font-medium text-gray-900">Recent reviews</h2>

        <div class="mt-6 border-t border-b border-gray-200 pb-10 divide-y divide-gray-200 space-y-10">
          <div v-for="review in reviews.featured" :key="review.id" class="pt-10 lg:grid lg:grid-cols-12 lg:gap-x-8">
            <div class="lg:col-start-5 lg:col-span-8 xl:col-start-4 xl:col-span-9 xl:grid xl:grid-cols-3 xl:gap-x-8 xl:items-start">
              <div class="flex items-center xl:col-span-1">
                <div class="flex items-center">
                  <StarIcon v-for="rating in [0, 1, 2, 3, 4]" :key="rating" :class="[review.rating > rating ? 'text-yellow-400' : 'text-gray-200', 'h-5 w-5 flex-shrink-0']" aria-hidden="true" />
                </div>
                <p class="ml-3 text-sm text-gray-700">{{ review.rating }}<span class="sr-only"> out of 5 stars</span></p>
              </div>

              <div class="mt-4 lg:mt-6 xl:mt-0 xl:col-span-2">
                <h3 class="text-sm font-medium text-gray-900">{{ review.title }}</h3>

                <div class="mt-3 space-y-6 text-sm text-gray-500" v-html="review.content" />
              </div>
            </div>

            <div class="mt-6 flex items-center text-sm lg:mt-0 lg:col-start-1 lg:col-span-4 lg:row-start-1 lg:flex-col lg:items-start xl:col-span-3">
              <p class="font-medium text-gray-900">{{ review.author }}</p>
              <time :datetime="review.datetime" class="ml-4 border-l border-gray-200 pl-4 text-gray-500 lg:ml-0 lg:mt-2 lg:border-0 lg:pl-0">{{ review.date }}</time>
            </div>
          </div>
        </div>
      </section>-->

      <!-- Related products
      <section aria-labelledby="related-heading" class="mt-16 sm:mt-24">
        <h2 id="related-heading" class="text-lg font-medium text-gray-900">Customers also purchased</h2>

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

<script setup>
import { ref } from 'vue'
import Header from '@/Pages/Partials/Header'
import {
  Dialog,
  DialogPanel,
  Popover,
  PopoverButton,
  PopoverGroup,
  PopoverPanel,
  RadioGroup,
  RadioGroupLabel,
  RadioGroupOption,
  Tab,
  TabGroup,
  TabList,
  TabPanel,
  TabPanels,
  TransitionChild,
  TransitionRoot,
} from '@headlessui/vue'
import {
  CurrencyDollarIcon,
  GlobeIcon,
  MenuIcon,
  SearchIcon,
  ShoppingBagIcon,
  UserIcon,
  XIcon,
} from '@heroicons/vue/outline'
import { StarIcon } from '@heroicons/vue/solid'

const navigation = {
  categories: [
    {
      id: 'women',
      name: 'Women',
      featured: [
        {
          name: 'New Arrivals',
          href: '#',
          imageSrc: 'https://tailwindui.com/img/ecommerce-images/mega-menu-category-01.jpg',
          imageAlt: 'Models sitting back to back, wearing Basic Tee in black and bone.',
        },
        {
          name: 'Basic Tees',
          href: '#',
          imageSrc: 'https://tailwindui.com/img/ecommerce-images/mega-menu-category-02.jpg',
          imageAlt: 'Close up of Basic Tee fall bundle with off-white, ochre, olive, and black tees.',
        },
        {
          name: 'Accessories',
          href: '#',
          imageSrc: 'https://tailwindui.com/img/ecommerce-images/mega-menu-category-03.jpg',
          imageAlt: 'Model wearing minimalist watch with black wristband and white watch face.',
        },
      ],
      sections: [
        [
          {
            id: 'shoes',
            name: 'Shoes & Accessories',
            items: [
              { name: 'Sneakers', href: '#' },
              { name: 'Boots', href: '#' },
              { name: 'Flats', href: '#' },
              { name: 'Sandals', href: '#' },
              { name: 'Heels', href: '#' },
              { name: 'Socks', href: '#' },
            ],
          },
          {
            id: 'collection',
            name: 'Shop Collection',
            items: [
              { name: 'Everything', href: '#' },
              { name: 'Core', href: '#' },
              { name: 'New Arrivals', href: '#' },
              { name: 'Sale', href: '#' },
              { name: 'Accessories', href: '#' },
            ],
          },
        ],
        [
          {
            id: 'clothing',
            name: 'All Clothing',
            items: [
              { name: 'Basic Tees', href: '#' },
              { name: 'Artwork Tees', href: '#' },
              { name: 'Tops', href: '#' },
              { name: 'Bottoms', href: '#' },
              { name: 'Swimwear', href: '#' },
              { name: 'Underwear', href: '#' },
            ],
          },
          {
            id: 'accessories',
            name: 'All Accessories',
            items: [
              { name: 'Watches', href: '#' },
              { name: 'Wallets', href: '#' },
              { name: 'Bags', href: '#' },
              { name: 'Sunglasses', href: '#' },
              { name: 'Hats', href: '#' },
              { name: 'Belts', href: '#' },
            ],
          },
        ],
        [
          {
            id: 'brands',
            name: 'Brands',
            items: [
              { name: 'Full Nelson', href: '#' },
              { name: 'My Way', href: '#' },
              { name: 'Re-Arranged', href: '#' },
              { name: 'Counterfeit', href: '#' },
              { name: 'Significant Other', href: '#' },
            ],
          },
        ],
      ],
    },
    {
      id: 'men',
      name: 'Men',
      featured: [
        {
          name: 'Accessories',
          href: '#',
          imageSrc: 'https://tailwindui.com/img/ecommerce-images/home-page-03-category-01.jpg',
          imageAlt:
            'Wooden shelf with gray and olive drab green baseball caps, next to wooden clothes hanger with sweaters.',
        },
        {
          name: 'New Arrivals',
          href: '#',
          imageSrc: 'https://tailwindui.com/img/ecommerce-images/product-page-04-detail-product-shot-01.jpg',
          imageAlt: 'Drawstring top with elastic loop closure and textured interior padding.',
        },
        {
          name: 'Artwork Tees',
          href: '#',
          imageSrc: 'https://tailwindui.com/img/ecommerce-images/category-page-02-image-card-06.jpg',
          imageAlt:
            'Three shirts in gray, white, and blue arranged on table with same line drawing of hands and shapes overlapping on front of shirt.',
        },
      ],
      sections: [
        [
          {
            id: 'shoes',
            name: 'Shoes & Accessories',
            items: [
              { name: 'Sneakers', href: '#' },
              { name: 'Boots', href: '#' },
              { name: 'Sandals', href: '#' },
              { name: 'Socks', href: '#' },
            ],
          },
          {
            id: 'collection',
            name: 'Shop Collection',
            items: [
              { name: 'Everything', href: '#' },
              { name: 'Core', href: '#' },
              { name: 'New Arrivals', href: '#' },
              { name: 'Sale', href: '#' },
            ],
          },
        ],
        [
          {
            id: 'clothing',
            name: 'All Clothing',
            items: [
              { name: 'Basic Tees', href: '#' },
              { name: 'Artwork Tees', href: '#' },
              { name: 'Pants', href: '#' },
              { name: 'Hoodies', href: '#' },
              { name: 'Swimsuits', href: '#' },
            ],
          },
          {
            id: 'accessories',
            name: 'All Accessories',
            items: [
              { name: 'Watches', href: '#' },
              { name: 'Wallets', href: '#' },
              { name: 'Bags', href: '#' },
              { name: 'Sunglasses', href: '#' },
              { name: 'Hats', href: '#' },
              { name: 'Belts', href: '#' },
            ],
          },
        ],
        [
          {
            id: 'brands',
            name: 'Brands',
            items: [
              { name: 'Re-Arranged', href: '#' },
              { name: 'Counterfeit', href: '#' },
              { name: 'Full Nelson', href: '#' },
              { name: 'My Way', href: '#' },
            ],
          },
        ],
      ],
    },
  ],
  pages: [
    { name: 'Company', href: '#' },
    { name: 'Stores', href: '#' },
  ],
}
const product = {
  name: 'Tower 74 Black Tee',
  price: '$25',
  href: '#',
  breadcrumbs: [
    { id: 1, name: 'Women', href: '#' },
    { id: 2, name: 'Clothing', href: '#' },
  ],
  images: [
    {
      id: 1,
      imageSrc: '/images/back-tee-1.jpg',
      imageAlt: "Back of men's Basic Tee.",
      primary: true,
    },
    {
      id: 2,
      imageSrc: '/images/front-tee-1.jpg',
      imageAlt: "Front of men's Basic Tee.",
      primary: false,
    },
  ],
  colors: [
    { name: 'Black', bgColor: 'bg-gray-900', selectedColor: 'ring-gray-900' },
    //{ name: 'Heather Grey', bgColor: 'bg-gray-400', selectedColor: 'ring-gray-400' },
  ],
  sizes: [
    //{ name: 'XXS', inStock: true },
    //{ name: 'XS', inStock: true },
    { name: 'S', inStock: true },
    { name: 'M', inStock: true },
    { name: 'L', inStock: true },
    { name: 'XL', inStock: true },
  ],
  description: `
    <p>The Basic tee is an honest new take on a classic. The tee uses super soft, pre-shrunk cotton for true comfort and a dependable fit. They are hand cut and sewn locally, with a special dye technique that gives each tee it's own look.</p>
    <p>Looking to stock your closet? The Basic tee also comes in a 3-pack or 5-pack at a bundle discount.</p>
  `,
  details: [
    'Only the best materials',
    'Ethically and locally made',
    'Pre-washed and pre-shrunk',
    'Machine wash cold with similar colors',
  ],
}
const policies = [
  { name: 'United States delivery only', icon: GlobeIcon, description: 'Delivery charge is $5 per shirt.' },
  //{ name: 'Loyalty rewards', icon: CurrencyDollarIcon, description: "Don't look at other tees" },
]
const reviews = {}
const relatedProducts = []
const footerNavigation = {}

const open = ref(false)
const selectedColor = ref(product.colors[0])
const selectedSize = ref(product.sizes[2])
</script>