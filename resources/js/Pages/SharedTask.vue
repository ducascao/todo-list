<template>
    <div class="grid grid-cols-3">
        <div class="bg-white p-2 m-2 rounded-md shadow-lg" v-for="(task, taskIndex) in tasks">
            <span class="font-bold" v-if="!showEditTask">
                {{ task.description }}
                <Icon 
                    name="edit" 
                    v-bind:class="'text-yellow-500'" 
                    style="cursor:pointer" 
                    @click="enableTitleEdit()" />
            </span>
            <div v-else>
                <input type="text" class="w-full" v-on:keyup.enter="editTask(task.id, $event)" />
            </div>
            <div :id="item.id" class="font-thin" v-for="(item, itemIndex) in task.items" v-bind:class="item.done && 'line-through'">
                <input 
                    type="checkbox" 
                    :value="item.id" 
                    @change="checkItem($event)" 
                    :checked="item.done"/> {{ item.description }}
                    <Icon 
                        name="minus-circle" 
                        v-bind:class="'text-red-500'"
                        @click="removeItem(item.id)" 
                        style="cursor:pointer" />
            </div>

            <!-- Nova item da tarefa -->
            <div>
                <input 
                    type="text" 
                    class="w-full"
                    placeholder="informe a descrição do item"
                    v-on:keyup.enter="addItem(task.id, $event)" />
            </div>
        </div>
    </div>
</template>
<script>
    import Icon from '@/Components/Icon'

    export default {
        components: {
            Icon
        },
        props: {
            code: {
                type: String,
                required: true
            }
        },
        data() {
            return {
                itemCheck: false,
                showEditTask: false,
                baseUrl: this.route().t.url,
                tasks: []
            }
        },
        methods: {
            enableTitleEdit() {
                this.showEditTask = !this.showEditTask;
            },
            editTask(id, e) {
                let description = e.target.value

                axios.put(`${this.baseUrl}/api/tasks/${id}`, { description })
                .finally(() => {
                    this.enableTitleEdit()
                })
            },
            addItem(id, event) {
                let data = {
                    description: event.target.value,
                    task_id: id,
                    done: 0
                }
                
                axios.post(`${this.baseUrl}/api/task-items`, data)
                .finally(() => {
                    this.refreshTasks()
                })
            },
            checkItem(e) {
                let id = e.target.value
                let checked = e.target.checked

                axios.put(`${this.baseUrl}/api/task-items/${id}`, {
                    done: checked
                })
                .finally(() => {
                    e.target.value = ""
                    this.refreshTasks()
                })
            },
            removeItem(id) {
                axios.delete(`${this.baseUrl}/api/task-items/${id}`)
                .finally(() => {
                    this.refreshTasks()
                })
            },
            refreshTasks() {
                axios.get(`${this.baseUrl}/api/tasks/share/${this.code}`)
                .then(response => {
                    this.tasks = response.data
                })
            }
        },
        mounted() {
            this.refreshTasks()
        }
    }
</script>