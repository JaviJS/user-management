import axios from "axios";
import { API_URL } from "../helpers/_api";

class UserService {
  /**
   * Obtiene la lista de usuarios desde el servidor.
   * @param {string} token - Token de autorización para la autenticación.
   * @returns {Promise} - Promesa que resuelve con los datos de los usuarios.
   */
  async getUsers(token) {
    return axios
      .get(API_URL + "users", {
        headers: { Authorization: `Bearer ${token}` },
      })
      .then((response) => {
        return response.data;
      });
  }

  /**
   * Crea un nuevo usuario en el servidor.
   * @param {object} data - Datos del usuario a enviar.
   * @returns {Promise} - Promesa que resuelve con los datos del usuario creado.
   */
  async createUser(data) {
    return axios.post(API_URL + "users", data).then((response) => {
      return response.data;
    });
  }

  /**
   * Elimina un usuario específico del servidor.
   * @param {string} idUser - ID del usuario a eliminar.
   * @param {string} token - Token de autorización para la autenticación.
   * @returns {Promise} - Promesa que resuelve con los datos de confirmación de eliminación.
   */
  async deleteUser(idUser, token) {
    return axios
      .delete(API_URL + "users/" + idUser, {
        headers: { Authorization: `Bearer ${token}` },
      })
      .then((response) => {
        return response.data;
      });
  }

  /**
   * Obtiene los detalles de un usuario específico desde el servidor.
   * @param {string} idUser - ID del usuario a obtener.
   * @param {string} token - Token de autorización para la autenticación.
   * @returns {Promise} - Promesa que resuelve con los detalles del usuario.
   */
  async getUser(idUser, token) {
    return axios
      .get(API_URL + "users/" + idUser, {
        headers: { Authorization: `Bearer ${token}` },
      })
      .then((response) => {
        return response.data;
      });
  }

  /**
   * Actualiza los datos de un usuario específico en el servidor.
   * @param {object} data - Nuevos datos del usuario a enviar.
   * @param {string} idUser - ID del usuario a actualizar.
   * @param {string} token - Token de autorización para la autenticación.
   * @returns {Promise} - Promesa que resuelve con los datos actualizados del usuario.
   */
  async editUser(data, idUser, token) {
    return axios
      .post(API_URL + "users/update/" + idUser, data, {
        headers: { Authorization: `Bearer ${token}` },
      })
      .then((response) => {
        return response.data;
      });
  }

  /**
   * Cambia la contraseña de un usuario específico en el servidor.
   * @param {object} data - Datos necesarios para cambiar la contraseña del usuario.
   * @param {string} idUser - ID del usuario cuya contraseña se cambiará.
   * @param {string} token - Token de autorización para la autenticación.
   * @returns {Promise} - Promesa que resuelve con los datos de confirmación del cambio de contraseña.
   */
  async changePassword(data, idUser, token) {
    return axios
      .post(API_URL + "users/change-password/" + idUser, data, {
        headers: { Authorization: `Bearer ${token}` },
      })
      .then((response) => {
        return response.data;
      });
  }

  /**
   * Obtiene la lista de estados de usuario desde el servidor.
   * @returns {Promise} - Promesa que resuelve con los datos de los estados de usuario.
   */
  async getStatus() {
    return axios.get(API_URL + "users/find/list-status").then((response) => {
      return response.data;
    });
  }

  /**
   * Obtiene la lista de roles de usuario desde el servidor.
   * @returns {Promise} - Promesa que resuelve con los datos de los roles de usuario.
   */
  async getRoles() {
    return axios.get(API_URL + "users/find/list-roles").then((response) => {
      return response.data;
    });
  }
}

export default new UserService();
