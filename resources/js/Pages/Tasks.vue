<template>
    <div>
        <div class="grid grid-cols-2">
            <div class="bg-white p-2 m-2 rounded-md shadow-lg" v-for="(task, taskIndex) in tasks" @dragover.prevent @drop="dropItem(task.id, $event)">
                <span v-show="!showShareInput">
                    <span class="font-bold" v-if="!showEditTask">
                        {{ task.description }}
                        <Icon 
                            name="share" 
                            v-bind:class="'text-green-500'" 
                            style="cursor:pointer" 
                            @click="enableShareInput()" />

                        <Icon 
                            name="edit" 
                            v-bind:class="'text-yellow-500'" 
                            style="cursor:pointer" 
                            @click="enableTitleEdit()" />

                        <Icon 
                            name="trash" 
                            v-bind:class="'text-red-500'" 
                            style="cursor:pointer" 
                            @click="deleteTask(task.id)" />
                    </span>
                    <div v-else>
                        <input type="text" class="w-full" v-on:keyup.enter="editTask(task.id, $event)" />
                    </div>
                    <div :id="item.id" class="font-thin" v-for="(item, itemIndex) in task.items" v-bind:class="item.done && 'line-through'" @dragstart="dragStart($event)" draggable="true">
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
                            placeholder="informe a descrição do item e pressione Enter"
                            v-on:keyup.enter="addItem(task.id, $event)" />
                    </div>
                </span>
                <span v-show="showShareInput">
                    <!-- Compartilhar tarefa -->
                    <div>
                        <input 
                            type="text" 
                            class="w-full"
                            placeholder="informe os emails separados por ',' e pressione Enter"
                            v-on:keyup.enter="sendSharedTask(task.id, $event)" />
                    </div>
                </span>
            </div>
            <div class="p-2 m-2" v-if="!showNewTask">
                <Icon 
                    name="plus-circle"
                    v-bind:class="'text-green-500 text-6xl'"
                    style="cursor:pointer"
                    @click="enableAddTask()" />
            </div>
            <div class="bg-white p-2 m-2 rounded-md shadow-lg" v-else>
                <!-- Nova tarefa -->
                <div>
                    <input 
                        type="text" 
                        class="w-full"
                        placeholder="Informe o título da tarefa e pressione Enter"
                        v-on:keyup.enter="addTask($event)" />
                </div>
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
        data() {
            return {
                itemCheck: false,
                userId: this.$page.props.user.id,
                showEditTask: false,
                showNewTask: false,
                showShareInput: false,
                tasks: []
            }
        },
        methods: {
            getTasks() {
                axios.get(`api/user/${this.userId}/tasks`)
                .then(response => {
                    this.tasks = response.data
                })
            },
            enableAddTask() {
                this.showNewTask = !this.showNewTask;
            },
            addTask(e) {
                let description = e.target.value
                let user_id = this.userId

                axios.post('api/tasks', { description, user_id })
                .finally(() => {
                    this.getTasks()
                    this.enableAddTask()
                })
            },
            enableTitleEdit() {
                this.showEditTask = !this.showEditTask;
            },
            editTask(id, e) {
                let description = e.target.value

                axios.put(`api/tasks/${id}`, { description })
                .finally(() => {
                    this.getTasks()
                    this.enableTitleEdit()
                })
            },
            deleteTask(id) {
                axios.delete(`api/tasks/${id}`)
                .finally(() => {
                    this.getTasks()
                })
            },
            addItem(id, event) {
                let data = {
                    description: event.target.value,
                    task_id: id,
                    done: 0
                }
                
                axios.post('api/task-items', data)
                .finally(() => {
                    this.getTasks()
                })
            },
            checkItem(e) {
                let id = e.target.value
                let checked = e.target.checked

                axios.put(`api/task-items/${id}`, {
                    done: checked
                })
                .finally(() => {
                    this.getTasks()
                    e.target.value = ""
                })
            },
            removeItem(id) {
                axios.delete(`api/task-items/${id}`)
                .finally(() => {
                    this.getTasks()
                })
            },
            enableShareInput() {
                this.showShareInput = !this.showShareInput;
            },
            sendSharedTask(id, event) {
                let emails = event.target.value

                axios.put(`api/tasks/${id}/share`, { emails })
                .finally(() => {
                    this.enableShareInput()
                })
            },
            dragStart(event) {
                event.dataTransfer.setData('id',event.target.id)
            },
            dropItem(task_id, event) {
                let itemId = event.dataTransfer.getData('id')
                
                axios.put(`api/task-items/${itemId}`, { task_id })
                .finally(() => {
                    this.getTasks()
                })
            }
        },
        mounted() {
            this.getTasks();
        }
    }
</script>