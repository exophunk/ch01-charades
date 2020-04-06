<template>
    <div class="header">
        <h1>{{ room.name }}</h1>
        {{ cycle }}
    </div>
</template>

<script>

    import { mapState } from 'vuex';


    export default {
        computed: {
            ...mapState(['room']),

            cycle() {
                return this.room.cycle > 0 ? `Runde ${this.room.cycle}` : 'Vorbereitung';
            },
        },
    }
</script>
