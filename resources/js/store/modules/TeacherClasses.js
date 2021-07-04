import axios from "axios";
import TeacherClassesDataService from "./HTTP_SERVICE/TeacherClassesDataService";
const state ={
    Classrooms:[],
    Classroom:[]
}

const getters = {
    Classrooms:state => state.Classrooms,
    Classroom:state => state.Classroom,
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
         TeacherClassesDataService.getAll().then(({data})=>{
             commit("fetchTeacherClasses",{Classrooms:data})
         }).catch ((err)=>{
            console.log(err)
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
