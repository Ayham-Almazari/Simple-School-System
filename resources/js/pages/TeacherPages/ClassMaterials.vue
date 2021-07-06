<template>
    <div class="container">
        <form @submit.prevent="UpdateClassroom" class="container mt-5"
              @keydown="form.onKeydown($event)">
            <AlertError :form="form" message="Classroom Not Created ! ." class="text-center"
                        id="CreateNewClassroomError"/>
            <div class="row mb-2 d-flex justify-content-center">
                <div class="col-sm-10 ">
                    <input v-model="form.class_name" type="text" name="class_name" class="form-control"
                           id="inputEmail352555" placeholder="Classroom Name" autocomplete="off" required>
                    <HasError :form="form" field="class_name"/>
                </div>
            </div>
            <div class="row mb-3 d-flex justify-content-center">
                <div class="col-sm-10 ">
                    <vue-editor v-model="form.material_description"  placeholder="Classroom Description"></vue-editor>
                    <HasError :form="form" field="class_description"/>
                </div>
                <vue-dropzone       ref="myVueDropzone" id="customdropzone"
                                    :options="dropzoneOptions"
                ></vue-dropzone>

                <div class="d-flex justify-content-center">
                    <Button :form="form" class="btn btn-dark mt-4">
                        Add Material
                    </Button>
                </div>
            </div>
        </form>
        <sweet-modal icon="success" ref="openCreateClassroomSuccess">
            Classroom Updated Successfully
        </sweet-modal>
    </div>
</template>

<script>
import {mapGetters} from "vuex"
import Form from "vform";
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'
import Cookies from "js-cookie"
import {
    Button,
    HasError,
    AlertError,
    AlertSuccess,
} from 'vform/src/components/bootstrap5'
import {SweetModal, SweetModalTab} from "sweet-modal-vue";
import {VueEditor} from "vue2-editor";
export default {
    data: () => ({
        form: new Form({
            class_name: "",
            material_description: ""
        }),
        dropzoneOptions: {
            url: 'http://127.0.0.1:8000/api/v1/teacher/materials',
            thumbnailWidth: 100,
            maxFilesize: 0.5,
            headers: { "Authorization": `Bearer ${Cookies.get('token')}` },
            dictDefaultMessage:"<i class='fas fa-cloud-upload-alt' style='font-size: 20px ;color: #000000;margin-right: 6px'></i>\n" +
                "<span style='color: white'> Click Or Drop Your Material Here </span>"
        }
    }),
    components: {
        SweetModal,
        SweetModalTab,
        Button, HasError, AlertError, AlertSuccess,
        VueEditor,
        vueDropzone: vue2Dropzone
    },
    methods:{
        showSuccess() {
            this.$refs.openCreateClassroomSuccess.open()
        },
        UpdateClassroom() {
            this.form.put(`/api/v1/teacher/classrooms/${this.$route.params.classroom}`).then(() => {
                this.showSuccess()
                this.$store.dispatch('TeacherClasses/fetchTeacherClass', this.$route.params.classroom)
            }).catch((errors) => {
                console.log(errors.response.data)
            })
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
#customdropzone {
    background-color: #3490DC;
    width: 50%;
    margin-top: 6px;
}

</style>
