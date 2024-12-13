import BaseService from './base.service'

export default class UsersService extends BaseService {
  static async getUsers(params) {
    return new Promise((resolve, reject) => {
      this.request({ auth: true })
        .get('/users', params)
        .then((response) => {
          resolve(response)
        })
        .catch((error) => {
          reject(error.response)
        })
    })
  }

  static async storeUser(params) {
    return new Promise((resolve, reject) => {
      this.request({ auth: true })
        .post('/users', params)
        .then((response) => {
          resolve(response)
        })
        .catch((error) => {
          reject(error.response)
        })
    })
  }

  static async updateUser(id, params) {
    return new Promise((resolve, reject) => {
      this.request({ auth: true })
        .put(`/users/${id}`, params)
        .then((response) => {
          resolve(response)
        })
        .catch((error) => {
          reject(error.response)
        })
    })
  }
}
