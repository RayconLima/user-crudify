import BaseService from "./base.service";

export interface User {
  id: number;
  iti: number;
  name: string;
  email: string;
}

interface UserServiceResponse {
  data: User | User[];
}

interface AxiosResponse {
  data: any;
  status: number;
  statusText: string;
  headers: any;
  config: any;
  request: any;
}

interface AxiosError {
  response: AxiosResponse;
  request: any;
  message: string;
  config: any;
  code: string | null;
}

export default class UserService extends BaseService {
  static async getUsers(): Promise<User[]> {
    return new Promise((resolve, reject) => {
      this.request({ auth: true })
        .getInstance()
        .get('/users')
        .then((response: AxiosResponse) => {
          resolve(response.data);
        })
        .catch((error: AxiosError) => reject(error.response));
    });
  }

  static async createUser(user: User): Promise<UserServiceResponse> {
    return new Promise((resolve, reject) => {
      this.request({ auth: true })
        .getInstance()
        .post('/users', user)
        .then((response: AxiosResponse) => {
          resolve(response.data);
        })
        .catch((error: AxiosError) => reject(error.response));
    });
  }

  static async updateUser(user: User): Promise<UserServiceResponse> {
    return new Promise((resolve, reject) => {
      this.request({ auth: true })
        .getInstance()
        .put(`/users/${user.id}`, user)
        .then((response: AxiosResponse) => {
          resolve(response.data);
        })
        .catch((error: AxiosError) => reject(error.response));
    });
  }

  static async getUser(userId: number): Promise<User> {
    return new Promise((resolve, reject) => {
      this.request({ auth: true })
        .getInstance()
        .get(`/users/${userId}`)
        .then((response: AxiosResponse) => {
          resolve(response.data.data);
        })
        .catch((error: AxiosError) => reject(error.response));
    });
  }

  static async destroyUser (userId: number): Promise<UserServiceResponse> {
    return new Promise((resolve, reject) => {
      this.request({ auth: true })
        .getInstance()
        .delete(`/users/${userId}`)
        .then((response: AxiosResponse) => {
          resolve(response.data);
        })
        .catch((error: AxiosError) => reject(error.response));
    });
  }
}