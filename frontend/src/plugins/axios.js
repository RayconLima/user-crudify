import axios from 'axios';
// import {errorMessage} from '@/utils/helpers';

axios.defaults.baseURL          = import.meta.env.VITE_APP_URL_API
axios.defaults.withCredentials  = true;

axios.interceptors.response.use(function (response) {
  return response;
}, function (error) {
  const response = error.response
//   const message = errorMessage(response.data.error)

  return Promise.reject({
    // message,
    status: response?.status
  });
});