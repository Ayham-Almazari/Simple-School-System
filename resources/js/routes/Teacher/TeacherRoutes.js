import Classrooms from "../../pages/TeacherPages/Classrooms";
import ViewClassroom from "../../pages/TeacherPages/ViewClassroom";
import ClassStudents from "../../pages/TeacherPages/ClassStudents";
import ClassMaterials from "../../pages/TeacherPages/ClassMaterials";
import ClassroomForm from "../../components/ClassroomForm"
import auth from "../../middlewares/auth";
import authCheck from "../../middlewares/auth-check";
import {TeacherClassMaterialsRoutes} from "./TeacherClassMaterialsRoutes";
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
        path: ":classroom",
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
                meta:{
                    middleware: [auth,authCheck]
                },
                children:TeacherClassMaterialsRoutes
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
