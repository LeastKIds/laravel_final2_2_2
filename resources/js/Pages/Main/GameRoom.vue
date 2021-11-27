<template>
    <layout></layout>
    <div style="height:50px;"></div>
    <div class="font-sans bg-grey-lighter flex flex-col min-h-screen w-full">
        <div class="flex-grow container mx-auto sm:px-4 pt-6 pb-8">
            <div class="bg-white border-t border-b sm:border-l sm:border-r sm:rounded shadow mb-6 p-3">

                    <div id="moka-w1wgf" class="items-center justify-center w-full p-8 flex flex-col">

                        <div id="moka-ix3cs" class="bg-gray-400 items-center justify-center md:w-1/2 w-full shadow-md p-5 h-auto rounded-lg blur-3 bg-opacity-50 flex flex-col col-span-12">
                            <h4 class="w-48 border-t-4 border-solid border-red-500 h-10" id="moka-uuij0">
                            </h4>
                            <h4 class="text-black    text-2xl" id="moka-8q3tt" style="font-family: Abel;">사람들 기다리는 중...</h4>
                            <h2 class="text-black   text-5xl text-center mt-2 mb-10" id="moka-cqg7a" style="font-family: &quot;Archivo Black&quot;;">함께 풀어요!</h2>
<!--                            <button value="button" class="hover:text-gray-300 bg-yellow-800 text-white hover:bg-black w-56 p-4 text-2xl font-bold" id="moka-8pwrq" style="font-family: Barlow;">시작</button>-->
                            <div class="inline-flex">
                                <button class="px-4 py-2 rounded-md text-sm font-medium border focus:outline-none focus:ring transition
                             text-green-600 border-green-600 hover:text-white hover:bg-green-600 active:bg-green-700
                             focus:ring-green-300 inline-flex m-2" type="submit">시작</button>
                                <button class="px-4 py-2 rounded-md text-sm font-medium border
                            focus:outline-none focus:ring transition text-red-600 border-red-600
                            hover:text-white hover:bg-red-600 active:bg-red-700 focus:ring-red-300
                            inline-flex m-2" type="submit" @click="room_out">나가기</button>
                            </div>


                        </div>
                    </div>

                <div class="flex flex-col items-center justify-center">
                    <div class="">

                        <div class="items-center justify-center flex flex-col
                        inline-flex grid grid-cols-4 gap-4" >
                            <div class="grid grid-cols-1" v-for="(player, index) in players" :key="index">
                                <div class="bubble text-white w-40 h-9 inline-block" v-if="chat[index]">
                                    <h3 class="m-1 font-black">{{this.chat_log[index]}}</h3>
                                </div>
                                <div class="bubble2 h-9" v-if="chat[index]===false">
                                </div>
                                <div class=" card text-center shadow-2xl bg-gray-500 inline-flex m-1 inline-block">
                                    <div>
                                        <figure class="px-10 pt-6 z-0">
                                            <img class="object-center object-cover rounded-full h-20 w-20 z-" :src="player.user.profile_photo_url" alt="photo">
                                        </figure>
                                        <div class="card-body z-0">
                                            <h2 class="card-title truncate">{{player.user.name}}</h2>
                                            <p class="text-center truncate">{{player.user.email}}</p>
                                            <div class="form-control mt-2">
                                                <input type="text" placeholder="엔터눌러" class="input input-info input-bordered"
                                                       v-model="this.chat_input_log[index]" @keypress.enter="sendMessage(index)"
                                                        v-if="$page.props.user.id === player.user.id">
                                                <input type="text" placeholder="엔터눌러" class="input input-info input-bordered invisible"
                                                       v-model="this.chat_input_log[index]" @keypress.enter="sendMessage(index)"
                                                       v-if="$page.props.user.id !== player.user.id">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>




                    </div>

                </div>



            </div>



        </div>

    </div>
</template>

<script>
import Layout from './../Layouts/Layout.vue';

