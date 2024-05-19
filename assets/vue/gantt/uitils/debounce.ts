import { customRef } from 'vue'

export const  useDebouncedRef=(value: string, delay = 500) =>{
  let timeout:any;

  return customRef((track, trigger) => {
    return {
      get() {
        track()
        return value
      },
      set(newValue) {
        clearTimeout(timeout)
        timeout = setTimeout(() => {
          value = newValue
          trigger()
        }, delay)
      }
    }
  })
}