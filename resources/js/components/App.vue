<template>
    <div class="app">
        Hi {{ user.name }}
    </div>
</template>

<script>
    export default {

        props: {
            user: {
                type: Object,
                required: true,
            },
        },

        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
