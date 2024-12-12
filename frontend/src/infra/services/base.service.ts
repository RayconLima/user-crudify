import Http from "./http.init";

interface BaseServiceConfig {
  auth: boolean;
}

class BaseService {
  private instance: Http;

  constructor() {
    this.instance = new Http({ auth: false });
  }

  static request(status: BaseServiceConfig = { auth: false }): Http {
    if (!status) {
      throw new Error('Configuração não encontrada');
    }
    return new Http(status);
  }
}

export default BaseService;