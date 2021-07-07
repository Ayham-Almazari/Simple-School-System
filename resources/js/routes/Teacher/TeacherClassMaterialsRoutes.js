import AllClassMaterials from "../../pages/TeacherPages/AllClassMaterials";
import auth from "../../middlewares/auth";
import authCheck from "../../middlewares/auth-check";
import addClassroomMaterial from "../../components/addClassroomMaterial";

export const TeacherClassMaterialsRoutes =  [
    {
        path:"",
        name:"ClassMaterials",
        component:AllClassMaterials,
        meta:{
            middleware: [auth,authCheck]
        }
    },{
        path:"add",
        name:"AddNewMaterial",
        component:addClassroomMaterial,
        meta:{
            middleware: [auth,authCheck]
        }
    }
]
