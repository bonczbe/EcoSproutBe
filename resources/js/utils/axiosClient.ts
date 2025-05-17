import axios from 'axios';

const axiosClient = axios.create({
    baseURL: import.meta.env.VITE_API_BASE_URL,
    withCredentials: true, // This is crucial for Sanctum
});

// Add request interceptor to handle CSRF token
axiosClient.interceptors.request.use((config) => {
    if (['post', 'put', 'delete', 'patch'].includes(config.method?.toLowerCase())) {
        return axios.get('/sanctum/csrf-cookie').then(() => config);
    }
    return config;
});

export default axiosClient;
