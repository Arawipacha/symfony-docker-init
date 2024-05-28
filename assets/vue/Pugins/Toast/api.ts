import ToastComponent from './Components/Toast.vue'
import ToastContainer from './Components/Container.vue'
import { createComponent } from './helpers';
import {ToastMessage} from './Models'
import {  computed, reactive, ref, watch } from 'vue';


let messages= reactive<ToastMessage[]>([]);
export const useToast = (globalProps = {}) => {
    
     
    return {
        
        mount(){
            //const propsData = Object.assign({}, globalProps);
            const defaultProps = {
                messages: messages,
              };
              
              console.log(globalProps)
              const propsData = Object.assign({}, defaultProps, globalProps);
            const instance= createComponent(ToastContainer, propsData, document.body) as any; 
            
            return {
                dismiss: instance.ctx.dismiss
                }   
        },

        removeAt(index: number){
            //messages.filter(item=>item.index==index);
            debugger
            messages.splice(index, 1)
            
             //delete messages[index];
            console.log(messages);
        },

      open(options: Object) {
        let message = null;
        debugger
        if (typeof options === 'string') message = options;
  
        const defaultProps = {
          message
        };

        const propsData = Object.assign({}, defaultProps, globalProps, options);
  
        const instance= createComponent(ToastComponent, propsData, document.body) as any;
  
        return {
          dismiss: instance.ctx.dismiss
        }
      },
      clear() {
        //eventBus.emit('toast-clear')
      },
      success(message: string, options = {}) {
        messages.push({
            index: Math.random(),
            message,
            duration: 3000,
            type: 'bg-success',
            ...options,
            
          });
        /* return this.open(Object.assign({}, {
          message,
          type: 'success'
        }, options)) */
      },
      error(message:string, options = {}) {
        /* return this.open(Object.assign({}, {
          message,
          type: 'error'
        }, options)) */
        messages.push({
          index: Math.random(),
          message,
          duration: 30000,
          type: 'bg-danger',
          ...options,
          
        });
      },
      info(message:string, options = {}) {
        messages.push({
          index: Math.random(),
          message,
          duration: 3000,
          type: 'bg-info',
          ...options,
          
        });
        /* return this.open(Object.assign({}, {
          message,
          type: 'info'
        }, options)) */
      },
      warning(message:string, options = {}) {
        messages.push({
          index: Math.random(),
          message,
          duration: 3000,
          type: 'bg-warning',
          ...options,
          
        });
        /* return this.open(Object.assign({}, {
          message,
          type: 'warning'
        }, options)) */
      },
      default(message:string, options = {}) {
        messages.push({
          index: Math.random(),
          message,
          duration: 3000,
          type: 'bg-default',
          ...options,
          
        });
        /* return this.open(Object.assign({}, {
          message,
          type: 'default'
        }, options)) */
      }
    }
  };