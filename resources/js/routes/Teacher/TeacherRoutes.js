import Classrooms from "../../pages/TeacherPages/Classrooms";
import ViewClassroom from "../../pages/TeacherPages/ViewClassroom";
import ClassStudents from "../../pages/TeacherPages/ClassStudents";
import ClassMaterials from "../../pages/TeacherPages/ClassMaterials";
import ClassroomForm from "../../components/ClassroomForm"
import auth from "../../middlewares/auth";
import authCheck from "../../middlewares/auth-check";
export const TeacherRoutes =  [
    {
        path: "",
        component:Classrooms,
        name:'TeacherIndex',
        meta:{
            middleware: [auth,authCheck]
        }
    },
    {
        path: "classrooms/:classroom",
        component: ViewClassroom,
        name:"viewClassroom",
        meta:{
            middleware: [auth,authCheck]
        },
        children:[
            {
                path: "students",
                component: ClassStudents,
                name:"ClassStudents",
                meta:{
                    middleware: [auth,authCheck]
                }
            },
            {
                path: "materials",
                component: ClassMaterials,
                name:"ClassMaterials",
                meta:{
                    middleware: [auth,authCheck]
                }
            },
            {
                path: "edit",
                component: ClassroomForm,
                name:"EditClassroom",
                meta:{
                    middleware: [auth,authCheck]
                }
            }
        ]
    }
]
