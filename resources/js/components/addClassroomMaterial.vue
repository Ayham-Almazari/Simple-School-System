<template>
    <div class="container">
        <form @submit.prevent="UpdateMaterialClass" class="container mt-5">
            <div class="row mb-3 d-flex justify-content-center">
                <div class="col-sm-10">
                    <vue-editor v-model="material_description" placeholder="Material Description"></vue-editor>
                    <div v-if="showMessageErrorMaterialDescription" v-html="material_description_error_messages"
                         class="text-center fs-6" style="color: red"></div>
                </div>

                <vue-dropzone ref="myVueDropzone" id="customdropzone"
                              :options="dropzoneOptions"
                              @vdropzone-sending="beforeSend"
                              @vdropzone-success="afterSendSuccess"
                              @vdropzone-error="afterSendError"
                              @vdropzone-processing="dropzoneChangeUrl"
                ></vue-dropzone>
                <div v-if="showMessageErrorUploadFile" v-html="messageErrorUploadFile" class="text-center fs-6"
                     style="color: red"></div>

                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-dark mt-4">
                        <clip-loader :loading="show_spinner" color="white"
                                     size="16px"></clip-loader>
                        <span v-if="!show_spinner" >Add Material</span>
                    </button>
                </div>
            </div>
        </form>
        <sweet-modal icon="success" class="bg-dark" ref="openCreateClassMaterialSuccess">
            {{CreateClassMaterialSuccessMessage}}
        </sweet-modal>
    </div>
</template>

<script>
import {mapGetters} from "vuex"
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'
import Cookies from "js-cookie"
import {SweetModal} from "sweet-modal-vue"
import {VueEditor} from "vue2-editor"
import {ClipLoader} from 'vue-spinner/dist/vue-spinner.min.js'
export default {
    data: () => ({
        material_description: "",
        show_spinner: false,
        messageErrorUploadFile: "",
        material_description_error_messages: "",
        CreateClassMaterialSuccessMessage: null,
        showMessageErrorUploadFile: false,
        showMessageErrorMaterialDescription: false,
        dropzoneOptions: {
            url :`url`,
            thumbnailWidth: 100,
            maxFilesize: 5,
            parallelUploads: 1,
            maxFiles: 1,
            autoProcessQueue: false,
            headers: {"Authorization": `Bearer ${Cookies.get('token')}`},
            dictDefaultMessage: "<i class='fas fa-cloud-upload-alt' style='font-size: 20px ;color: #000000;margin-right: 6px'></i>\n" +
                "<span style='color: white'> Click Or Drop Your Material Here </span>"
        }
    }),
    components: {
        SweetModal,
        VueEditor,
        vueDropzone: vue2Dropzone,
        ClipLoader
    },
    methods: {
        dropzoneChangeUrl(){
            this.$refs.myVueDropzone.setOption('url', `http://127.0.0.1:8000/api/v1/teacher/classrooms/${this.$route.params.classroom}/materials`);
        },
        async UpdateMaterialClass() {
            this.$refs.myVueDropzone.processQueue()
            let $files = this.$refs.myVueDropzone.getAcceptedFiles()
            if ($files.length === 0) {
                this.showMessageErrorUploadFile = true
                this.messageErrorUploadFile = "The Material Is Required ."
            }
        },
        async beforeSend(files, xhr, formData) {
            // this.dropzoneOptions.url=`http://127.0.0.1:8000/api/v1/teacher/classes/${this.$route.params.classroom}/materials`
            this.show_spinner = true;
            formData.append('material_description', this.material_description)
        },
        async afterSendSuccess(file, response) {
            this.show_spinner = false;
            this.showMessageErrorUploadFile = false;
            this.showMessageErrorMaterialDescription = false;
            this.CreateClassMaterialSuccessMessage=response.msg;
            this.$refs.openCreateClassMaterialSuccess.open();
            this.$refs.myVueDropzone.removeAllFiles();
            this.material_description =null;
        },
        async afterSendError(file, message, xhr) {
            this.show_spinner = false;
            this.$refs.myVueDropzone.removeFile(file)
            const data = JSON.parse(xhr.response);
            data.errors.file.forEach((error) => {
                this.showMessageErrorUploadFile = true;
                this.messageErrorUploadFile = error.toString() + "<br />";
            })
            data.errors.material_description?.forEach((error) => {
                this.showMessageErrorMaterialDescription = true;
                this.material_description_error_messages = error.toString() + "<br />";
            })
            console.log(data)
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


