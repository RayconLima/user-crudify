import { ActionContext } from 'vuex';
import AuthService from "@/infra/services/auth.service";

interface User {
  iti: string;
  name: string;
  email: string;
}

interface LoginParams {
  email: string;
  password: string;
}

interface State {
  user: User | null;
  loggedIn: boolean;
}

interface AuthModule {
  state: State;
  mutations: {
    SET_USER(state: State, user: User): void;
    LOGOUT(state: State): void;
  };
  actions: {
    login({ commit, dispatch }: ActionContext<State, LoginParams>, params: LoginParams): Promise<void>;
    getMe({ commit }: ActionContext<State, any>): Promise<void>;
    logout({ commit }: ActionContext<State, any>): Promise<void>;
  };
}

const authModule: AuthModule = {
  state: {
    user: null,
    loggedIn: false,
  },
  mutations: {
    SET_USER(state, user) {
      state.user = user;
      state.loggedIn = true;
    },
    LOGOUT(state) {
      state.user = null;
      state.loggedIn = false;
    },
  },
  actions: {
    async login({ commit, dispatch }, params) {
      try {
        await AuthService.auth(params);
        await dispatch('getMe');
      } catch (error) {
        console.error(error);
      }
    },
    async getMe({ commit }) {
      try {
        const user = await AuthService.getMe();
        commit('SET_USER', user);
      } catch (error) {
        console.error(error);
      }
    },
    async logout({ commit }) {
      try {
        await AuthService.logout();
        commit('LOGOUT');
      } catch (error) {
        console.error(error);
      }
    },
  },
};

export default authModule;