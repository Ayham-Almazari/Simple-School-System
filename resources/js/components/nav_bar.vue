<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-dark ">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <router-link :to="{ name : 'home' }" class="nav-link text-white">Home</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{ name : 'TeacherIndex' }"  class="nav-link text-white"> Classrooms </router-link>
                    </li>
                    <li class="nav-item" v-if="!isLogged">
                        <router-link :to="{ name : 'login' }"  class="nav-link text-white"> Log In </router-link>
                    </li>
                    <li class="nav-item" v-if="!isLogged">
                        <router-link :to="{ name : 'register' }"  class="nav-link text-white"> Sign Up </router-link>
                    </li>
                    <li class="nav-item" v-if="isLogged">
                        <button @click="logout"  class="bg-dark nav-link text-white"> LOGOUT </button>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="text-white nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Dropdown
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li>
                </ul>
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>
</template>

<script>
import {mapGetters} from "vuex"
    export default {
        computed:{
          ...mapGetters({
                  isLogged:"auth/check"
              })
        },
        methods:{
            logout(){
                this.$store.dispatch("auth/logout")
                this.$router.push({name:"home"})
            }
        }
    }

</script>
