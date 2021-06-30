import ExampleComponent from "../components/ExampleComponent";
import test from "../components/test";

export default {
    mode: "history",
    routes:[
        {
            path:'/',
            component:ExampleComponent,
            name:'home'
        },
        {
            path:'/test',
            component:test,
            name:'test'
        }
    ]
}
