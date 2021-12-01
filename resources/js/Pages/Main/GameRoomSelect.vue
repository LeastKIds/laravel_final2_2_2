<template>
    <layout></layout>
    <section>

        <div class="w-full bg-black">
            <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-4 py-12">
                <div class="text-center pb-12">
                </div>
                <div style="text-align:center;" class="flex flex-col items-center justify-center">
                    <search @searching="searching"></search>
                    <div
                        v-if="button_set === 1 && this.game_rooms.last_page !==1"
                        class="flex relative mx-auto max-w-md w-auto mt-2 mb-5">

                        <button class="px-4 py-2 rounded-md text-sm
                                    font-medium border focus:outline-none focus:ring
                                    transition text-yellow-600 border-yellow-600 hover:text-white
                                    hover:bg-yellow-600 active:bg-yellow-700 focus:ring-yellow-300"
                                @click="select(game_rooms.prev_page_url)"
                                v-if="game_rooms.prev_page_url"  type="submit">이전</button>

                        <div v-for="i in list" :key="i" class="inline-flex">


                            <button class="px-4 py-2 rounded-md text-sm
                             font-medium border focus:outline-none focus:ring bg-yellow-50
                             transition text-yellow-600 border-yellow-600 hover:text-white
                             hover:bg-yellow-600 active:bg-yellow-700 focus:ring-yellow-300 m-1"
                                    v-if="i === game_rooms.current_page"
                                    type="submit" @click="pageSelect(i)">{{i}}</button>

                            <button class="px-4 py-2 rounded-md text-sm
                             font-medium border focus:outline-none focus:ring
                             transition text-yellow-600 border-yellow-600 hover:text-white
                             hover:bg-yellow-600 active:bg-yellow-700 focus:ring-yellow-300 m-1"
                                    v-else @click="pageSelect(i)"
                                    type="submit" >{{i}}</button>

                        </div >


                        <div class="px-4 py-2 rounded-md text-sm
                             font-medium border focus:outline-none focus:ring
                             transition text-yellow-600 border-yellow-600 hover:text-white
                             hover:bg-yellow-600 active:bg-yellow-700 focus:ring-yellow-300 m-1"
                             v-if="game_rooms.current_page + 7 <= game_rooms.last_page"
                        >...</div>


                        <button class="px-4 py-2 rounded-md text-sm font-medium border
                            focus:outline-none focus:ring transition text-yellow-600
                            border-yellow-600 hover:text-white hover:bg-yellow-600
                            active:bg-yellow-700 focus:ring-yellow-300 ml-1"
                                @click="select(game_rooms.next_page_url)"
                                v-if="game_rooms.next_page_url" type="submit">다음</button>

                    </div>


                    <div
                        v-if="button_set === 2"
                        class="flex relative mx-auto max-w-md w-auto mt-2 mb-5">

                        <button class="px-4 py-2 rounded-md text-sm
                                    font-medium border focus:outline-none focus:ring
                                    transition text-yellow-600 border-yellow-600 hover:text-white
                                    hover:bg-yellow-600 active:bg-yellow-700 focus:ring-yellow-300"
                                @click="select(game_rooms.prev_page_url)"
                                v-if="game_rooms.prev_page_url"  type="submit">이전</button>

                        <div class="px-4 py-2 rounded-md text-sm
                             font-medium border focus:outline-none focus:ring
                             transition text-yellow-600 border-yellow-600 hover:text-white
                             hover:bg-yellow-600 active:bg-yellow-700 focus:ring-yellow-300 m-1"
                        >...</div>


                        <div v-for="i in list" :key="i" class="inline-flex">


                            <button class="px-4 py-2 rounded-md text-sm
                             font-medium border focus:outline-none focus:ring bg-yellow-50
                             transition text-yellow-600 border-yellow-600 hover:text-white
                             hover:bg-yellow-600 active:bg-yellow-700 focus:ring-yellow-300 m-1"
                                    v-if="i === game_rooms.current_page"
                                    type="submit" @click="pageSelect(i)">{{i}}</button>

                            <button class="px-4 py-2 rounded-md text-sm
                             font-medium border focus:outline-none focus:ring
                             transition text-yellow-600 border-yellow-600 hover:text-white
                             hover:bg-yellow-600 active:bg-yellow-700 focus:ring-yellow-300 m-1"
                                    v-else @click="pageSelect(i)"
                                    type="submit" >{{i}}</button>

                        </div >





                        <button class="px-4 py-2 rounded-md text-sm font-medium border
                            focus:outline-none focus:ring transition text-yellow-600
                            border-yellow-600 hover:text-white hover:bg-yellow-600
                            active:bg-yellow-700 focus:ring-yellow-300 ml-1"
                                @click="select(game_rooms.next_page_url)"
                                v-if="game_rooms.next_page_url" type="submit">다음</button>

                    </div>


                    <div
                        v-if="button_set === 3"
                        class="flex relative mx-auto max-w-md w-auto mt-2 mb-5">

                        <button class="px-4 py-2 rounded-md text-sm
                                    font-medium border focus:outline-none focus:ring
                                    transition text-yellow-600 border-yellow-600 hover:text-white
                                    hover:bg-yellow-600 active:bg-yellow-700 focus:ring-yellow-300"
                                @click="select(game_rooms.prev_page_url)"
                                v-if="game_rooms.prev_page_url"  type="submit">이전</button>

                        <div class="px-4 py-2 rounded-md text-sm
                             font-medium border focus:outline-none focus:ring
                             transition text-yellow-600 border-yellow-600 hover:text-white
                             hover:bg-yellow-600 active:bg-yellow-700 focus:ring-yellow-300 m-1"

                        >...</div>


                        <div v-for="i in list" :key="i" class="inline-flex">


                            <button class="px-4 py-2 rounded-md text-sm
                             font-medium border focus:outline-none focus:ring bg-yellow-50
                             transition text-yellow-600 border-yellow-600 hover:text-white
                             hover:bg-yellow-600 active:bg-yellow-700 focus:ring-yellow-300 m-1"
                                    v-if="i === game_rooms.current_page"
                                    type="submit" @click="pageSelect(i)">{{i}}</button>

                            <button class="px-4 py-2 rounded-md text-sm
                             font-medium border focus:outline-none focus:ring
                             transition text-yellow-600 border-yellow-600 hover:text-white
                             hover:bg-yellow-600 active:bg-yellow-700 focus:ring-yellow-300 m-1"
                                    v-else @click="pageSelect(i)"
                                    type="submit" >{{i}}</button>

                        </div >


                        <div class="px-4 py-2 rounded-md text-sm
                             font-medium border focus:outline-none focus:ring
                             transition text-yellow-600 border-yellow-600 hover:text-white
                             hover:bg-yellow-600 active:bg-yellow-700 focus:ring-yellow-300 m-1"

                        >...</div>


                        <button class="px-4 py-2 rounded-md text-sm font-medium border
                            focus:outline-none focus:ring transition text-yellow-600
                            border-yellow-600 hover:text-white hover:bg-yellow-600
                            active:bg-yellow-700 focus:ring-yellow-300 ml-1"
                                @click="select(game_rooms.next_page_url)"
                                v-if="game_rooms.next_page_url" type="submit">다음</button>

                    </div>

                    <button class="p-2 pl-5 pr-5 bg-transparent border-2 border-green-500
                    text-green-500 text-lg rounded-lg hover:bg-green-500 hover:text-gray-100
                    focus:border-4 focus:border-green-300 flex relative
                    mx-auto max-w-md w-auto mt-2 mb-4" @click="f5">새로 고침</button>

                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-6">


                    <div v-for="v in game_rooms.data" :key="v.id">
                        <game-list :game="v"></game-list>
                    </div>
                </div>
            </section>
        </div>

    </section>
