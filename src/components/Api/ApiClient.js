import axios from 'axios';

export const apiClient = axios.create({
    baseURL: "http://juniortest-omar-anas.infinityfreeapp.com/php"
})