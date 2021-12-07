<template>
    <div>
        <layout></layout>
        <div style="height:100px;">
        </div>

        <div style="text-align:center;" class="flex flex-col items-center justify-center text-gray-700">
            <div class="max-w-md py-4 px-8 bg-white shadow-lg rounded-lg my-20">
                <div class="relative w-full mb-3 mt-8">
                    <label class="block uppercase text-blueGray-600
                    text-xs font-bold mb-2" for="full-name">단어장 제목</label>

                    <input type="text" class="bg-gray-300 border-0 px-3 py-3 placeholder-blueGray-300
                    text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none
                    focus:ring w-full ease-linear transition-all duration-150" readonly
                           placeholder="단어장 제목" v-model="update_voca.title">
                </div>

                <div class="relative w-full mb-3">
                    <label class="block uppercase text-blueGray-600
                    text-xs font-bold mb-2" for="message">설명</label>
                    <textarea rows="4" cols="80" class="bg-gray-300 border-0 px-3 py-3 placeholder-blueGray-300
                    text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none
                    focus:ring w-full" placeholder="설명 써줘요" v-model="update_voca.message" readonly></textarea>
                </div>


            </div>





        </div>
        <div style="text-align:center;" v-for="(word,index) in words_x" :key="word.id">
            <input type="text" placeholder="한자" class="text-center mb-2 bg-gray-100 p-2
            rounded-lg border-2 border-indigo-500 shadow-md focus:outline-none text-black
            focus:border-indigo-600 m-1" readonly :value="word.kannzi" />
            <input type="text" placeholder="히라가나" class="text-center mb-2 bg-gray-100
            p-2 rounded-lg border-2 border-indigo-500 shadow-md focus:outline-none  text-black
            focus:border-indigo-600 m-1" readonly :value="word.hiragana" />
            <input type="text" placeholder="한글" class="text-center mb-2 bg-gray-100
             p-2 rounded-lg border-2 border-indigo-500 shadow-md focus:outline-none text-black
              focus:border-indigo-600 m-1" readonly :value="word.korean" />




        </div>










    </div>

    <div class="w-full  flex justify-center items-center">
        <button
            data-modal-toggle="example2"
            data-modal-action="open"
            class="bg-purple-600 font-semibold text-white p-2 w-32 rounded-full hover:bg-purple-700 focus:outline-none focus:ring shadow-lg hover:shadow-none transition-all duration-300 m-8"
            @click="game_start_button"
        >
            게임 시작
        </button>
    </div>


    <jet-dialog-modal :show="start_game" @close="start_game = false">
        <template #title>
            <p class="text-black">게임 생성</p>
        </template>

        <template #content>
            <div class="relative w-full mb-3 mt-8">
                <label class="block uppercase text-blueGray-600 text-black
                    text-xs font-bold mb-2" for="full-name">게임 제목</label>
                <span class="flex items-center font-medium tracking-wide text-red-500 text-xs
                mt-1 ml-1" v-if="game.message">{{game.message}}</span>
                <input type="text" class="bg-gray-300 border-0 px-3 py-3 placeholder-blueGray-300
                    text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none text-black
                    focus:ring w-full ease-linear transition-all duration-150"
                       placeholder="게임 제목" v-model="game.title">

            </div>

            <div class="justify-center">
                <button class="bg-yellow-600 text-white
                active:bg-blueGray-600 text-sm font-bold uppercase
                px-6 py-3 rounded shadow hover:shadow-lg outline-none
                focus:outline-none mr-1 mb-1 ease-linear transition-all
                duration-150 text-left mr-5" type="button" @click="game_start_button_start">
                    시작
                </button>
            </div>


        </template>


    </jet-dialog-modal>



    <div style="height:100px;">
    </div>
</template>

<script>
import Layout from './../Layouts/Layout.vue';
import axios from 'axios'
import JetDialogModal from '@/Jetstream/DialogModal.vue'

export default {
    name: "CreateWords",
    components: {
        Layout,
        JetDialogModal,
    },
    props: ['voca','words'],
    data() {
        return{
            voca_x : '',
            words_x : '',
            error : {
                title : '',
                message : '',
            },
            update_voca : {
                title : '',
                message : '',
            },
            check : true,
            openModal : false,
            word : {
                kannzi : '',
                hiragana : '',
                korean : '',
            },
            edit_button : [],
            word_error : [],
            first_page : false,
            start_game : false,
            game : {
                title : '',
                message : '',
            }
        }
    },
    mounted () {
        console.log(this.words)
        this.voca_x = this.voca
        this.words_x = this.words
        this.update_voca.title = this.voca_x.title


    },
    methods : {
        game_start_button() {
            if(this.words_x.length === 0) {
                alert('최소한 하나의 단어는 있어야 합니다.')
                return
            }
            this.start_game = true
        },
        game_start_button_start() {
            if(this.game.title ===''){
                this.game.message='꼭 필요해요!'
                return
            }

            console.log(this.voca_x.id)

            axios.post('/api/game/store', {'name' : this.game.title, 'voca_id' : this.voca_x.id})
                .then(response => {
                    console.log(response)
                    if(response.data.success === 1)
                        location.href="/game/" + response.data.room.id;
                    else if(response.data.success === 0)
                        alert('이미 진행 중인 게임이 있습니다. 그 게임에 들어가려면 [참가참가]를 눌러주세요')

                }).catch(err => {
                console.log(err)
            })


        }
    }
}
</script>

<style scoped>

</style>
