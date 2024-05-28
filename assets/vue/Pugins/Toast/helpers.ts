import {RendererNode, h, render} from 'vue';

export function removeElement(el:HTMLElement) {
  if (typeof el.remove !== 'undefined') {
    el.remove()
  } else {
    el.parentNode?.removeChild(el)
  }
}

export function createComponent(component:RendererNode, props:{}, parentContainer:HTMLElement, slots = {}) {
  const vNode = h(component, props, slots)

  const container = document.createElement('div');
  
  container.classList.add('toasts-top-right','z-index-2', 'p-fixed')
  parentContainer.appendChild(container);
  render(vNode, container);

  return vNode.component
}
