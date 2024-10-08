import { defineStore } from "pinia";
import axios from "axios";

export const useLoginCheck = defineStore("SignUpAccouteStore", {
  state: () => ({
    Check_Login: "",
    OtpVerify: [],
    SaveData: [],
    RetrievedData: [],
    LogIn: [],
    WE: [],
    SH: [],
    EB: [],
    PI: [],
    LD: [],
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

    //Work Experience
    async WorkExperience_Data(payload) {
      let res = await axios.post(
        `http://10.0.1.26:82/peesoportal/pds/client/workexperience.php`,
        payload
      );
      this.WE = res.data;
      console.log("Work Experience =>", res.data);
    },

    //SKILLS_DATA
    async SkillsData(payload) {
      let res = await axios.post(
        `http://10.0.1.26:82/peesoportal/pds/client/skills.php`,
        payload
      );
      this.SH = res.data;
      console.log("SkillsData => ", res.data);
    },

    //EDUCATIONAL_DATA
    async EducationalData(payload) {
      let res = await axios.post(
        `http://10.0.1.26:82/peesoportal/pds/client/education.php`,
        payload
      );
      this.EB = res.data;
      console.log("EducationalData => ", res.data);
    },

    //PERSONAL_DATA
    async PersonalData(payload) {
      let res = await axios.post(
        `http://10.0.1.26:82/peesoportal/pds/client/personaldata.php`,
        payload
      );
      this.PI = res.data;
      console.log("PersonalData=>", res.data.personalRecord);
      /*   let data = new FormData();
      data.append("LoginID", res.data.personalRecord.LoginID);
      this.RetrievedData_function(data); */
    },

    //Work Experience
    async WorkExperience_Data(payload) {
      let res = await axios.post(
        `http://10.0.1.26:82/peesoportal/pds/client/workexperience.php`,
        payload
      );
      this.WE = res.data;
      console.log("Work Experience =>", res.data);
    },

    //TRAININGS_DATA
    async TrainingData(payload) {
      let res = await axios.post(
        `http://10.0.1.26:82/peesoportal/pds/client/trainings.php`,
        payload
      );
      this.LD = res.data;
      console.log("TrainingData => ", res.data);
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
