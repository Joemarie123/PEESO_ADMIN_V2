import { defineStore } from "pinia";
import axios from "axios";

export const useDashBoard = defineStore("DashBoardStore", {
  state: () => ({
    Server_Date_TIme: [],
    GetAppointment_Array: [],
    appointment: [],
    PotentialApplicant: [],
  }),
  getters: {
    // doubleCount: (state) => state.counter * 2,
  },
  actions: {
    async Set_Appointment_Store() {
      // `http://10.0.1.26:82/HRPORTAL/login.php`
      let res = await axios.get(
        `http://10.0.1.26:82/peesoportal/dashboard/admin/getdatetime.php`
      );
      this.Server_Date_TIme = res.data;
      /*   console.log("GET SERVER DATE TIME", res.data); */
    },

    async GetAppointment_Store(payload) {
      // `http://10.0.1.26:82/HRPORTAL/login.php`
      let res = await axios.post(
        `http://10.0.1.26:82/peesoportal/dashboard/admin/getappointment.php`,
        payload
      );
      this.GetAppointment_Array = res.data;
      this.appointment = res.appointment;
      /*  console.log("Get Appointment", res.data); */
    },

    async GetPotentialApplicant(payload) {
      // `http://10.0.1.26:82/HRPORTAL/login.php`
      let res = await axios.post(
        `http://10.0.1.26:82/peesoportal/dashboard/admin/getappointment.php`,
        payload
      );

      this.PotentialApplicant = res.data;
      /*   console.log("Get Appointment", res.data); */
    },
  },
  persist: true,
});
