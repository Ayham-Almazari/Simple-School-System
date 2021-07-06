import Vue from "vue"
import Vuex from "vuex"
import auth from "./modules/auth"
import TeacherClasses from "./modules/TeacherClasses"
import http from "./modules/HTTP_SERVICE/TeacherClassesDataService";
import TeacherClassesStudents from "./modules/TeacherClassesStudents";

Vue.use(Vuex)

export default new Vuex.Store({
    modules:{
        auth,
        TeacherClasses,
        TeacherClassesStudents
    }
})

