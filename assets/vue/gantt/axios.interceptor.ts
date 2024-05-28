import axios from 'axios';
import { useMessageStore } from './../stores/app/message';
import { useToast } from './../Pugins/Toast';

const stateToast = useToast();
//const stateModalMessage = useMessageStore();
axios.interceptors.response.use(function (response) {
    // Cualquier código de estado que este dentro del rango de 2xx causa la ejecución de esta función 
    // Haz algo con los datos de la respuesta

    return response;
  }, function (error) {
    // Cualquier código de estado que este fuera del rango de 2xx causa la ejecución de esta función
    // Haz algo con el error
    
    const {response:{data}} = error;
    let message= error.message;
    if(data.message){
        message=data.message;
    }

    /* stateModalMessage.setMessage({
        title: 'Error',
        body: message ,
        type: 'warning'
      }) */

      stateToast.error(message)

    return Promise.reject(error);
  });

  axios.interceptors.request.use(function (request) {
    // Cualquier código de estado que este dentro del rango de 2xx causa la ejecución de esta función 
    // Haz algo con los datos de la respuesta

    request.headers.set('Authorization','Bearer ' + 'ca9301a09cf804b066a310b14c9e7b464b8c4324a237d015b73e60a3214b9ab4')
    /* ={
      ...request.headers,
      Authorization: 'Bearer ' + 'ca9301a09cf804b066a310b14c9e7b464b8c4324a237d015b73e60a3214b9ab4'
  } */
    /*
    
    const isAllowUrl= request.url?.includes('/login');
    const token= localStorage.getItem('access_token');
    if(!isAllowUrl){
        request.headers={
            ...request.headers,
            Authorization: 'Bearer ' + token
        }
    }*/
    
    //console.log(request);
    return request;
  }, function (error) {
    // Cualquier código de estado que este fuera del rango de 2xx causa la ejecución de esta función
    // Haz algo con el error
    
    const {response:{data}} = error;
    let message= error.message;
    if(data.message){
        message=data.message;
    }

    /* stateModalMessage.setMessage({
        title: 'Error',
        body: message ,
        type: 'warning'
      }) */

      stateToast.error(message)
    return Promise.reject(error);
  });