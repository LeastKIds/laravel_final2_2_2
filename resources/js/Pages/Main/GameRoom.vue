<template>
    <layout></layout>
    <div style="height:50px;"></div>
    <div class="font-sans bg-grey-lighter flex flex-col min-h-screen w-full">
        <div class="flex-grow container mx-auto sm:px-4 pt-6 pb-8">
            <div class="bg-white border-t border-b sm:border-l sm:border-r sm:rounded shadow mb-6 p-3">

                    <div id="moka-w1wgf" class="items-center justify-center w-full p-8 flex flex-col">

                        <div id="moka-ix3cs" class="bg-gray-400 items-center
                        justify-center md:w-1/2 w-full shadow-md p-5 h-auto rounded-lg
                        blur-3 bg-opacity-50 flex flex-col col-span-12" v-if="start===false">
                            <h4 class="w-48 border-t-4 border-solid border-red-500 h-10" id="moka-uuij0">
                            </h4>
                            <h4 class="text-black    text-2xl" id="moka-8q3tt" style="font-family: Abel;">사람들 기다리는 중...</h4>
                            <h2 class="text-black   text-5xl text-center mt-2 mb-10" id="moka-cqg7a" style="font-family: &quot;Archivo Black&quot;;">함께 풀어요!</h2>
<!--                            <button value="button" class="hover:text-gray-300 bg-yellow-800 text-white hover:bg-black w-56 p-4 text-2xl font-bold" id="moka-8pwrq" style="font-family: Barlow;">시작</button>-->
                            <div class="inline-flex">
                                <button class="px-4 py-2 rounded-md text-sm font-medium border focus:outline-none focus:ring transition
                             text-green-600 border-green-600 hover:text-white hover:bg-green-600 active:bg-green-700
                             focus:ring-green-300 inline-flex m-2" type="submit"
                                       v-if="parseInt(room_info.admin) === $page.props.user.id" @click="game_start">시작</button>
                                <button class="px-4 py-2 rounded-md text-sm font-medium border
                            focus:outline-none focus:ring transition text-red-600 border-red-600
                            hover:text-white hover:bg-red-600 active:bg-red-700 focus:ring-red-300
                            inline-flex m-2" type="submit" @click="room_out">나가기</button>
                            </div>
                        </div>

                        <div class="bg-gray-400 items-center
                        justify-center md:w-1/2 w-full shadow-md p-5 h-auto rounded-lg
                        blur-3 bg-opacity-50 flex flex-col col-span-12" v-if="start">
                            <h4 class="w-48 border-t-4 border-solid border-red-500 h-10" >
                            </h4>
                            <h4 class="text-black    text-2xl" style="font-family: Abel;">{{quiz_setting.answer_type}}</h4>
                            <h2 class="text-black   text-5xl text-center mt-2 mb-10"  style="font-family: &quot;Archivo Black&quot;;">{{quiz_setting.q}}</h2>
                            <!--                            <button value="button" class="hover:text-gray-300 bg-yellow-800 text-white hover:bg-black w-56 p-4 text-2xl font-bold" id="moka-8pwrq" style="font-family: Barlow;">시작</button>-->
                            <div class="inline-flex">
                                <button class="px-4 py-2 rounded-md text-sm font-medium border focus:outline-none focus:ring transition
                             text-green-600 border-green-600 hover:text-white hover:bg-green-600 active:bg-green-700
                             focus:ring-green-300 inline-flex m-2" v-if="pass"
                                        type="submit" @click="game_start">{{timer}}</button>
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
import Swal from 'sweetalert2'

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
            start : false,

            quiz_setting : {
                answer_type : '',
                q : '',
            },
            pass : true,
            timer_setting : '',
            timer : 0,
            user : '',


        }
    },
    mounted() {


        }
    ,
    created() {
        this.room_info = this.room
        axios.get('/api/auth')
            .then(response => {
                if(response.data.success === 1)
                    this.user = response.data.user
                else
                    alert('새로고침 부탁해요')
            })



        // console.log('room.'+this.room_info.id)
        // console.log(this.room_info)
        if(this.room_info.start === 1)
        {
            clearInterval(this.timer_setting)
            this.start=true
            axios.post('/api/game/select_second',
                {'quiz_number' : this.room_info.quiz_number, 'room_id' : this.room_info.id})
                .then(response => {
                    // console.log(response)
                    this.quiz_setting.answer_type = response.data.quiz.answer_type + '로 답하세요!'
                    this.quiz_setting.q = response.data.quiz.quiz
                    this.timer = response.data.quiz.timer
                    console.log(response)
                    console.log(this.timer)
                    console.log('ttttttt')
                    this.timer = this.timer + 7 - parseInt(Date.now()/1000)
                    console.log(this.timer)
                    if(this.timer <=0)
                        this.timer = 0
                    const vm = this

                    this.timer_setting = setInterval( function () {
                        if(vm.timer <=0) {
                            vm.timer = 0
                            if(parseInt(vm.room_info.admin) ===  vm.user.id) {
                                axios.post('/api/game/wrong', {'room_id' : vm.room_info.id})
                                    .then(response => {
                                        // console.log(response)
                                    }).catch(err => {
                                    console.log(err)
                                })
                            }

                            clearInterval(vm.timer_setting)
                        }else
                            vm.timer = vm.timer -1
                    }, 1000)
                }).catch(err => {
                console.log(err)
            })
        }

        this.member_check()
        this.players = this.users
        this.player_list()

        let vm = this
        window.Echo.private('room.'+this.room_info.id)
            .listen('MessageSent', e => {
                // console.log(e)

                if(e.check === 1) {
                    vm.room_info = e.room
                    e.room_messages.forEach( function (value, index, array) {
                        if(value.message !== null) {
                            console.log(value)
                            vm.chatting(index, value.message)
                            if(vm.room_info.start===1 && value.user_id === vm.user.id)
                                vm.send_answer(value.message, vm)
                        }

                    })
                }else if(e.check===3) {
                    vm.room_info = e.room
                    // console.log('check 3')
                    alert('방장이 방을 나갔습니다.')
                    location.href='/game/list';
                }else if(e.check===2) {
                    clearInterval(vm.timer_setting)
                    vm.room_info = e.room
                    vm.start=true
                    axios.post('/api/game/select',
                        {'quiz_number' : vm.room_info.quiz_number, 'room_id' : vm.room_info.id})
                    .then(response => {
                        vm.quiz_setting.answer_type = response.data.quiz.answer_type + '로 답하세요!'
                        vm.quiz_setting.q = response.data.quiz.quiz
                        vm.timer = response.data.quiz.timer
                        vm.timer = vm.timer + 7 - parseInt(Date.now()/1000)

                        vm.timer_setting = setInterval( function () {
                            if(vm.timer <=0) {
                                vm.timer = 0
                                if(parseInt(vm.room_info.admin) === vm.user.id) {
                                    axios.post('/api/game/wrong', {'room_id' : vm.room_info.id})
                                        .then(response => {

                                        }).catch(err => {
                                        console.log(err)
                                    })
                                }

                                clearInterval(vm.timer_setting)
                            } else
                                vm.timer = vm.timer -1
                        }, 1000)

                    }).catch(err => {
                        console.log(err)
                    })
                }else if(e.check===22) {
                    clearInterval(vm.timer_setting)
                    vm.room_info = e.room
                    // console.log(e)
                    vm.pass=false
                    vm.quiz_setting.answer_type = '정답자!!'
                    vm.quiz_setting.q = e.room_messages.user.name
                    // console.log(e.room_messages.answer)
                    const answer = e.room_messages.answer
                    // console.log(name)
                    vm.answer_message(vm,  answer, vm.quiz_setting.q)
                    setTimeout(function() {
                        vm.next_quiz(vm)
                    },2050)

                }else if(e.check===23) {
                    console.log(e)
                    clearInterval(vm.timer_setting)
                    vm.quiz_setting.answer_type = '정답자!!'
                    vm.quiz_setting.q = e.room_messages.user.name
                    const answer = e.room_messages.answer
                    vm.answer_message(vm,  answer, vm.quiz_setting.q)
                    setTimeout(function() {
                        vm.quiz_setting.answer_type = '우승자!!!'
                        vm.quiz_setting.q = e.room_messages.winner.user.name
                        setTimeout(function() {
                            vm.start=false
                            vm.pass=true
                        },5000)
                    },2050)

                }
                else if(e.check===24) {
                    // console.log(e)
                    vm.wrong_message(vm, e.room_messages.wrong)
                    setTimeout(function() {
                        vm.next_quiz(vm)
                    })
                }
                else if(e.check===241) {
                    clearInterval(vm.timer_setting)
                    vm.wrong_message(vm, e.room_messages.wrong)
                    setTimeout(function () {
                        vm.quiz_setting.answer_type = '우승자!!!'
                        vm.quiz_setting.q = e.room_messages.winner.user.name
                        setTimeout(function() {
                            vm.start=false
                            vm.pass=true
                        },5000)
                    },2000)
                }
                else{
                    vm.room_info = e.room
                    vm.player_list()
                }


            })
    },
    methods: {
        sendMessage(index) {
            this.chat_log[index] = this.chat_input_log[index]
            this.chat_input_log[index] = ''
            console.log('t1')
            axios.post('/api/game/messages/' + this.room_info.id, {'message' : this.chat_log[index]})
                .then(response => {
                    // console.log(response)

                }).catch(err => {
                    console.log(err)
            })

            // this.send_answer(this.chat_log[index]);


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
                    // console.log(response)
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
                    // console.log(response)
                    if(response.data.success === 1) {
                        window.Echo.leave('room.'+this.room_info.id)
                        location.href='/';
                    }else {
                        alert('오류발생. 잠시 후에 다시 시도해 주세요.')
                    }
                }).catch(err => {
                    console.log(err)
            })
        },
        member_check() {
            axios.post('/api/game/member/' + this.room_info.id)
                .then(response => {
                    // console.log(response)
                    if(response.data.success === 0) {
                        alert('인원초과!')
                        window.history.back()
                    }
                }).catch(err => {
                    console.log(err)
            })
        },
        game_start() {
            axios.post('/api/game/start/' + this.room_info.id)
                .then(response => {
                    // console.log(response)
                    if(response.data.success === 1) {
                        this.start=true
                    }
                    else {
                        alert('당신 방장이 아니잖아!')
                    }
                }).catch(err => {
                    console.log(err)
            })
        },
        send_answer(value, vm) {
            console.log('t2')
            axios.post('/api/game/answer',
                {'room_id' : vm.room_info.id, 'answer' : value})
            .then(response => {
                // console.log(response)
            }).catch(err => {
                console.log(err)
            })
        },
        next_quiz(vm) {
            clearInterval(vm.timer_setting)
            axios.post('/api/game/select',
                {'quiz_number' : vm.room_info.quiz_number, 'room_id' : vm.room_info.id})
                .then(response => {
                    // console.log(response)
                    vm.quiz_setting.answer_type = response.data.quiz.answer_type + '로 답하세요!'
                    vm.quiz_setting.q = response.data.quiz.quiz
                    vm.pass=true
                    vm.timer = response.data.quiz.timer
                    // console.log(vm.timer)
                    vm.timer = vm.timer + 7 - parseInt(Date.now()/1000)
                    vm.timer_setting = setInterval( function () {
                        if(vm.timer <=0) {
                            vm.timer = 0
                            // console.log(vm.user.id)
                            // console.log(parseInt(vm.room_info.admin))
                            if(parseInt(vm.room_info.admin) === vm.user.id) {
                                axios.post('/api/game/wrong', {'room_id' : vm.room_info.id})
                                    .then(response => {
                                        // console.log(response)
                                    }).catch(err => {
                                    console.log(err)
                                })
                            }

                            clearInterval(vm.timer_setting)
                        } else
                            vm.timer = vm.timer -1
                    }, 1000)
                }).catch(err => {
                console.log(err)
            })
        },
        answer_message(vm, answer, user) {
            console.log(answer)
            let timerInterval
            Swal.fire({
                title: '정답자 : ' + user,
                html: '정답 : ' + answer,
                timer: 2000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading()
                    const b = Swal.getHtmlContainer().querySelector('b')
                    timerInterval = setInterval(() => {
                        // b.textContent = Swal.getTimerLeft()
                    }, 100)
                },
                willClose: () => {
                    clearInterval(timerInterval)
                    // vm.next_quiz(vm)
                }
            }).then((result) => {
                /* Read more about handling dismissals below */
                // if (result.dismiss === Swal.DismissReason.timer) {
                //     console.log('I was closed by the timer')
                // }
            })
        },
        wrong_axios(vm) {
            axios.post('/api/game/wrong',{'room_id' : vm.room_info.id})
                .then(response => {
                    if(response.success !== 1)
                        alert('오류발생!')
                }).catch(err => {
                    console.log(err)
            })
        },
        wrong_message(vm, answer) {
            let timerInterval
            Swal.fire({
                title: '전원 오답!',
                html: '정답 : ' + answer,
                timer: 2000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading()
                    const b = Swal.getHtmlContainer().querySelector('b')
                    timerInterval = setInterval(() => {
                        // b.textContent = Swal.getTimerLeft()
                    }, 100)
                },
                willClose: () => {
                    clearInterval(timerInterval)
                    // vm.next_quiz(vm)
                }
            }).then((result) => {
                /* Read more about handling dismissals below */
                // if (result.dismiss === Swal.DismissReason.timer) {
                //     console.log('I was closed by the timer')
                // }
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
