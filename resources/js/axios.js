// axios
import axios from 'axios'
// require('dotenv').config();

// const domain = document.documentElement.getAttribute('data-base-url')

token =  localStorage.getItem("token")
const axiosInstance =  axios.create({
  baseURL: 'http://localhost/todos/public/',
  headers: {
    'content-type': 'application/json',
    'accept'      : 'application/json',
    'Access-Control-Allow-Origin' : "*",
    'Authorization': `Bearer ${token}`
  }
})

// axiosInstance.interceptors.request.use(
//     (config) => {
//       const token = localStorage.getItem("token")
//       const auth = token ? `Bearer ${localStorage.getItem("token")}` : '';
//       config.headers.common['Authorization'] = auth;
//       return config;
//     },
//     (error) => Promise.reject(error),
// );

export default axiosInstance;
