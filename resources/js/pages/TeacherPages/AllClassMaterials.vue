<template>
<div class="container">
<div v-for="material in Materials">
    <div v-html="material.material_description"></div>
    <a :href="'http://localhost:8000/storage/' +material.material">material</a>
</div>
</div>
</template>

<script>
import vue2Dropzone from 'vue2-dropzone'
import TeacherClassesDataService from "../../store/modules/HTTP_SERVICE/TeacherClassesDataService";

export default {
    data:()=>({
        Materials:[]
    }),
    components: {
        vueDropzone: vue2Dropzone,
    },
    mounted() {
        TeacherClassesDataService.getAllMaterials(this.$route.params.classroom).then(({data})=>{
            this.Materials=data.data
            console.log(this.Materials)
        })
    }
}
</script>

<style scoped>

</style>
