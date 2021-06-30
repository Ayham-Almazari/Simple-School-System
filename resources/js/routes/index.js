import TeacherRoutes from "./TeacherRoutes";
import Vue from "vue"
import VueRouter from "vue-router";
Vue.use(VueRouter)

 export default new VueRouter({
  modules:{
      TeacherRoutes
  }
})
