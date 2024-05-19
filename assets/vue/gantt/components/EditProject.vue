

<template>

    <button type="button" class="btn btn-primary" @click="showModal = true"
        style="--bs-btn-padding-y: .20rem; --bs-btn-padding-x: .4rem; --bs-btn-font-size: .70rem;">
        Edit
    </button>


    <Modal :show="showModal" :header="false" :stylemodal="'modal-md'" @onchange="showModal = $event">

        <div class="card card-success">
        <div class="card-header">
            <h3 class="card-title">Different Height</h3>
        </div>
        <div class="card-body">
            <input class="form-control form-control" type="text" placeholder="Name" v-model="project.name">
            <br>
            <!-- <input class="form-control" type="text" placeholder="Default input"> -->
            
            
        </div>

    </div>


        <template v-slot:footer>
            <button type="button" @click="closeModal()" class="btn btn-default btn-sm"
                data-dismiss="modal">Close</button>
            <button type="button" form="formActorModal" class="btn btn-default float-right" @click="handlerProject(project)" >Salva actore</button>

        </template>
    </Modal>

</template>
<script setup lang="ts">
import Modal from './../shared/modal.vue'
import { ProjectInterface } from '../interfaces/project.interface';
import { ref } from 'vue';




defineProps<{ project: ProjectInterface }>();
const emit = defineEmits<{
    (e: "onChange", project: ProjectInterface): void;
}>();


const showModal = ref(false);

const closeModal = () => {
    showModal.value = false;
}

const handlerProject=(project: ProjectInterface)=>{
    emit("onChange",project);
    closeModal();
}
</script>
<style>
.modal-body {
  padding: 0px !important;
}

</style>