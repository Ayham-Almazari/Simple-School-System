import axios from "axios"
import Cookies from "js-cookie"
import * as types from "./mutations_types"
import TeacherClassesDataService from "./HTTP_SERVICE/TeacherClassesDataService";

//state
const state = {
    user : null,
    token: Cookies.get("token"),
    auth_error:null,
    isLogged:false
}

//getters
const getters = {
    user: state  => state.user,
    token: state => state.token,
    check : state => state.isLogged
}

//mutations
const mutations ={
    [types.SAVE_TOKEN](state,{token , remember}){
        state.isLogged=true
        state.token = token
        Cookies.set("token", token , {expires: remember ? 14 : null})
    },
    [types.FETCH_USER_SUCCESS](state,{user}){
        state.isLogged=true
        state.user = user.data.user
    },
    [types.FETCH_USER_FAILURE](state){
        state.isLogged=false
        state.token = null
        Cookies.remove('token')
    },
    [types.LOGOUT](state) {
        state.isLogged=false
        state.user = null
        state.token = null
        Cookies.remove("token")
    }
}

//actions
const actions ={
    saveToken({commit},payload){
    commit(types.SAVE_TOKEN ,payload)
    },
    fetchUser({commit}) {
        TeacherClassesDataService.getUserAuth().then(({data}) => {
            commit(types.FETCH_USER_SUCCESS, {user: data})
        }).catch((errors) => {
            console.log(errors.response.data)
            // commit(types.FETCH_USER_FAILURE)
        })
    },
    logout({commit}){
      TeacherClassesDataService.logout().then(()=>{
          commit(types.LOGOUT)
        }).catch()
     commit(types.LOGOUT)
    }
}

export default {
    namespaced:true,
    state , getters , mutations, actions
}
