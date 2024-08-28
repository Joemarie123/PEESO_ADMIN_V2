import { defineStore } from "pinia";
import axios from "axios";

export const useLoginCheck = defineStore("SignUpAccouteStore", {
  state: () => ({
    Check_Login: "",
    OtpVerify: [],
    SaveData: [],
    RetrievedData: [],
    LogIn: [],
  }),
  getters: {
    // doubleCount: (state) => state.counter * 2,
  },
  actions: {
    async LoginChecking(payload) {
      // `http://10.0.1.26:82/HRPORTAL/login.php`
      let res = await axios.post(
        `http://10.0.1.26:82/peesoportal/registration/admin/logincheck.php`,
        payload
      );
      console.log("Email Duplicate Checking", res.data.email_duplicate);
      console.log("Login Duplicate Checking", res.data.login_duplicate);

      if (
        res.data.email_duplicate == false &&
        res.data.login_duplicate == true
      ) {
        return 1;
      } else if (
        res.data.email_duplicate == true &&
        res.data.login_duplicate == false
      ) {
        return 2;
      } else if (
        res.data.email_duplicate == true &&
        res.data.login_duplicate == true
      ) {
        return 3;
      } else if (
        res.data.email_duplicate == false &&
        res.data.login_duplicate == false
      ) {
        return 4;
      }
    },

    async Login_Store(payload) {
      // `http://10.0.1.26:82/HRPORTAL/login.php`
      let res = await axios.post(
        `http://10.0.1.26:82/peesoportal/login/admin/login.php`,
        payload
      );
      this.LogIn = res.data;
      console.log("LOG IN Store", res.data);
    },

    async VerifyOtp(payload) {
      // `http://10.0.1.26:82/HRPORTAL/login.php`
      let res = await axios.post(
        `http://10.0.1.26:82/peesoportal/registration/admin/otp.php`,
        payload
      );
      this.OtpVerify = res.data;
      console.log("Verify OTP", this.OtpVerify);
    },

    async SaveToDatabase(payload) {
      // `http://10.0.1.26:82/HRPORTAL/login.php`
      let res = await axios.post(
        `http://10.0.1.26:82/peesoportal/registration/admin/register.php`,
        payload
      );
      this.SaveData = res.data;
      console.log("Store Databse Save", res.data);
    },

    async RetrievedData_function(payload) {
      // `http://10.0.1.26:82/HRPORTAL/login.php`
      let res = await axios.post(
        `http://10.0.1.26:82/peesoportal/dashboard/admin/GetCompanyinfo.php`,
        payload
      );
      this.RetrievedData = res.data;
      /*  console.log("Retrieved Data", res.data); */
    },
  },
  persist: true,
});
