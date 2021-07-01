<template>
 <div class="container bg-dark text-white">
     <h1>dashboard</h1>
     <div>
         {{ user.name }}
     </div>
 </div>
</template>

<script>
import {mapGetters} from "vuex"
export default {
    computed:mapGetters({
        user:'auth/user'
    })
}
</script>

<style scoped>
h1{
    border-radius: 0;
}
</style>
