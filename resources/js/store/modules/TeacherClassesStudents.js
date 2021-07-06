import TeacherClassesDataService from "./HTTP_SERVICE/TeacherClassesDataService";
const state ={
    ClassStudents:null,
    ClassStudent :null,
    loading:false,
    whileStudentsLoading:false
}

const getters = {
    ClassStudents:state =>state.ClassStudents,
    ClassStudent:state =>state.ClassStudent,
    isLoading:state =>state.loading,
    studentLoading:state => state.whileStudentsLoading
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
        state.whileStudentsLoading = true
        TeacherClassesDataService.getAllStudents(id).then(({data})=>{
            commit("fetchTeacherClassroomStudents",{ClassStudents:data})
            state.whileStudentsLoading = false
        }).catch ((err)=>{
            console.log(err)
            state.whileStudentsLoading = false
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
    removeStudentFromClassroom({commit},{classID,stuID}){
        TeacherClassesDataService.removeStudentFromClass(classID,stuID).catch ((err)=>{
            console.log(err)
        })
    }

}

export default {
    namespaced:true,
    state , getters , mutations, actions
}
