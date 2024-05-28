<template>
    
        <ToastComponent  v-for="(toast, index) in messages" :toast="toast" :key="index" @ondismiss="handlerDismiss(index)"></ToastComponent>
    
</template>
<script setup lang="ts">
import { computed, inject, watch } from 'vue';
import { ToastMessage } from '../Models';
import { useToast } from '../api';
import ToastComponent from './Toast.vue'

const stateToast= useToast()


const props=defineProps<{messages:ToastMessage[]}>();

const handlerDismiss=(index: number)=>{
    
    stateToast.removeAt(index);
}
</script>