<template>
    <div class="w-full bg-gray-900 rounded-lg sahdow-lg p-12 flex flex-col justify-center items-center border-double border-4 border-light-blue-500">
        <div class="text-center">
            <p class="text-xl text-white font-bold mb-2  w-48 truncate">{{game.name}}</p>
            <p class="text-base text-gray-400 font-normal w-48 truncate">인원수 : {{game.room_messages.length}}/4</p>


            <Link class="px-4 py-2 rounded-md text-sm font-medium border
            focus:outline-none focus:ring transition text-blue-600 border-blue-600
            hover:text-white hover:bg-blue-600 active:bg-blue-700 focus:ring-blue-300 m-3"
                    type="submit" :href="'/game/'+game.id" v-if="game.room_messages.length < 4">입장</Link>

            <button class="px-4 py-2  rounded-md text-sm font-medium border
            focus:outline-none focus:ring transition text-red-600 border-red-600
            hover:text-white hover:bg-red-600 active:bg-red-700 focus:ring-red-300 m-3" disabled
                  v-if="game.room_messages.length >= 4">인원 초과</button>
        </div>

    </div>
</template>

<script>
import JetDialogModal from '@/Jetstream/DialogModal.vue'
import axios from 'axios'
import { Head, Link } from '@inertiajs/inertia-vue3';

export default {
    name: "GameList",
    components : {
        JetDialogModal,
        // Toggle,
        Link,
    },
    props : ['game'],
    mounted () {
        console.log('t',this.game)
    },
    data() {
        return {

        }
    },
    methods : {
    }
}
</script>

<style scoped>
input:checked ~ .dot {
    transform: translateX(100%);
    background-color: #48bb78;
}
</style>
