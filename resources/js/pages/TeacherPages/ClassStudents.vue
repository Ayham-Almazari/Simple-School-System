<template>
<div class="container">
    <table class="table table-primary table-borderless table-hover " style="font-size: 1vw">
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
                    <button :stu-id="Student.id" class="btn btn-danger" v-on:click="fetchStudent" @click="$refs.DeleteStudentAlert.open()" >Remove</button>
                    <button :stu-id="Student.id" type="button" class="btn btn-outline-dark" v-on:click="fetchStudent"  @click="$refs.EditStudentModal.open()">Edit</button>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
    <sweet-modal ref="DeleteStudentAlert" icon="warning">
        <br>
        <rise-loader :loading="isLoading"  size="15px" color="#F8BE86"></rise-loader>
        <div v-if="student && !isLoading">
            Are You Sure , You Got To Remove Student <span style="text-decoration: line-through;color: red">{{student.name}}</span> From <i>{{Classroom.class_name}}</i> Class .</div>
        <button class="btn btn-outline-danger" v-on:click="removeStudent" :disabled="isLoading" form>Remove Student</button>
    </sweet-modal>
    <sweet-modal icon="success" ref="SuccessDeleteStudent">
        <div v-if="student" style="padding-top: 50px;z-index: 3"> Student "{{student.name}}" From {{Classroom.class_name}} Class Removed Successfully . </div>
    </sweet-modal>
    <sweet-modal  ref="EditStudentModal">
        <pulse-loader :loading="isLoading" color="#1C1F23" size="15px"></pulse-loader>
        <div class="container"  v-if="student && !isLoading">
            <h3 class="text-center">Edit Student <u>{{student.name}}</u> Marks In <i>{{Classroom.class_name}}</i> Class</h3>
            <form @submit.prevent="UpdateStudentMarks" class="container mt-5"  @keydown="form.onKeydown($event)">
                <AlertError :form="form" message="Student Marks Is Not Updated ! ." class="text-center"/>
                <AlertSuccess :form="form" message="Student Marks Updated Successfully! ." class="text-center"
                              v-bind:style="{display:EditMarksSuccessAlert}"/>
                <div class="row mb-2 d-flex justify-content-center">
                    <div class="col-sm-10 ">
                        <input v-model="student.first_term" type="text" name="first_term" class="form-control"
                                placeholder="First Term" autocomplete="off" >
                        <HasError :form="form" field="first_term"/>
                    </div>
                </div>
                <div class="row mb-2 d-flex justify-content-center">
                    <div class="col-sm-10 ">
                        <input v-model="student.mid_term" type="text" name="mid_term" class="form-control"
                                placeholder="Mid Term" autocomplete="off" >
                        <HasError :form="form" field="mid_term"/>
                    </div>
                </div>
                <div class="row mb-2 d-flex justify-content-center">
                    <div class="col-sm-10 ">
                        <input v-model="student.final_term" type="text" name="final_term" class="form-control"
                               placeholder="Final Term" autocomplete="off" >
                        <HasError :form="form" field="final_term"/>
                    </div>
                </div>
                <div class="row mb-3 d-flex justify-content-center">
                    <div class="d-flex justify-content-center">
                        <Button :form="form" class="btn btn-dark mt-4 hvr-buzz-out" :disabled="isLoading">
                            Edit Marks
                        </Button>
                    </div>
                </div>
            </form>
            <sweet-modal icon="success" ref="openCreateClassroomSuccess">
                Classroom Updated Successfully
            </sweet-modal>
        </div>
    </sweet-modal>
<!--    <div class="input-container">
        <input type="search" placeholder="Type a name" v-model="StudentName" />
    </div>
    <div v-for="student in StudentsFeed" v-bind:key="student.id">
        {{student.name}}
    </div>-->
</div>
</template>

<script>
import {mapGetters} from "vuex";
import { SweetModal } from 'sweet-modal-vue'
import RiseLoader from 'vue-spinner/src/RiseLoader.vue'
import PulseLoader from 'vue-spinner/src/PulseLoader.vue'
import Form from "vform";
import {AlertError, AlertSuccess, Button, HasError} from "vform/src/components/bootstrap5";
import axios from "axios";
export default {
    data: () => ({
        form:  Form.make({
            first_term: null,
            mid_term:  null,
            final_term: null
        }),
        EditMarksSuccessAlert:"none",
        StudentName:"",
        StudentsFeed:null
    }),
    components: {
        SweetModal,
        RiseLoader,
        PulseLoader ,
        Button, HasError, AlertError, AlertSuccess
    },
    name: "ClassStudents"
    ,
    mounted() {
        this.$store.dispatch('TeacherClassesStudents/fetchTeacherStudents',this.$route.params.classroom)
        this.$store.dispatch('TeacherClasses/fetchTeacherClass',this.$route.params.classroom)
        /*axios
            .get('/teacher/students/all')
            .then(response => {
                console.log(response.data)
                this.StudentsFeed = response.data;
            })
            .catch(error => console.log(error))*/
    },
    computed:{
        ...mapGetters({
            Students :"TeacherClassesStudents/ClassStudents",
            Classroom :"TeacherClasses/Classroom",
            student:"TeacherClassesStudents/ClassStudent",
            isLoading : "TeacherClassesStudents/isLoading"
        })
    },
    methods:{
        fetchStudent:function(event){
            let id = event.target.getAttribute('stu-id')
            this.$store.dispatch('TeacherClassesStudents/fetchTeacherClassroomStudent',{classID:this.$route.params.classroom,stuID:id})
            this.EditMarksSuccessAlert="none"
        },
        removeStudent:function(){
            this.$store.dispatch('TeacherClassesStudents/removeStudentFromClassroom',{classID:this.$route.params.classroom,stuID:this.student.id})
            this.$store.dispatch('TeacherClassesStudents/fetchTeacherStudents',this.$route.params.classroom)
            this.$refs.SuccessDeleteStudent.open()
            this.$refs.DeleteStudentAlert.close()
        },
        UpdateStudentMarks:function (){
                this.form.first_term=this.student.first_term
                this.form.mid_term=this.student.mid_term
                this.form.final_term=this.student.final_term
            this.form.put(`/api/v1/teacher/update/classrooms/${this.$route.params.classroom}/students/${this.student.id}/marks`).then(({data}) => {
                this.EditMarksSuccessAlert="block"
                this.$store.dispatch('TeacherClassesStudents/fetchTeacherStudents', this.$route.params.classroom)
            }).catch((errors) => {
                console.log(errors.response.data)
            })
        }
    }
}
</script>

<style scoped>

</style>
