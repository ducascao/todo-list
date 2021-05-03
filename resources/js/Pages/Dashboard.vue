<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tarefas
            </h2>
        </template>

        <div class="p-1">
            <tasks :tasks="userTasks" />
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
        },
        data() {
            return {
                userTasks: []
            }
        },
        methods: {
            getUserTasks() {
                axios.get('api/user/1/tasks')
                .then(response => {
                    this.userTasks = response.data
                })
                .catch(err => {
                    console.log(err)
                })
            }
        },
        mounted() {
            this.getUserTasks();
        }
    }
</script>
