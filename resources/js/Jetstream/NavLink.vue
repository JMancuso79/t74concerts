<template>
    <inertia-link :href="href" :class="classes">
        <slot></slot>
    </inertia-link>
</template>

<script>
    export default {
        props: ['href', 'active'],

        computed: {
            classes() {
                return this.active
                            ? 'inline-flex items-center px-1 pt-1 font-bold text-dark focus:outline-none transition duration-150 ease-in-out'
                            : 'inline-flex items-center px-1 pt-1 inline-flex items-center px-1 pt-1 font-bold hover:text-white text-dark transition duration-150 ease-in-out'
            }
        }
    }
</script>
