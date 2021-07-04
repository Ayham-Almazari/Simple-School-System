import login from "../pages/auth/Teacher/login"
import register from "../pages/auth/Teacher/register"
import index from "../pages/TeacherPages/index"
import welcome from "../pages/welcome"
import Vue from "vue";
import store from "../store/index"
import VueRouter from "vue-router";
import guest from "../middlewares/guest";
import auth from "../middlewares/auth";
import authCheck from "../middlewares/auth-check";
import middlewarePipeline from "../middlewares/middlewarePipeline";
import {TeacherRoutes} from "./TeacherRoutes";
Vue.use(VueRouter)
const router = new VueRouter({
    mode: "history",
    routes:[
        {
            path:'/',
            component:welcome,
            name:'home'
        },
        {
            path:'/login',
            component:login,
            name:'login',
            meta:{
                middleware:[guest]
            }
        },
        {
            path:'/register',
            component:register,
            name:'register',
            meta:{
                middleware:[guest]
            }
        },
        {
            path:'/teachers',
            component:index,
            meta:{
                middleware: [auth,authCheck]
            },
            children:TeacherRoutes
        }
    ]
})

//execute middlewares
router.beforeEach((to , from , next)=>{
    if (!to.meta.middleware ) return next()
    const middleware = to.meta.middleware
    const context = {
        to, from , next ,store
    }
    return middleware[0]({
        ...context ,
        next:middlewarePipeline(context, middleware,1)
    })
})
export default router;
