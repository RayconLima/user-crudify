import { TOKEN_NAME } from "@/config";
import BaseService from "./base.service";
export default class AuthService extends BaseService {
    static async login(params) {
        return new Promise((resolve, reject) => {
            this.request()
                .post('/login', params)
                .then(response => {
                    // localStorage.setItem(TOKEN_NAME, response.data.token)
                    resolve(response)
                })
                .catch(error => reject(error.response))
        })
    }

    static logout() {
        return new Promise((resolve, reject) => {
            this.request({ auth: true })
                .post('/logout')
                .then(response => {
                    resolve(response)
                })
                .catch(error => reject(error.response))
        })
    }

    static async register({ plan_id, name, email, password }) {
        return new Promise((resolve, reject) => {
            this.request()
                .post('/register', { plan_id, name, email, password })
                .then(response => {
                    resolve(response)
                })
                .catch(error => reject(error.response))
        })
    }

    static async getMe() {
        return new Promise((resolve, reject) => {
            this.request({ auth: true })
                .get('/me')
                .then(response => {
                    resolve(response.data)
                })
                .catch(error => {
                    localStorage.removeItem(TOKEN_NAME)
                    reject(error.response)
                })
        })
    }
}