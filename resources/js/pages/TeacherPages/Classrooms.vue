<template>
    <div class="container  mt-5">
        <button class="btn btn-dark" @click="show" id="AddNewClassRoom"
        ><i class="fa fa-plus"></i> Classroom
        </button>
        <div class="row mt-5 ">
            <div class="col-sm-6 mt-2" v-for="classroom in classrooms" :key="classroom.id">
                <div class="card">
                    <div class="card-body d-flex justify-content-between ">
                        <h5 class="card-title w-100 text-center">{{ classroom.class_name }}</h5>
                    </div>
                    <router-link :to="{name: 'viewClassroom', params:{classroom:classroom.id}}"
                                 class="btn btn-dark hvr-bounce-to-top text-info">
                        <i class="fas fa-eye"></i>
                    </router-link>
                </div>
            </div>
        </div>
        <modal name="Create-Class-Room" width="50%" height="80%">
            <form @submit.prevent="createNewClassroom" class="container mt-5 " id="createclassroomform"
                  @keydown="form.onKeydown($event)">
                <AlertError :form="form" message="Classroom Not Created ! ." class="text-center"
                            id="CreateNewClassroomError"/>
                <div class="row mb-2 d-flex justify-content-center">
                    <div class="col-sm-10 ">
                        <input v-model="form.class_name" type="text" name="class_name" class="form-control"
                               id="inputEmail352555" placeholder="Classroom Name">
                        <HasError :form="form" field="class_name"/>
                    </div>
                </div>
                <div class="row mb-3 d-flex justify-content-center">
                    <div class="col-sm-10">
                        <vue-editor v-model="form.class_description" placeholder="Classroom Description"></vue-editor>
                        <HasError :form="form" field="class_description"/>
                    </div>
                    <div class="d-flex justify-content-center">
                        <Button :form="form" class="btn btn-dark mt-4">
                            Create Classroom
                        </Button>
                    </div>
                </div>
            </form>
        </modal>
        <sweet-modal icon="success" ref="openCreateClassroomSuccess">
            Classroom Added Successfully
        </sweet-modal>
    </div>
</template>

<script>
import {VueEditor, Quill} from "vue2-editor";
import {mapGetters} from "vuex"
import {SweetModal, SweetModalTab} from 'sweet-modal-vue'
import Form from "vform"
import {
    Button,
    HasError,
    AlertError,
    AlertSuccess
} from 'vform/src/components/bootstrap5'
export default {
    data: () => ({
        form: new Form({
            class_name: "",
            class_description: ""
        })
    }),
    components: {
        SweetModal,
        SweetModalTab,
        Button, HasError, AlertError, AlertSuccess,
        VueEditor
    },
    computed: {
        ...mapGetters({
            classrooms: 'TeacherClasses/Classrooms'
        })
    },
    mounted() {
        this.$store.dispatch('TeacherClasses/fetchTeacherClasses')
    },
    methods: {
        show() {
            this.$modal.show('Create-Class-Room');
        },
        hide() {
            this.$modal.hide('Create-Class-Room');
        },
        mount() {
            this.show()
        },
        showSuccess() {
            this.$refs.openCreateClassroomSuccess.open()
        },
        createNewClassroom() {
            this.form.post('/api/v1/teacher/classrooms').then(() => {
                this.showSuccess()
                this.$store.dispatch('TeacherClasses/fetchTeacherClasses')
                this.hide()
                this.form.reset()
            }).catch((errors) => {
                console.log(errors)
            })
        }
    }
}
</script>

<style scoped>
#AddNewClassRoom {
    position: fixed;
    left: 0;
    z-index: 2;
    width: fit-content;
}
</style>
