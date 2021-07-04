import axios from "axios";
import TeacherClassesDataService from "./HTTP_SERVICE/TeacherClassesDataService";
const state ={
    ClassStudents:[],
    ClassStudent :null
}

const getters = {
    ClassStudents:state =>state.ClassStudents,
    ClassStudent:state =>state.ClassStudent,
}

const mutations = {
    fetchTeacherClassroomStudents(state , {ClassStudents}) {
        state.ClassStudents = ClassStudents.data
    },
    fetchTeacherClassroomStudent(state , {ClassStudent}) {
        state.ClassStudent = ClassStudent.data
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
        TeacherClassesDataService.showStudent(classID,stuID).then(({data})=>{
            console.log(data)
            commit("fetchTeacherClassroomStudents",{ClassStudent:data})
        }).catch ((err)=>{
            console.log(err)
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
    removeStudentFromClassroom(classID,stuID){
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
