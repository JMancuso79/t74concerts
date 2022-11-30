<template>
  <div class="pb-16 bg-gray-50">
    <Header />
    <main>
      <div class="relative bg-gray-900 py-32 px-6 sm:py-40 sm:px-12 lg:px-16 mb-16 lg:mb-24">
        <div class="absolute inset-0 overflow-hidden">
          <img src="/storage/images/space-bg.jpg" alt="" class="h-full w-full object-cover object-center" />
        </div>
        <div aria-hidden="true" class="absolute inset-0 bg-gray-900 bg-opacity-50" />
        <div class="relative mx-auto flex max-w-3xl flex-col items-center text-center">
          <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">Tower 74 Website & App Development</h2>
          <p class="mt-3 text-xl text-white">We create fully responsive websites and apps that look great on all devices. Our basic website packages are built with high quality templates and themes. All of our packages come with SSL certificate, one  year of hosting, maintenance, backups and software updates.</p>
          <a href="/contact" class="mt-8 block w-full rounded-md border border-transparent bg-white py-3 px-8 text-base font-medium text-gray-900 hover:bg-gray-100 sm:w-auto">Get Started</a>
        </div>
      </div>
      <!-- Pricing Section -->
      <section class="relative" aria-labelledby="pricing-heading">
        <h2 id="pricing-heading" class="sr-only">Pricing</h2>

        <!-- Tiers -->
        <div class="mx-auto max-w-2xl space-y-12 px-4 sm:px-6 lg:grid lg:max-w-7xl lg:grid-cols-3 lg:gap-x-8 lg:space-y-0 lg:px-8">
          <div v-for="tier in pricing.tiers" :key="tier.title" class="relative flex flex-col border border-gray-300 bg-white p-8 shadow-sm">
            <div class="flex-1">
              <h3 class="text-xl font-semibold text-gray-900">{{ tier.title }}</h3>
              <p v-if="tier.mostPopular" class="absolute top-0 -translate-y-1/2 transform rounded-full bg-blue-500 py-1.5 px-4 text-sm font-semibold text-white">Most popular</p>
              <p class="mt-4 flex items-baseline text-gray-900">
                <span class="text-5xl font-bold tracking-tight">${{ tier.price }}</span>
                <span class="ml-1 text-xl font-semibold">{{ tier.frequency }}</span>
              </p>
              <p class="mt-6 text-gray-800">{{ tier.description }}</p>

              <!-- Feature list -->
              <ul role="list" class="mt-6 space-y-6">
                <li v-for="feature in tier.features" :key="feature" class="flex">
                  <CheckIcon class="h-6 w-6 flex-shrink-0 text-green-500" aria-hidden="true" />
                  <span class="ml-3 text-gray-600">{{ feature }}</span>
                </li>
              </ul>
            </div>

            <a href="/contact" :class="[tier.mostPopular ? 'bg-blue-500 text-white hover:bg-blue-600' : 'bg-blue-50 text-blue-700 hover:bg-blue-100', 'mt-8 block w-full py-3 px-6 border border-transparent text-center font-medium']">{{ tier.cta }}</a>
          </div>
        </div>
      </section>

    </main>
  </div>
</template>

<script setup>
import { defineComponent, h } from 'vue'
import { CheckIcon } from '@heroicons/vue/outline'
import Header from '@/Pages/Partials/Header'

const pricing = {
  tiers: [
    {
      title: 'Basic Website',
      price: 550,
      frequency: '',
      description: '',
      features: [
        'Responsive on all devices',
        'High quality templates & theme',
        'Landing page', 
        '3 content pages', 
        '3 stock photos',
        'Contact page', 
        'SSL certificate', 
        '1 year of hosting', 
        '1 year of maintenance & backups', 
        '1 year of software updates'
      ],
      cta: 'Get Started',
      mostPopular: false,
    },
    {
      title: 'Basic Website + Shop',
      price: 850,
      frequency: '',
      description: '',
      features: [
        'Responsive on all devices',
        'High quality templates & theme',
        'Landing page', 
        '3 content pages', 
        '3 stock photos',
        'Contact page', 
        'Shop w/cart', 
        'SSL certificate', 
        '1 year of hosting', 
        '1 year of maintenance & backups', 
        '1 year of software updates'
      ],
      cta: 'Get Started',
      mostPopular: true,
    },
    {
      title: 'Custom Website',
      price: 1250,
      frequency: '',
      description: 'Custom websites and apps start at $1,250',
      features: [
        'Custom & mobile first design',
        'Landing page', 
        '5+ content pages', 
        '5 stock photos',
        'Contact page', 
        'Shop w/cart', 
        'SSL certificate', 
        '1 year of hosting', 
        '1 year of maintenance & backups', 
        '1 year of software updates'
      ],
      cta: 'Get Started',
      mostPopular: false,
    },
  ],
}
</script>