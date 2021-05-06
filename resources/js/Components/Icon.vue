<template>
    <font-awesome-icon :icon="name" data-fa-transform="shrink-8" style="margin-right: 5px" />
</template>

<script>
    import { library } from '@fortawesome/fontawesome-svg-core'
    import { 
        faMinus,
        faMinusCircle,
        faPlus,
        faEdit,
        faPlusCircle,
        faTrash,
        faShare
    } from '@fortawesome/free-solid-svg-icons'
    import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
    library.add(
        faMinus,
        faMinusCircle,
        faPlus,
        faEdit,
        faPlusCircle,
        faTrash,faShare
    )
    
    export default {
        components: {
            FontAwesomeIcon
        },
        props: {
            name: {
                type: String,
                default: ''
            }
        }
    }
</script>