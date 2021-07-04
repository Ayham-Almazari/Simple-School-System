<template>
<div class="container">
    <table class="table table-primary table-borderless table-hover">
        <caption align="top" class="text-center">
            <button type="button" class="btn btn-outline-dark">Add Student</button>
        </caption>
        <thead class="table-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Phone</th>
            <th scope="col">First_term</th>
            <th scope="col">Mid_term</th>
            <th scope="col">Final_term</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="Student in Students" :key="Student.id">
            <th scope="row">{{ Student.id }}</th>
            <td>{{ Student.name }}</td>
            <td>{{ Student.email }}</td>
            <td>{{ Student.phone }}</td>
            <th>{{ Student.first_term ? Student.first_term: "--" }}</th>
            <th>{{ Student.mid_term ? Student.mid_term:"--"}}</th>
            <th>{{ Student.final_term ? Student.final_term:"--"}}</th>
            <td>
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button :stu-id="Student.id" class="btn btn-danger" v-on:click="fetchStudent" >Delete</button>
                    <button type="button" class="btn btn-outline-dark">Edit</button>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
    <sweet-modal ref="ModalAlert" icon="warning">
        Are You Sure , You Got To Delete Student From Class
        <button class="btn btn-outline-warning" slot="button" v-on:click="$refs.nestedChild.open()" form>Open Child Modal</button>
    </sweet-modal>
    <sweet-modal icon="success" ref="nestedChild">
        This is a success!
    </sweet-modal>
    <div>saas
        {{CurrentStudent}}
    </div>
</div>
</template>

<script>
import {mapGetters} from "vuex";
import { SweetModal } from 'sweet-modal-vue'
export default {
    data() {
        return {
            stu_id:""
        }
    },
    components: {
        SweetModal
    },
    name: "ClassStudents"
    ,
    mounted() {
        this.$store.dispatch('TeacherClassesStudents/fetchTeacherStudents',this.$route.params.classroom)
        this.$store.dispatch('TeacherClasses/fetchTeacherClass',this.$route.params.classroom)
    },
    computed:{
        ...mapGetters({
            Students :"TeacherClassesStudents/ClassStudents",
            Classroom :"TeacherClasses/Classroom",
            CurrentStudent : "TeacherClassesStudents/ClassStudent"
        })
    },
    methods:{
        fetchStudent:function(event){
            let id = event.target.getAttribute('stu-id');
            this.$store.dispatch('TeacherClassesStudents/fetchTeacherClassroomStudent',{classID:this.$route.params.classroom,stuID:id})
            console.log(this.CurrentStudent)
        },
        callFunction: function (event) {


            var id = event.target.getAttribute('data-id');
            console.log(id);

        }
    }
}
</script>

<style scoped>

</style>
