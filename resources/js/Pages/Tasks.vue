<template>
    <div>
        <div class="grid grid-cols-1">
            <span class="font-bold" v-show="showShareInput">
                <!-- Compartilhar tarefa -->
                <div class="bg-white p-2 m-2 rounded-md shadow-lg">
                    Compartilhar lista
                    <input 
                        type="text" 
                        class="w-full"
                        placeholder="informe os emails separados por ',' e pressione Enter"
                        v-on:keyup.enter="sendSharedTask($event)" />
                </div>
            </span>
            <span class="font-bold" v-show="showEditTask">
                <div class="bg-white p-2 m-2 rounded-md shadow-lg">
                    Editar o título da lista
                    <input 
                        type="text" 
                        class="w-full" 
                        placeholder="informe o novo título da lista e pressione Enter"
                        v-on:keyup.enter="editTask($event)" />
                </div>
            </span>
            <span v-show="!showShareInput && !showEditTask">
                <div class="bg-white p-2 m-2 rounded-md shadow-lg" v-for="(task, taskIndex) in tasks" @dragover.prevent @drop="dropItem(task.id, $event)">
                    <span class="font-bold">
                        {{ task.description }}
                        <Icon 
                            name="share" 
                            v-bind:class="'text-green-500'" 
                            style="cursor:pointer" 
                            @click="enableShareInput(task.id)" />

                        <Icon 
                            name="edit" 
                            v-bind:class="'text-yellow-500'" 
                            style="cursor:pointer" 
                            @click="enableTitleEdit(task.id)" />

                        <Icon 
                            name="trash" 
                            v-bind:class="'text-red-500'" 
                            style="cursor:pointer" 
                            @click="deleteTask(task.id)" />
                    </span>
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
            </span>
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
                tasks: [],
                targetId: null
            }
        },
        methods: {
            getTasks() {
                axios.get(`user/${this.userId}/tasks`)
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

                axios.post('tasks', { description, user_id })
                .finally(() => {
                    this.getTasks()
                    this.enableAddTask()
                })
            },
            enableTitleEdit(id) {
                this.targetId = id
                this.showEditTask = !this.showEditTask;

                console.log(this.targetId, this.showEditTask)
            },
            editTask(e) {
                let description = e.target.value

                axios.put(`tasks/${this.targetId}`, { description })
                .finally(() => {
                    this.getTasks()
                    this.enableTitleEdit(null)
                })
            },
            deleteTask(id) {
                axios.delete(`tasks/${id}`)
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
                
                axios.post('task-items', data)
                .finally(() => {
                    this.getTasks()
                })
            },
            checkItem(e) {
                let id = e.target.value
                let checked = e.target.checked

                axios.put(`task-items/${id}`, {
                    done: checked
                })
                .finally(() => {
                    this.getTasks()
                    e.target.value = ""
                })
            },
            removeItem(id) {
                axios.delete(`task-items/${id}`)
                .finally(() => {
                    this.getTasks()
                })
            },
            enableShareInput(id) {
                this.targetId = id
                this.showShareInput = !this.showShareInput;
            },
            sendSharedTask(event) {
                let emails = event.target.value

                axios.put(`tasks/${this.targetId}/share`, { emails })
                .finally(() => {
                    this.enableShareInput(null)
                })
            },
            dragStart(event) {
                event.dataTransfer.setData('id',event.target.id)
            },
            dropItem(task_id, event) {
                let itemId = event.dataTransfer.getData('id')
                
                axios.put(`task-items/${itemId}`, { task_id })
                .finally(() => {
                    this.getTasks()
                })
            },
            dropItemOut(event) {
                console.log(event)
            }
        },
        mounted() {
            this.getTasks();
        }
    }
</script>