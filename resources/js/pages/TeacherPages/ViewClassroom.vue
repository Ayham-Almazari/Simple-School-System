<template>
    <div class="container">
        <div class="d-flex flex-column col-12 bg-white h-100">
                <div class="btn-group" role="group" aria-label="Basic outlined toggle button group">
                    <router-link  :to="{'name' : 'TeacherIndex'}" class="btn btn-outline-primary" exact-active-class="active-4" exact>
                  <i class="fas fa-backward"></i> Back To ClassRooms
                    </router-link>

                    <router-link :to="{'name' : 'EditClassroom'}" class="btn btn-outline-primary" exact-active-class="active-4" exact>
                    <i class="fas fa-edit"></i> Edit ClassRoom
                    </router-link>

                    <router-link :to="{'name' : 'ClassStudents'}" class="btn btn-outline-primary" exact-active-class="active-4" exact>
                        <i class="fas fa-users"></i> Students
                    </router-link>

                    <router-link :to="{'name' : 'ClassMaterials'}" class="btn btn-outline-primary" exact-active-class="active-4" exact>
                        <i class="fas fa-book-reader"></i> Classroom Materials
                    </router-link>
            </div>
            <div class="card text-white bg-primary mb-3" >
                <div class="card-header text-center"><h2>{{Classroom.class_name}}</h2></div>
                <div class="card-body">
                    <div  v-html="Classroom.class_description" class="carbon-text fs-5"></div>
                </div>
            </div>

            <router-view></router-view>

        </div>

    </div>
</template>

<script>
import VueRouter from "vue-router"
import {mapGetters} from "vuex";
import Form from "vform"

export default {
    methods: {
        back() {
            this.$router.back()
        }
    },
    computed: {
        ...mapGetters({
            Classroom: "TeacherClasses/Classroom"
        })
    },
    mounted() {
        this.$store.dispatch('TeacherClasses/fetchTeacherClass', this.$route.params.classroom)
    }
}
</script>

<style scoped>
.active-4{
    background-color:#3490DC !important;
    width: fit-content !important;
    color: white;
}
.card-body{
    text-indent: 20px;
}
</style>
