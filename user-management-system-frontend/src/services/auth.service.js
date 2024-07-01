import axios from "axios";
import { API_URL } from "../helpers/_api";

class AuthService {
  async login(data) {
    return axios
      .post(API_URL + "login", data)
      .then((response) => {
        const data = {
          token: response.data.authorization.token,
          user: response.data.user,
        };
        return data;
      });
  }
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
