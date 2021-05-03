<template>
    <div class="grid grid-cols-3">
        <div class="bg-white p-2 m-2 rounded-md shadow-lg" v-for="(task, taskIndex) in tasks">
            <span class="font-bold">{{ task.description }}</span>
            <p class="font-thin" v-for="(item, itemIndex) in task.items" v-bind:class="item.done && 'line-through'">
                <input 
                    type="checkbox" 
                    :value="item.id" 
                    @change="checkItem($event)" 
                    :checked="item.done"/> {{ item.description }}
            </p>
            <div>
                <input type="text" class="w-full" />
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            tasks: {
                type: Array,
                required: false,
                default: []
            }
        },
        data() {
            return {
                itemCheck: false
            }
        },
        methods: {
            checkItem(e) {
                let id = e.target.value
                let checked = e.target.checked

                axios.put(`api/task-items/${id}`, {
                    done: checked
                })
            }
        }
    }
</script>