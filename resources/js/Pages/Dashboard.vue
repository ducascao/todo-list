<template>
    <app-layout>
        <div class="max-w-7xl p-1 mx-auto sm:px-6 lg:px-8">
            <tasks  />
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Tasks from '@/Pages/Tasks'

    export default {
        components: {
            AppLayout,
            Tasks,
        }
    }
</script>
