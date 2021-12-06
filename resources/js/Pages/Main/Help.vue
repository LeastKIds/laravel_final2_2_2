<template>
    <layout></layout>
    <div style="height:150px;"></div>
    <div class="hero min-h-screen bg-base-200">
        <div class="flex-col hero-content lg:flex-row-reverse">
            <img src="/image/1.png" class="max-w-sm rounded-lg shadow-2xl">
            <div class="m-3">
                <h1 class="mb-5 text-5xl font-bold">
                    내 단어장, 남 단어장, 프로필
                </h1>
                <p class="mb-5">
                    내 단어장과 남 단어장을 구성하고 있는 카드 스타일. 메인페이지의 프로필 또한 담당한다.
                </p>
                <a class="btn btn-primary"
                      href="https://tailwindcomponents.com/component/responsive-team-cards-1-dark-mode">
                    컴포넌트 바로가기</a>
            </div>
        </div>
    </div>

    <div class="hero min-h-screen bg-base-200 m-3">
        <div class="flex-col hero-content lg:flex-row-reverse">
            <img src="/image/2.png" class="max-w-sm rounded-lg shadow-2xl">
            <div>
                <h1 class="mb-5 text-5xl font-bold">
                    메인 페이지 레이아웃
                </h1>
                <p class="mb-5">
                    메인페이지의 레이아웃. 오른쪽만 따로 움직인다.
                </p>
                <a class="btn btn-primary"
                href="https://tailwindcomponents.com/component/events-timeline">컴포넌트 바로가기</a>
            </div>
        </div>
    </div>

    <div class="hero min-h-screen bg-base-200 m-3">
        <div class="flex-col hero-content lg:flex-row-reverse">
            <img src="/image/3.png" class="max-w-sm rounded-lg shadow-2xl">
            <div>
                <h1 class="mb-5 text-5xl font-bold">
                    로그인, 회원가입
                </h1>
                <p class="mb-5">
                    로그인과 회원가입을 담당하는 레이아웃
                </p>
                <a class="btn btn-primary"
                   href="https://tailwindcomponents.com/component/feedbackreview-section    ">컴포넌트 바로가기</a>
            </div>
        </div>
    </div>


</template>

<script>
import Layout from './../Layouts/Layout.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
export default {
    name: "Help",
    components: {
        Layout,
        Link,
    },
}
</script>

<style scoped>

</style>
