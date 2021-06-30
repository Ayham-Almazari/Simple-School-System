import ExampleComponent from "../components/ExampleComponent";
import * as viwes from "../pages/auth/Teacher";
import indexTeacher from "../pages/TeacherPages/index"
export default {
    mode: "history",
    routes:[
        {
            path:'/',
            component:indexTeacher,
            name:'home'
        },
        {
            path:'/login',
            component:viwes.login,
            name:'login'
        },
        {
            path:'/register',
            component:viwes.register,
            name:'register'
        }
    ]
}
