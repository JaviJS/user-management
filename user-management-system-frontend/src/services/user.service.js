import axios from "axios";
import { API_URL } from "../helpers/_api";

class UserService {
  async getUsers(token) {
    return axios.get(API_URL + "users", {
      headers: { Authorization: `Bearer ${token}` },
    }).then((response) => {
      return response.data;
    });
  }

  async createUser(data) {
    return axios.post(API_URL + "users", data).then((response) => {
      return response.data;
    });
  }

  async deleteUser(idUser, token) {
    return axios.delete(API_URL + "users/" + idUser, {}, {
      headers: { Authorization: `Bearer ${token}` },
    }).then((response) => {
      return response.data;
    });
  }
  async getUser(idUser) {
    return axios.get(API_URL + "users/" + idUser, {},{
      headers: { Authorization: `Bearer ${token}` },
    }).then((response) => {
      return response.data;
    });
  }
  async editUser(data, idUser, token) {
    return axios
      .post(API_URL + "users/update/" + idUser, data, {
        headers: { Authorization: `Bearer ${token}` },
      })
      .then((response) => {
        return response.data;
      });
  }
  async changePassword(data, idUser, token) {
    return axios
      .post(API_URL + "users/change-password/" + idUser, data, {
        headers: { Authorization: `Bearer ${token}` },
      })
      .then((response) => {
        return response.data;
      });
  }
  async getStatus() {
    return axios.get(API_URL + "users/find/list-status").then((response) => {
      return response.data;
    });
  }
  async getRoles() {
    return axios.get(API_URL + "users/find/list-roles").then((response) => {
      return response.data;
    });
  }
}

export default new UserService();
