import { defineStore } from 'pinia'

interface Message{
  title: string
  body: string
  type: 'success' | 'danger' | 'warning' | 'info',
}
interface State {
  message: Message,
  show: boolean
  buttons: 'close' | 'saveclose'
}

export const useMessageStore = defineStore('modal/message', {
  // convert to a function
  state: (): State => ({
    message: {
      title: 'Message',
      body: '',
      type: 'info'
    },
    buttons: 'close',
    show: false
  }),
  getters: {
    // firstName getter removed, no longer needed
    getShow: (state) => state.show,
    getMessage: (state) => state.message,
    // must define return type because of using `this`
  },
  actions: {
    setMessage(message: Message){
      this.message={
        ...message
      }
      this.showModal();
    },

    showModal(){
      this.show=true;
    },
    
    hideModal(){
      this.show=false;
    },

    // easily reset state using `$reset`
    clearUser () {
      this.$reset()
    }
  }
})