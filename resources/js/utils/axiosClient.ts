import axios from 'axios';

const axiosClient = axios.create({
    baseURL: import.meta.env.VITE_API_BASE_URL,
    withCredentials: true,
    headers: {
        Accept: 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
    },
});

// Ensure CSRF cookie is obtained before any request that needs it
axiosClient.interceptors.request.use(async (config) => {
    if (['post', 'put', 'delete', 'patch'].includes(config.method?.toLowerCase())) {
        await axios.get('/sanctum/csrf-cookie', {
            baseURL: import.meta.env.VITE_API_BASE_URL,
            withCredentials: true,
        });
    }
    return config;
});

export default axiosClient;
