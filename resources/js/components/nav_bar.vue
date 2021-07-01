<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    {{check === false?"isnotloggeed":"isloggeed"}}
                    <router-link :to="{ name : 'home' }">Home</router-link>
                    <a v-if="check === false">
                        <router-link :to="{ name : 'login' }"> Log In </router-link>
                    </a>
                    <a v-if="check === false">
                        <router-link :to="{ name : 'register' }"> Sign Up </router-link>
                    </a>
                    <router-link :to="{ name : 'TeacherIndex' }"> TeacherIndex </router-link>

                    <div class="card-body">
                        I'm an example component.
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from "vuex"
    export default {
        computed:{
            check(state) {
                return this.$store.getters['auth/check'];
            }
        }


    }

</script>
