<template>

    <button type="button" class="btn btn-primary" @click="handlerCreateTask"
            style="--bs-btn-padding-y: .20rem; --bs-btn-padding-x: .4rem; --bs-btn-font-size: .70rem;">
                Nuovo
    </button>

    <!-- <button type="button" class="btn btn-primary" @click="showModal = true"
        style="--bs-btn-padding-y: .20rem; --bs-btn-padding-x: .4rem; --bs-btn-font-size: .70rem;">
        Edit
    </button> -->

    <Modal :show="show" :header="false" :stylemodal="'modal-md'" @onchange="handlerChangeModal">

        <div class="card card-success">
        <div class="card-header">
            <h3 class="card-title">Edit task</h3>
        </div>
        <div class="card-body" v-if="task">
            <input class="form-control form-control" type="text" placeholder="Name" v-model="task.name">
            <br>
            <input class="form-control" type="datetime-local" v-model="task.ini">
            <br>
            <input class="form-control" type="datetime-local" v-model="task.fine">
            <br>
            <input class="form-control" type="color" v-model="task.color">
            <br>
            <input class="form-control" type="number" v-model="task.per">
        </div>

    </div>

{{ task }}
        <template v-slot:footer>
            <button type="button" @click="closeModal()" class="btn btn-default btn-sm"
                data-dismiss="modal">Close</button>
            <button type="button" form="formActorModal" class="btn btn-default float-right" v-if="task" @click="handlerTask(task)" >Salva actore</button>

        </template>
    </Modal>

</template>
<script setup lang="ts">
import Modal from './../shared/modal.vue'

import { computed, ref } from 'vue';
import { TaskInterface } from '../interfaces/task.interface';


const props =defineProps<{ show:boolean, task?: TaskInterface }>();
const emit = defineEmits<{
    (e: "onChange", task: TaskInterface): void;
    (e: "onChangeModal", show: boolean): void;
    (e: "onCreate"): void;
}>();

const dt_ini=computed({
    get() {
    return props.task?.ini.replaceAll('/','-').concat('T08:00');
  },
  // setter
  set(newValue) {
    props.task!.ini = newValue!.replaceAll('-','/').substring(0,10);
  }
});

const dt_fine=computed({
    get() {
    return props.task?.fine.replaceAll('/','-').concat('T08:00');
  },
  // setter
  set(newValue) {
    props.task!.fine = newValue!.replaceAll('-','/').substring(0,10);
  }
});


const closeModal = () => {
    //showModal.value = false;
    emit("onChangeModal",false);
}
const handlerChangeModal=(payload:boolean)=>{
    emit("onChangeModal",payload);
}

const handlerTask=(task: TaskInterface)=>{
    emit("onChange",task);
    closeModal();
}


const handlerCreateTask =()=>{
    //showModal.value = true;
    emit("onCreate");

}
</script>
<style>
.modal-body {
    padding: 0px !important;
}

</style>