<template >
    <!-- <div ref="root" class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header" :class="[toast.type]">
            <strong class="mr-auto">Message</strong>
            <button data-dismiss="toast" @click="dismiss" type="button"
                class="ml-2 mb-1 close" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="toast-body">{{props.toast.message}}</div>
    </div> -->


    <div ref="root" class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header" :class="[toast.type]">

            <strong class="me-auto text-white">Message</strong>
            <!-- <small class="text-body-secondary">just now</small> -->
            <!-- <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button> -->
            <button data-dismiss="toast" @click="dismiss" type="button"
                class="ml-2 mb-1 btn-close" aria-label="Close">
                
            </button>
        </div>
        <div class="toast-body" v-html="props.toast.message">
            
        </div>
    </div>
</template>

<script setup lang="ts">
import { ToastMessage } from '../Models';
import { removeElement } from './../helpers';
import { RendererElement, onMounted, ref, render, watch } from 'vue';


const props = defineProps<{ toast: ToastMessage }>()
/* const props=defineProps({
        message: {
            type: String,
            required: true
        },
        duration: {
            type: Number,
            default:3000
        }
    }) */

const emit = defineEmits<{
    (e: 'ondismiss', index: number): void
    //(e: 'update', value: string): void
}>()


/* const emit = defineEmits({
  ondismiss: (index:number)=>{
      console.log('index')
  }
}) */


const root = ref<HTMLElement | null>(null);

onMounted(() => {
    //this.showNotice();
    setTimeout(() => {

        /* const wrapper = root.value!.parentElement!;
        
        render(null, wrapper);
        removeElement(wrapper)  */

        //emit("ondismiss", props.toast.index)
        dismiss()
    }, props.toast.duration)

    //console.log(root.value?.outerHTML);
})


const dismiss = () => {
    const wrapper = root.value!;
    // unmount the component
    render(null, wrapper);
    removeElement(wrapper)

    //emit("ondismiss",props.toast.index)
}



</script>

<style>
.toast{
    background-color: white;
}
</style>