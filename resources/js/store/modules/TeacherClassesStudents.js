import axios from "axios";
import TeacherClassesDataService from "./HTTP_SERVICE/TeacherClassesDataService";
const state ={
    ClassStudents:[],
    ClassStudent :null,
    loading:false
}

const getters = {
    ClassStudents:state =>state.ClassStudents,
    ClassStudent:state =>state.ClassStudent,
    isLoading:state =>state.loading
}

const mutations = {

    fetchTeacherClassroomStudents(state , {ClassStudents}) {
        state.ClassStudents = ClassStudents.data
    },
    fetchTeacherClassroomStudent(state , {ClassStudent}) {
        state.ClassStudent = ClassStudent.data
        state.loading = false

    },

}

const actions = {
    fetchTeacherStudents({commit},id){
        TeacherClassesDataService.getAllStudents(id).then(({data})=>{
            commit("fetchTeacherClassroomStudents",{ClassStudents:data})
        }).catch ((err)=>{
            console.log(err)
        })
        },
    fetchTeacherClassroomStudent({commit}, {classID, stuID}){
        state.loading = true
        TeacherClassesDataService.showStudent(classID,stuID).then(({data})=>{
            commit("fetchTeacherClassroomStudent",{ClassStudent:data})
                state.loading = false
        }).catch ((err)=>{
            console.log(err)
            state.loading = false
        })
    },
    updateTeacherClassroomStudentMark(classID,stuID ,data){
        TeacherClassesDataService.updateStudentMarks(classID,stuID,data).then(({data})=>{
            console.log(data)
        }).catch ((err)=>{
            console.log(err)
        })
    },
    addStudentToClassroom(classID,stuID ,data){
        TeacherClassesDataService.storeStudent(classID,stuID,data).then(({data})=>{
            console.log(data)
        }).catch ((err)=>{
            console.log(err)
        })
    },
    removeStudentFromClassroom({commit},{classID,stuID}){
        TeacherClassesDataService.removeStudentFromClass(classID,stuID).then(({data})=>{
            console.log(data)
        }).catch ((err)=>{
            console.log(err)
        })
    }

}

export default {
    namespaced:true,
    state , getters , mutations, actions
}