</template>

<script>
import {defineComponent} from "vue";
import Layout from './../Layouts/Layout.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import Search from './../Button/Search.vue'
import GameList from './../Button/GameList.vue'

import axios from 'axios'
export default {
    name: "GameRoomSelect",
    props: ['rooms'],
    components: {
        Head,
        Link,
        Layout,
        Search,
        GameList,
    },
    data() {
        return {
            game_rooms : '',
            data : '',
            list : [],
            button_set : 1,
            currentPage: 1,
            totalPages: 10,
            search_word : '',
        }
    },
    mounted() {
        // this.read_voca()
        this.game_rooms = this.rooms
        console.log('t',this.game_rooms)
        this.page(this.game_rooms)
    },
    methods : {
        select(url) {
            console.log(url)
            axios.get(url)
                .then(response => {

                    this.game_rooms=response.data
                    console.log(response)
                    this.page(this.voca)


                }).catch(err => {
                console.log(err)
            })
        },
        pageSelect(page) {
            console.log(page)
            axios.get(this.game_rooms.links[page].url)
                .then(response => {
                    console.log(response)
                    this.game_rooms=response.data
                    // console.log(response)
                    this.page(this.game_rooms)

                }).catch(err => {
                console.log(err)
            })

        },
        page(v) {
            this.list=[]
            if(v.current_page < 5) {
                this.button_set = 1
                console.log(1)
                let page = 0
                if(v.last_page <= 7)
                    page = v.last_page
                else
                    page = 7
                for (let i = 1; i <= page; i++) {
                    this.list.push(i)
                }
            }else if(v.current_page >= v.last_page - 4) {
                this.button_set = 2
                console.log(2)
                for (let i = v.last_page - 5; i<= v.last_page; i++){
                    this.list.push(i)
                }
                console.log(this.list)
            }
            else {
                this.button_set = 3
                console.log(3)
                for (let i = v.current_page -2; i <= v.current_page + 2; i ++) {
                    this.list.push(i)
                }
            }
        },
        searching(search) {
            console.log(search)
            this.search_word = search
            this.search_axios()
        },
        search_axios() {
            axios.get('/api/vocabulary/'+this.search_word)
                .then(response => {
                    this.voca = response.data
                    console.log(this.voca)
                    this.page(this.voca)
                }).catch(err => {
                console.log(err)
            })
        },
        f5() {
            axios.get('/api/game')
                .then(response => {
                    console.log(response)
                    if(response.data.success === 1)
                        this.game_rooms = response.data.rooms
                    else
                        alert('오류 발생. 조금 뒤 다시 시도해 주세요.')
                })
        }

    }
}
</script>

<style scoped>

</style>
