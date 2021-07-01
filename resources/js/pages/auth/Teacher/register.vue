<template>
    <div class="container __center">
        <div class="row">
            <div class="login-container hvr-underline-from-center col-lg-6 col-md-6" >
                <h1 class="text-center mt-0 " ><i>Sign Up</i></h1>
                <!--                <i id="loading-icon" class="fas fa-spinner faa-spin animated faa-fast"></i>-->
                <form  @submit.prevent="register" class="padding-right mt-5" id="loginForm" @keydown="form.onKeydown($event)">
                    <AlertSuccess :form="form" message="Registered Successfully ." class="text-center"/>
                    <div class="row mb-2">
                        <label for="inputEmail31234" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input v-model="form.name" type="text" name="name" class="form-control" id="inputEmail31234" placeholder="Name">
                            <HasError :form="form" field="name" />
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label for="inputEmail356563" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input v-model="form.email" type="text" name="email" class="form-control" id="inputEmail356563" placeholder="Email">
                            <HasError :form="form" field="email" />
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label for="inputEmail35656" class="col-sm-2 col-form-label">Phone</label>
                        <div class="col-sm-10">
                            <input v-model="form.phone" type="text" name="phone" class="form-control" id="inputEmail35656" placeholder="Phone">
                            <HasError :form="form" field="phone" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputPassword3647" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                            <input v-model="form.password" type="password" name="password" class="form-control" id="inputPassword3647" placeholder="Password" autocomplete="1">
                            <HasError :form="form" field="password" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputPassword3" class="col-sm-2 col-form-label">Confirm Password</label>
                        <div class="col-sm-10">
                            <input v-model="form.password_confirmation" type="password" name="password_confirmation" class="form-control" id="inputPassword367" placeholder="Password" autocomplete="1">
                            <HasError :form="form" field="password_confirmation" />
                        </div>
                    </div>
                    <Button :form="form" class="btn btn-primary mt-2" id="admin_login">
                        Register
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
                    <router-link :to="{ name : 'login' }"
                       class="btn btn-primary btn-to-home mt-2">
                        Log In</router-link>
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
            name:"",
            email : "",
            phone:"",
            password: "",
            password_confirmation: ""
        })
    }),
    methods: {
        register () {
            this.form.post('/api/v1/auth/teacher/register').then(({data})=>{
                this.$router.push({name: 'login'})
            }).catch((errors)=>{
                console.log(errors.response.data)
            })
        }
    }
}

</script>

