import axios from "axios";
import Cookies from "js-cookie"

export default axios.create({
    baseURL: "http://localhost:8000/api/v1",
    headers: {
        "Content-type": "application/json",
        "Authorization": `Bearer ${Cookies.get("token")}`
    }
});
