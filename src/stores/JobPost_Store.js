import { defineStore } from "pinia";
import axios from "axios";

export const useJobpost = defineStore("JobPostStore", {
  state: () => ({
    jobpost_Array: [],
    RetrieveJobs_Array: [],
    GetJobs_Array: [],
    UpdateApplicant_Array: [],
    PotentialApplicant_Array: [],
    SetAppointment_Array: [],

    /*  selectedJobID: 0,  */
  }),
  getters: {
    // doubleCount: (state) => state.counter * 2,
  },
  actions: {
    /*  setSelectedJobID(jobID) {
      this.selectedJobID = jobID;
      console.log("State JOB ID", this.selectedJobID);
    }, */

    async Set_Appointment_Store(payload) {
      // `http://10.0.1.26:82/HRPORTAL/login.php`
      let res = await axios.post(
        `http://10.0.1.26:82/peesoportal/Appointment/admin/SetAppointment.php`,
        payload
      );
      this.SetAppointment_Array = res.data;
      console.log("Set Appointment Store", res.data);
    },

    async SaveToDatabase_jobPost(payload) {
      // `http://10.0.1.26:82/HRPORTAL/login.php`
      let res = await axios.post(
        `http://10.0.1.26:82/peesoportal/jobs/admin/createjobs.php`,
        payload
      );
      this.jobpost_Array = res.data;
      console.log("Job Post Save to Database", res.data);
    },

    async Retrieve_Jobs(payload) {
      // `http://10.0.1.26:82/HRPORTAL/login.php`
      let res = await axios.post(
        `http://10.0.1.26:82/peesoportal/dashboard/admin/getjobs.php`,
        payload
      );
      this.RetrieveJobs_Array = res.data;
      console.log("Retrieve Job Post", res.data);
    },

    async Get_Applicant(payload) {
      // `http://10.0.1.26:82/HRPORTAL/login.php`
      let res = await axios.post(
        `http://10.0.1.26:82/peesoportal/jobs/admin/getapplicants.php`,
        payload
      );
      this.GetJobs_Array = res.data;
      /*   console.log("Get Job Post", res.data); */
    },

    async Potential_Applicant_Store(payload) {
      // `http://10.0.1.26:82/HRPORTAL/login.php`
      let res = await axios.post(
        `http://10.0.1.26:82/peesoportal/jobs/admin/getapplicants.php`,
        payload
      );
      this.PotentialApplicant_Array = res.data;
      console.log("Potential_Applicant_Store", res.data);
    },

    async Update_Applicant(payload) {
      // `http://10.0.1.26:82/HRPORTAL/login.php`
      let res = await axios.post(
        `http://10.0.1.26:82/peesoportal/jobs/admin/updateapplicant.php`,
        payload
      );
      this.UpdateApplicant_Array = res.data;
      /*   console.log("Get Job Post", res.data); */
    },
  },
  persist: true,
});
