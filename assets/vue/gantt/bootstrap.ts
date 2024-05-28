//import 'bootstrap';
import Axios, {AxiosStatic} from 'axios';

declare global {

    interface Window {
        axios: AxiosStatic;
    }

    interface Element {
        content: string;
    }
}


declare var window: Window;
window.axios = Axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

const token: Element | null = document.head.querySelector('meta[name="csrf-token"]');


