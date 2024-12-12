import axios from 'axios';
import { URL_API, TOKEN_NAME } from '../config';

interface HttpConfig {
  auth: boolean;
}

class Http {
  private instance: any;

  constructor(status: HttpConfig) {
    const token = localStorage.getItem(TOKEN_NAME);

    if (status.auth && !token) {
      throw new Error('Token não encontrado');
    }

    const headers = status.auth
      ? {
          Authorization: `Bearer ${token}`,
        }
      : {};

    this.instance = axios.create({
      baseURL: URL_API,
      headers,
    });
  }

  getInstance(): any {
    return this.instance;
  }
}

export default Http;