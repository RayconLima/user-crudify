import Http from './http.init';

class AuthService {
  private http: any;

  constructor() {
    this.http = new Http({ auth: true });
  }

  async login(email: string, password: string) {
    try {
      const response = await this.http.getInstance().post('/login', {
        email,
        password,
      });
      return response.data;
    } catch (error) {
      throw error;
    }
  }

  async register(name: string, email: string, password: string) {
    try {
      const response = await this.http.getInstance().post('/register', {
        name,
        email,
        password,
      });
      return response.data;
    } catch (error) {
      throw error;
    }
  }

  async logout() {
    try {
      const response = await this.http.getInstance().post('/logout');
      return response.data;
    } catch (error) {
      throw error;
    }
  }
}

export default AuthService;