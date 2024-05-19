<template>

    <button type="button" class="btn btn-primary" @click="showModal = true"
        style="--bs-btn-padding-y: .20rem; --bs-btn-padding-x: .4rem; --bs-btn-font-size: .70rem;">
        Projects
    </button>


    <Modal :show="showModal" :header="false" :stylemodal="'modal-md'" @onchange="showModal = $event">

        <div class="card p-0">
            <div class="card-header d-flex  pe-2 align-items-center justify-content-between">
                <!-- <h3 class="card-title mb-1">{{ select?.name }}</h3> -->

                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 250px;">
                        <input type="text" name="table_search" class="form-control float-right" v-model="search"
                            placeholder="Search">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <!-- <i class="fa-solid fa-pen-to-square"></i> -->
                                Cerca
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body p-1">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Project</th>
                            <th>Progress</th>
                        <th style="width: 40px">Label</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="project in projects" :key="project.id">
                            <td >{{ project.id }}</td>
                            <td  @click="handlerProject(project)"  class="cursor">{{ project.name }}</td>
                            <td>
                            <div class="progress progress-xs">
                                <div class="progress-bar progress-bar-danger" style="width: 55%"></div>
                            </div>
                        </td>
                        <td><span class="badge bg-danger">55%</span></td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>


        <template v-slot:footer>
            <button type="button" @click="closeModal()" class="btn btn-default btn-sm"
                data-dismiss="modal">Close</button>
            <!-- <button type="submit" form="formActorModal" class="btn btn-default float-right" >Salva actore</button> -->

        </template>
    </Modal>

</template>
<script setup lang="ts">
import Modal from './../shared/modal.vue'
import { ProjectInterface } from '../interfaces/project.interface';
import { ref, watch } from 'vue';
import { useDebouncedRef } from '../uitils/debounce';


const search = useDebouncedRef('');
defineProps<{ projects: ProjectInterface[] }>();
const emit = defineEmits<{
    (e: "onProject", project: ProjectInterface): void;
    (e: "onSearchName", search: string): void;
}>();

watch(search, (newval, _) => {
  emit("onSearchName",newval);    
});

const showModal = ref(false);

const closeModal = () => {
    showModal.value = false;
}

const handlerProject=(project: ProjectInterface)=>{
    emit("onProject",project);
    closeModal();
}
</script>
<style>
.modal-body {
  padding: 0px !important;
}

</style>