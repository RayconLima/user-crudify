import { defineStore } from 'pinia';
import UsersService from '@/infra/services/user.service'

export const useUsersStore = defineStore('users', {
    state: () => ({
        users: [],
    }),
    actions: {
        getUsers() {
            return UsersService.getUsers().then((response) => {
                this.users = response.data.data
                return this.users;
            })
        },
        async saveUser(params) {
            await UsersService
                .storeUser(params)
                .then(response => {
                    return this.users = response.data.data;
                })
        },
        // saveUser
    }
});