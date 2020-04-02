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
            room: {
                type: Object,
                required: true,
            },
        },

        mounted() {

        }
    }
</script>
