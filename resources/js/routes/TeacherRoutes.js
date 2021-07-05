import Classrooms from "../pages/TeacherPages/Classrooms";
import ViewClassroom from "../pages/TeacherPages/ViewClassroom";
import ClassStudents from "../pages/TeacherPages/ClassStudents";
import ClassMaterials from "../pages/TeacherPages/ClassMaterials";
import ClassroomForm from "../components/ClassroomForm"
export const TeacherRoutes =  [
    {
        path: "",
        component:Classrooms,
        name:'TeacherIndex'
    },
    {
        path: "classrooms/:classroom",
        component: ViewClassroom,
        name:"viewClassroom",
        children:[
            {
                path: "students",
                component: ClassStudents,
                name:"ClassStudents",
            },
            {
                path: "materials",
                component: ClassMaterials,
                name:"ClassMaterials"
            },
            {
                path: "edit",
                component: ClassroomForm,
                name:"EditClassroom",
            }
        ]
    }
]
