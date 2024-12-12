import UserService from "@/infra/services/user.service";

// Tipos
export interface User {
  id: number;
  iti: number;
  name: string;
  email: string;
}

interface State {
  user: User | null;
  users: User[];
}

interface Mutations {
  SET_USER(state: State, user: User): void;
  SET_USERS(state: State, users: User[]): void;
}

interface Actions {
  getUsers({ commit }: any): Promise<void>;
  getUser({ commit }: any, id: number): Promise<void>;
  createUser({ commit }: any, user: User): Promise<void>;
  updateUser({ commit }: any, user: User): Promise<void>;
  deleteUser({ commit }: any, id: number): Promise<void>;
}

// Estado inicial
const initialState: State = {
  user: null,
  users: [],
};

// Mutações
const mutations: Mutations = {
  SET_USER(state, user) {
    state.user = user;
  },
  SET_USERS(state, users) {
    state.users = users;
  },
};

// Ações
const actions: Actions = {
  async getUsers({ commit }) {
    try {
      const users = await UserService.getUsers();
      commit('SET_USERS', users);
    } catch (error) {
      console.error(error);
    }
  },
  async getUser({ commit }, id) {
    try {
      const user = await UserService.getUser(id);
      commit('SET_USER', user);
    } catch (error) {
      console.error(error);
    }
  },
  async createUser({ commit, dispatch }, user) {
    try {
      await UserService.createUser(user);
      await dispatch('getUsers');
    } catch (error) {
      console.error(error);
    }
  },
  async updateUser({ commit, dispatch }, user) {
    try {
      await UserService.updateUser(user);
      await dispatch('getUsers');
    } catch (error) {
      console.error(error);
    }
  },
  async deleteUser({ commit, dispatch }, id) {
    try {
      await UserService.destroyUser(id);
      await dispatch('getUsers');
    } catch (error) {
      console.error(error);
    }
  },
};

// Módulo de User
export default {
  namespaced: true,
  state: initialState,
  mutations,
  actions,
};