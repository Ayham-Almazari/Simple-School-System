<template>
    <div class="container __center">
        <div class="row">
            <div class="login-container hvr-underline-from-center col-lg-6 col-md-6" >
                <h1 class="text-center m-auto " ><i>Sign In</i></h1>
<!--                <i id="loading-icon" class="fas fa-spinner faa-spin animated faa-fast"></i>-->
                <form  @submit.prevent="login" class="padding-right" id="loginForm" @keydown="form.onKeydown($event)">
                    <AlertError :form="form" message="Invalid Email Or password ." class="text-center"/>
                    <div class="row mb-2">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input v-model="form.email" type="text" name="email" class="form-control" id="inputEmail3" placeholder="Email">
                            <i class="fas fa-user"></i>
                            <HasError :form="form" field="email" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                            <input v-model="form.password" type="password" name="password" class="form-control" id="inputPassword3" placeholder="Password" autocomplete="1">
                            <i class="fas fa-lock"></i>
                            <HasError :form="form" field="password" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-10 offset-sm-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="gridCheck1" >
                                <label class="form-check-label" for="gridCheck1">
                                    Remember Me
                                </label>
                                <a href="#" class="link-danger col-md-10 offset-md-2" style="margin-left: 19%">forget your password <i class="fas fa-question-circle"></i></a>
                            </div>
                        </div>
                    </div>
                    <Button :form="form" class="btn btn-primary mt-4" id="admin_login">
                        Log In
                    </Button>
                </form>
            </div>
            <div class="col-lg-6 col-md-6 hvr-bubble-float-left plain-login d-none d-sm-block">
                <p>
                    <i>Welcome to Tally Bills Company .
                        You can now log in to join the work. This is the employee portal.</i>
                </p>
                <p>
                    To return to the <u> home page</u> , you can click here .<br>
                    <router-link :to="{ name : 'register' }"
                                 class="btn btn-primary btn-to-home mt-2">
                        Sign Up</router-link>
                </p>
            </div>
        </div>
    </div>
</template>

<script>
import Form from "vform"
import {
    Button,
    HasError,
    AlertError,
    AlertSuccess
} from 'vform/src/components/bootstrap5'
export default {
    components: {
        Button, HasError, AlertError,AlertSuccess
    },
    data: () => ({
        form: new Form({
            email : "",
            password: "",
            remember : false
        })
    }),
    methods: {
         login () {
              this.form.post('/api/v1/auth/teacher/login').then(({data})=>{
                this.$store.dispatch('auth/saveToken',{
                    token: data._token,
                    remember:this.remember
                })
                this.$store.dispatch('auth/fetchUser')
                this.$router.push({name: 'TeacherIndex'})
            }).catch((errors)=>{
                console.log(errors.response.data)
              })
        }
    }
}

</script>

