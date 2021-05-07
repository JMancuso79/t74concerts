<template>
    <div>
        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">

            <div class="mt-8 text-2xl">
                Welcome Tower74!
            </div>

        </div>

        <div class="p-6 sm:px-20 bg-gray-200 bg-opacity-25">
            <AdminShowList />
        </div>
    </div>
</template>

<script>
    import AdminShowList from '@/Pages/Partials/AdminShowList'

    export default {
        components: {
            AdminShowList,
        },
    }
</script>