export default {
    name: "GameRoom",
    components: {
        Layout,
    },
    props: ['users', 'room']
    ,
    data() {
        return {
            players : [],
            room_info:'',
            chat : [false,false,false,false],
            chat_log : ['','','',''],
            chat_input_log : ['','','',''],
            chat_time_check : ['','','',''],
        }
    },
    mounted() {
            this.players = this.users
            this.player_list()
        }
    ,
    created() {
        this.room_info = this.room
        // console.log('room.'+this.room_info.id)
        // console.log(this.room_info)
        let vm = this
        window.Echo.private('room.'+this.room_info.id)
            .listen('MessageSent', e => {
                console.log(e)

                if(e.check === 1) {
                    e.room_messages.forEach( function (value, index, array) {
                        if(value.message !== null) {
                            // console.log(index)
                            vm.chatting(index, value.message)
                        }

                    })
                }else if(e.check===3) {
                    alert('방장이 방을 나갔습니다.')
                    location.href='/';
                }
                else{
                    vm.player_list()
                }


            })
    },
    methods: {
        chatClick() {
            console.log('まさか')
            return false
        },
        sendMessage(index) {
            // clearTimeout(this.chat_time_check.n1)
            // this.chat_log.n1 = this.chat_input_log.n1
            // this.chat_input_log.n1 = ''
            // // console.log(this.chat_log.n1)
            // this.chat = true
            // const vm =this
            // this.chat_time_check.n1 = setTimeout(function() {
            //     vm.chat=false
            // }, 3000)
            this.chat_log[index] = this.chat_input_log[index]
            this.chat_input_log[index] = ''
            axios.post('/api/game/messages/' + this.room_info.id, {'message' : this.chat_log[index]})
                .then(response => {
                    console.log(response)

                }).catch(err => {
                    console.log(err)
            })
        },
        chatting(index, message) {
            clearTimeout(this.chat_time_check[index])
            this.chat[index] = true
            this.chat_log[index] = message
            const vm = this
            // console.log('t')
            this.chat_time_check[index] = setTimeout(function() {
                vm.chat[index] = false
            },3000)
        },
        player_list() {
            axios.get('/api/game/member/'+this.room_info.id)
                .then(response => {
                    console.log(response)
                    if(response.data.success === 1) {
                        this.players = response.data.users
                    }
                }).catch(err => {
                    console.log(err)
            })
        },
        room_out() {
            axios.delete('/api/game/delete/'+this.room_info.id)
                .then(response => {
                    console.log(response)
                    if(response.data.success === 1) {
                        window.Echo.leave('room.'+this.room_info.id)
                        location.href='/';
                    }else {
                        alert('오류발생. 잠시 후에 다시 시도해 주세요.')
                    }
                }).catch(err => {
                    console.log(err)
            })
        }
    },
}
</script>

<style scoped>

.bubble{
    /*width: 230px;*/
    /*height: 50px;*/
    text-align: center;
    background: #808080;
    padding: 5px;
    margin: 13px auto;
    position: relative;
    border-radius:10px;
}
.bubble:before
{
    content: "";
    display: block;
    width: 0;
    border-width:15px 15px 0px 15px ;
    border-color:#808080 transparent;
    border-style:solid;
    position: absolute;
    bottom:-15px;
    right: 50%;
    transform: translateX(50%)
}

.bubble2{
    /*width: 230px;*/
    /*height: 50px;*/
    text-align: center;
    /*background: #808080;*/
    padding: 5px;
    margin: 13px auto;
    position: relative;
    border-radius:10px;
}
.bubble2:before
{
    /*content: "";*/
    display: block;
    width: 0;
    border-width:15px 15px 0px 15px ;
    /*border-color:#808080 transparent;*/
    border-style:solid;
    position: absolute;
    bottom:-15px;
    right: 50%;
    transform: translateX(50%)
}
</style>
