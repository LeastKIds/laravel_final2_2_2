<template>
    <div class="flex relative mx-auto max-w-md w-auto mt-11">
        <div class="flex relative mx-auto max-w-md w-auto mt-11">
            <input class="border-2 border-primary bg-red transition
            h-12 px-5 pr-16 rounded-md focus:outline-none w-full
            text-black text-lg " type="search" name="search"
                   placeholder="Search" v-model="search" @keyup.enter="searching"/>
            <button type="submit" class="absolute right-2 top-3 mr-4" @click="searching">
                <svg class="text-black h-6 w-6 fill-current" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve" width="512px" height="512px">
      <path d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z" />
    </svg>
            </button>


        </div>


    </div>



</template>

<script>
export default {
    name: "Search",
    data() {
        return {
            search : '',
        }
    },
    methods: {
        searching() {
            console.log(this.search)
            this.$emit('searching', this.search)
        }
    }
}
</script>

<style scoped>

</style>
