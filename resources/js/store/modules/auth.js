import axios from "axios"
import Cookies from "js-cookie"
import * as types from "./mutations_types"

//state
const state = {
    user : null,
    token: Cookies.get("token"),
    auth_error:null,
    loading:false,
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
        state["auth/isLogged"]=true
        state.token = token
        Cookies.set("token", token , {expires: remember ? 14 : null})
    },
    [types.FETCH_USER_SUCCESS](state,{user}){
        state["auth/isLogged"]=true
        state.user = user.data.user
    },
    [types.FETCH_USER_FAILURE](state){
        state["auth/isLogged"]=false
        state.token = token
        Cookies.remove ('token')
    },
    [types.LOGOUT](state) {
        state["auth/isLogged"]=false
        state.user = null;
        state.token = null;
        Cookies.remove("token");
        state.isLogged = false;
    }
}

//actions
const actions ={
    saveToken({commit},payload){
    commit(types.SAVE_TOKEN ,payload)
    },
    async fetchUser({commit}) {
        try {
            const {data} = await axios.get('/api/v1/auth/teacher/user')
            commit(types.FETCH_USER_SUCCESS ,{user:data})
            console.log(data.user)
        } catch (error) {
            commit(types.FETCH_USER_FAILURE)
        }
    }
}

export default {
    namespaced:true,
    state , getters , mutations, actions
}
