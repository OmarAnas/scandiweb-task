import axios from 'axios';

export const apiClient = axios.create({
    baseURL: "https://juniortest-omar-anas.infinityfreeapp.com/php"
})