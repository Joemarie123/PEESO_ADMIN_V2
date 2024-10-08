import { defineStore } from "pinia";
import axios from "axios";

export const useMycalendar = defineStore("MyCalendarStore", {
  state: () => ({
    Events_Calendar: [],
    ReSched: [],
    /*  selectedJobID: 0,  */
  }),
  getters: {},
  actions: {
    async SetCalendar_Events(payload) {
      // `http://10.0.1.26:82/HRPORTAL/login.php`
      let res = await axios.post(
        `http://10.0.1.26:82/peesoportal/appointment/admin/getappointment.php`,
        payload
      );
      this.Events_Calendar = res.data;
      console.log("Set My Calendar Store", res.data);
    },

    async Set_UpdateReschedule(payload) {
      // `http://10.0.1.26:82/HRPORTAL/login.php`
      let res = await axios.post(
        `http://10.0.1.26:82/peesoportal/appointment/admin/updatereschedule.php`,
        payload
      );
      this.ReSched = res.data;
      console.log("Re-Schedule Store", res.data);
    },
  },
  persist: true,
});
