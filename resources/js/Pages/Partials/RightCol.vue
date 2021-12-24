<template> 
  <div>
    <section aria-labelledby="who-to-follow-heading" class="mb-4">
      <div class="bg-white rounded-lg shadow">
        <div class="p-6">
          <h2 id="who-to-follow-heading" class="text-base font-medium text-gray-900">
            Tower 74 Agency
          </h2>

          <div class="flow-root mt-6">
            <ul role="list" class="-my-5 divide-y divide-gray-200">
              <li v-for="announcement in announcements" :key="announcement.id" class="py-5">
                <div class="relative focus-within:ring-2 focus-within:ring-indigo-500">
                  <h3 class="text-sm font-semibold text-gray-800">
                    <div>
                      <!-- Extend touch target to entire panel -->
                      <span class="absolute inset-0" aria-hidden="true" />
                      {{ announcement.title }}
                    </div>
                  </h3>
                  <p class="mt-1 text-sm text-gray-600 line-clamp-2">
                    {{ announcement.preview }}
                  </p>
                </div>
              </li>
            </ul>
          </div>
          <div class="mt-6">
            <a href="https://tower74agency.com" class="w-full flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50" target="_blank">
              Visit the website
            </a>
          </div>

        </div>
      </div>
    </section>

  </div>
</template>

<script>
import { } from 'vue';

import { PlusSmIcon, ChatAltIcon } from '@heroicons/vue/solid'

const announcements = [
  {
    id: 1,
    title: 'Artist Development',
    preview:
      'Strategic booking with an effective marketing plan to help artists accomplish short and long term goals. Contact T74 Agency for more info.',
  },
  {
    id: 2,
    title: 'Booking for Artists & Venues',
    preview:
      'We help artists get a foot in the door with real venues. We have more than 20 years experience creating & managing events, booking artists and generating revenue for artists & venues.',
  },
  {
    id: 3,
    title: 'Marketing Services',
    preview:
      'Tower 74 offers a variety of marketing services including graphic design, web development, social media management, content creation and more.',
  },
]

export default {
  components: {
    PlusSmIcon,
    ChatAltIcon
  },
  setup() {


    return {
      announcements
    }
  },
}

</script>