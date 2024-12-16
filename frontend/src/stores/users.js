import { defineStore } from 'pinia'
import UsersService from '@/infra/services/user.service'

export const useUsersStore = defineStore('users', {
  state: () => ({
    users: [],
  }),
  getters: {
    getTotalUsers: (state) => state.users.length,
    getPendingUsers: (state) => state.users.filter((user) => user.status === "pending").length,
    getActiveUsers: (state) => state.users.filter((user) => user.status === "active").length,
  },
  actions: {
    getUsers() {
      return UsersService.getUsers().then((response) => {
        this.users = response.data.data
        return this.users
      })
    },
    async saveUser(params) {
      await UsersService.storeUser(params).then((response) => {
        return (this.users = response.data.data)
      })
    },
    async updateUser(id, params) {
      await UsersService.updateUser(id, params).then((response) => {
        return (this.users = response.data.data)
      })
    },
    async destroyUser(id) {
      await UsersService.destroy(id).then((response) => {
        return (this.users = response.data.data)
      })
    },
  },
})
