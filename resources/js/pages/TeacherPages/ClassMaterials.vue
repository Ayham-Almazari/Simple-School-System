<template>
    <div>
    <div class="btn-group dropend mb-5">
        <!-- Split dropend button -->
        <div class="btn-group dropend">
            <router-link :to="{name:'ClassMaterials'}" class="btn btn-secondary">Class Materials</router-link>
            <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="visually-hidden">Toggle Dropright</span>
            </button>
            <ul class="dropdown-menu  dropdown-menu-dark">
                <!-- Dropdown menu links -->
                <li><router-link class="dropdown-item" :to="{name:'AddNewMaterial'}" >Add Materials</router-link>
                <li><a class="dropdown-item" href="#">Edit Materials</a></li>
                <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
        </div>
    </div>
        <router-view></router-view>
    </div>
</template>

<script>
export default {
}
</script>

<style scoped>

</style>
