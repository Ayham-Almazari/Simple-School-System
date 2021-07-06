import axios from "axios";
import TeacherClassesDataService from "./HTTP_SERVICE/TeacherClassesDataService";
const state ={
    Classrooms:null,
    Classroom:[],
    isLoading:false
}

const getters = {
    Classrooms:state => state.Classrooms,
    Classroom:state => state.Classroom,
    isLoading:state =>state.isLoading
}

const mutations = {
    fetchTeacherClasses(state, {Classrooms} ) {
        state.Classrooms = Classrooms.data
    },
    fetchTeacherClassroom(state , {Classroom}) {
        state.Classroom = Classroom.data
    }
}

const actions = {
     fetchTeacherClasses({commit}){
         state.isLoading=true
         TeacherClassesDataService.getAll().then(({data})=>{
             commit("fetchTeacherClasses",{Classrooms:data})
             state.isLoading=false
         }).catch ((err)=>{
            console.log(err)
             state.isLoading=false
         })
    },
    async fetchTeacherClass({commit},id){
        try {
            const {data}=  await axios.get('/api/v1/teacher/classrooms/'+id.toString())
            commit("fetchTeacherClassroom",{Classroom:data})
        }catch (err){
            console.log(err)
        }
    }
}

export default {
    namespaced:true,
    state , getters , mutations, actions
}
