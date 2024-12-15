import { TOKEN_NAME } from '@/config'
import BaseService from './base.service'
export default class AuthService extends BaseService {
  static async login(params) {
    return new Promise((resolve, reject) => {
      this.request()
        .post('/login', params)
        .then((response) => {
          // localStorage.setItem(TOKEN_NAME, response.data.token)
          resolve(response)
        })
        .catch((error) => reject(error.response))
    })
  }

  static logout() {
    return new Promise((resolve, reject) => {
      this.request({ auth: true })
        .post('/logout')
        .then((response) => {
          resolve(response)
        })
        .catch((error) => reject(error.response))
    })
  }

  static async register(params) {
    return new Promise((resolve, reject) => {
      this.request()
        .post('/register', params)
        .then((response) => {
          resolve(response)
        })
        .catch((error) => reject(error.response))
    })
  }

  static async verifyEmailfromToken(token) {
    return new Promise((resolve, reject) => {
        this.request({ auth: true })
            .post('/verify-email', { token: token })
            .then(response => {
                resolve(response.data)
            })
            .catch(error => {
                localStorage.removeItem(TOKEN_NAME)
                reject(error.response)
            })
    })
  }

  static async getMe() {
    return new Promise((resolve, reject) => {
      this.request({ auth: true })
        .get('/me')
        .then((response) => {
          resolve(response.data)
        })
        .catch((error) => {
          localStorage.removeItem(TOKEN_NAME)
          reject(error.response)
        })
    })
  }

  static async updatePassword(params) {
    return new Promise((resolve, reject) => {
      this.request({ auth: true })
        .post('/me/password', params)
        .then((response) => {
          resolve(response.data)
        })
        .catch((error) => {
          reject(error.response)
        })
    })
  }

  static async updateProfilePhoto(params) {
    return new Promise((resolve, reject) => {
      this.request({ auth: true })
        .post('/me/upload-avatar', params, {})
        .then((response) => {
          resolve(response.data)
        })
        .catch((error) => {
          reject(error.response)
        })
    })
  }

  static async forgotPassword(params) {
    return new Promise((resolve, reject) => {
      this.request()
        .post('/forgot-password', {email: params})
        .then((response) => {
          resolve(response)
        })
        .catch((error) => reject(error.response))
    })
  }

  static async resetPassword(params) {
    return new Promise((resolve, reject) => {
      this.request()
        .post('/reset-password', params)
        .then(response => {
          resolve(response)
        })
        .catch(error => reject(error.response))
    })
  }
}
