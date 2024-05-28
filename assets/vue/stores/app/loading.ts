import { defineStore } from 'pinia'

interface State {
  loading: boolean
}

export const useLoadingStore = defineStore('store/loading', {
  // convert to a function
  state: (): State => ({
    loading: false
  }),
  getters: {
    isLoading: (state) => state.loading,
  },
  actions: {
    showLoading(){  
       this.loading=true;
    },
    
    clearloading () {
      this.$reset()
    }
  }
})