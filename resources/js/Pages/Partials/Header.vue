<template>
	<div class="fixed top-0 left-0 right-0 bg-black shadow">
		<div class="max-width mx-auto">
			<div class="flex">
				<div class="flex-none w-32 h-16">
					<!-- This item will not grow -->
					<div class="grid justify-items-center items-center h-16">
                        <a href="/"><svg fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor" class="-mt-px w-5 h-5 text-white">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg></a>
					</div>
				</div>
				<div class="flex-grow h-16">
					<!-- This item will grow -->
					<div class="grid justify-items-center items-center h-16">
						<a href="/" class="block sm:hidden sm-logo">Tower 74<br>Concerts</a>
						<a href="/" class="hidden sm:block lg-logo">Tower 74 Concerts</a>
					</div>
				</div>
				<div class="flex-none w-32 h-16">
					<!-- This item will not grow -->
					<div class="grid justify-items-center items-center h-16 text-white">
                        <a href="/contact"><svg fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor" class="-mt-px w-5 h-5 text-white">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg></a>
					</div>
				</div>
			</div>
		</div>	
	</div>
</template>

<script>
    //import DangerButton from '@/Jetstream/DangerButton'

    export default {
        props: [],

        components: {
            //DangerButton,
        },
    }
</script>