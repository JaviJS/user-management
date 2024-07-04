import axios from "axios";
import { API_URL } from "../helpers/_api";

class AuthService {

  /**
   * Realiza una solicitud de inicio de sesión al servidor.
   * @param {object} data - Datos necesarios para iniciar sesión (correo electrónico y contraseña).
   * @returns {Promise} - Promesa que resuelve con el token de autenticación y los datos del usuario.
   */
  async login(data) {
    return axios.post(API_URL + "login", data).then((response) => {
      const data = {
        token: response.data.authorization.token,
        user: response.data.user,
      };
      return data;
    });
  }

  /**
   * Realiza una solicitud para cerrar sesión del usuario actual.
   * @param {string} token - Token de autenticación para la autorización del usuario.
   * @returns {Promise} - Promesa que resuelve con el token de autenticación el cierre de sesión.
   */
  async logout(token) {
    return axios
      .post(
        API_URL + "logout",
        {},
        {
          headers: { Authorization: `Bearer ${token}` },
        }
      )
      .then((response) => {
        return response.data;
      });
  }
}

export default new AuthService();
