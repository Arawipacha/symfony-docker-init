import ToastComponent from './Components/Toast.vue'
import { VueElement, createApp, h, render } from "vue"
import { useToast } from './api';

import('./toast.css')




/* export const useToast = (globalProps = {}) => {
  return {
    open(options:{}) {
      let message = null;
      if (typeof options === 'string') message = options;

      const defaultProps = {
        message
      };

      const propsData = Object.assign({}, defaultProps, globalProps, options);

      const instance:any = createComponent(ToastComponent, propsData, document.body);

      return {
        dismiss: instance.ctx.dismiss
      }
    },
    
    
  }
};
 */
const ToastPlugin = {
    install: (app:any, options = {}) => {
      let instance = useToast(options);
      
      app.config.globalProperties.$toast = instance;
      app.provide('$toast', instance);
      
      //const instance= createComponent(ToastComponent,options, document.body)
      //app.provide('$toast', instance)
      instance.mount();
      //debugger
      //console.log(component)
    }
  }
  
  /* export function createComponent(component: any, props:any, parentContainer:HTMLElement, slots = {}) {
    
      const vNode = h(component, props, slots)

      //const top_right= parentContainer.querySelector(".toasts-top-right");
    
      const container = document.createElement('div');
      container.classList.add('toasts-top-right')

      parentContainer.appendChild(container);
      render(vNode, container);
      //createApp(component).mount(parentContainer);
      return vNode.component
  
    
    
  } */


  

  export default ToastPlugin;
  export {ToastPlugin, ToastComponent, useToast}
  //export {useToast, ToastPlugin, ToastComponent, ToastPositions}