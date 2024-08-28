<template>
  <div class="q-pa-md">

    <!--  <div class="row">
      <p>View All JOBS</p>
    </div> -->
    <div class="row" style="margin-top: -50px">
      <h6>SCHEDULED INTERVIEWS</h6>
    </div>

    <div style="margin-top: -30px">
      <q-separator></q-separator>
    </div>

    <div class="row" style="margin-top: -20px">
      <div class="col-12">
        <div style="max-width: 800px; margin-left: 1px">
          <!-- </q-tabs> -->

          <div class="q-gutter-y-sm">
         

            <div style="margin-top: 38px">
              <div class="scrollable-container">
                <div class="q-gutter-md">
                  <q-card
                    v-for="jobPost in events"
                    :key="jobPost.ID"
                    class="q-mb-md custom-card_jobpost"
                  >
                    <div class="row">
                      <div class="col-7">
                        <q-card-section class="row items-center">
                          <img
                            style="max-width: 80px"
                            :src="
                              jobPost.pic
                                ? jobPost.pic
                                : 'public/defaultpic.jpg'
                            "
                            alt="Profile Picture"
                            :imgProps="{ width: '100px', height: '100px' }"
                          />
                          <div class="q-ml-sm">
                            <div class="text-h6 namecolor">
                              {{ jobPost.title }}
                            </div>
                            <div
                              class="text-subtitle2"
                              style="margin-top: -8px"
                            >
                              Salary: ₱ {{ jobPost.salary }}
                            </div>
                            <!--    <div
                              v-for="data in GetDate_me"
                              :key="data.id"
                              class="text-subtitle2"
                              style="margin-top: -1px"
                            >
                              Potential Applicant:
                              {{ GetDate_me.totalapplicant }}
                            </div> -->
                          </div>
                        </q-card-section>
                      </div>

                      <div class="col-5" style="margin-top: -1px">
                        <q-card-section class="row items-center">
                          <div>
                            <div
                              class="text-h6"
                              style="font-size: 13px; font-weight: 400"
                            >
                              Schedule Date
                            </div>
                            <div
                              class="text-subtitle2"
                              style="margin-top: -5px"
                            >
                              {{ formatDate(jobPost.start) }} /
                              {{ formatTime(jobPost.details) }}
                            </div>
                          </div>
                        </q-card-section>
                      </div>
                    </div>

                    <q-separator />
                  </q-card>
                </div>
              </div>
            </div>
            <!--     </q-tab-panel>
            </q-tab-panels> -->
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

import { useDashBoard } from "src/stores/DashBoard_Store";
import { useLoginCheck } from "src/stores/SignUp_Store";
import { ref, onMounted } from "vue";
import axios from "axios";

export default {
  name: "JobPostList",



  data() {
    return {
      search_jobpost: "",
      jobPosts: [],
      page: 1,
      limit: 10,
      hasMore: true,

      dayName: "",
      day: "",
      monthName: "",
      year: "",

      Server_day: "",
      Server_monthName: "",
      Server_year: "",
      Server_monthNumber: "",
      time: "",

      getAppointment_me: [],
      GetDate_me: [],

      events: [],

      users: [],
      page_1: 1,
      limit_1: 10, // Number of records per request
      hasMore_1: true, // To check if more data is available
      loading_1: false, // To prevent multiple simultaneous requests
    };
  },

  computed: {

  },

  methods: {
    formatTime(time) {
      const [hours, minutes] = time.split(":");
      let hour = parseInt(hours, 10);
      const ampm = hour >= 12 ? "PM" : "AM";
      hour = hour % 12 || 12; // Convert to 12-hour format and handle midnight (0) case
      return `${hour}:${minutes} ${ampm}`;
    },

    formatDate(dateStr) {
      const options = { year: "numeric", month: "long", day: "numeric" };
      const date = new Date(dateStr);
      return date.toLocaleDateString("en-US", options);
    },
  },
  created() {
    /*   console.log("Sample Array", this.events);
     */
    const store = useDashBoard();
    store.Set_Appointment_Store().then((res) => {
      this.serverdatetime = store.Server_Date_TIme;

      // Extracting the date from the response
      const serverDate = store.Server_Date_TIme.date;

      // Create a new Date object from the server date
      const dateObj = new Date(serverDate);

      // Format the date into month name, day, and year
      const options = { year: "numeric", month: "long", day: "numeric" };
      const formattedDate = dateObj.toLocaleDateString("en-US", options);

      // Split the formatted date into components
      const [monthName, day, year] = formattedDate.split(" ");

      // Get the month number (0-11) and add 1 to convert to 1-12
      const monthNumber = dateObj.getMonth() + 1;

      // Assign the values to your component's data properties
      this.Server_monthName = monthName;
      this.Server_day = day.replace(",", ""); // Remove the comma from the day
      this.Server_year = year;
      this.Server_monthNumber = monthNumber;

      // You can now use this.monthName, this.day, this.year, and this.monthNumber in your template
      console.log("Month Name", this.Server_monthName);
      console.log("Day", this.Server_day);
      console.log("Year", this.Server_year);
      console.log("Month Number", this.Server_monthNumber);

      this.retrievedLogin = localStorage.getItem("Login");
      console.log("Retrieved Login Local Storage:", this.retrievedLogin);

      if (!this.retrievedLogin) {
        console.error("No login found in localStorage.");
        return;
      }

      const store1 = useLoginCheck();
      let data1 = new FormData();
      data1.append("LoginID", this.retrievedLogin);

      store1.RetrievedData_function(data1).then((res) => {
        this.userinfo = store1.RetrievedData;

        // Check if userinfo and the data array exist
        if (
          !this.userinfo ||
          !this.userinfo.data ||
          !this.userinfo.data.length
        ) {
          console.error("Invalid user info retrieved.");
          return;
        }

        // Directly access the first element of the data array
        this.userData = this.userinfo.data[0];
        if (!this.userData) {
          console.error("Invalid user info retrieved.");
          return;
        }

        /*   console.log("Data Retrieved View ALl jobs:", this.userData); */

        const store2 = useDashBoard();
        let data2 = new FormData();
        data2.append("CompanyID", this.userData.ID);
        /*  console.log("CompanyID", this.userData.ID); */
        data2.append("month", this.Server_monthNumber);
        /*  console.log("month", this.Server_monthNumber); */
        data2.append("year", this.Server_year);
        this.events = [];
        store2.GetAppointment_Store(data2).then((res) => {
          this.getAppointment_me = store2.GetAppointment_Array.appointment;
          this.GetDate_me = store2.GetAppointment_Array.data;
          console.log("Response from Get Appointment:", this.getAppointment_me);
          console.log("Response from Get  Data:", this.GetDate_me);
          // Create a map to track unique Job_IDs
          const jobIdMap = new Map();

          this.getAppointment_me.forEach((event) => {
            if (!jobIdMap.has(event.Job_ID)) {
              // Add the event to the map if the Job_ID is not yet encountered
              jobIdMap.set(event.Job_ID, {
                id: event.ID,
                title: event.title,
                start: event.Appointment_date,
                end: event.Appointment_date,
                details: event.Appointment_time,
                salary: event.salary,
                pic: event.pic,
              });
            }
          });

          // Convert the map values to an array and assign it to events
          this.events = Array.from(jobIdMap.values());

          console.log("new events=>", this.events);
          /*
            /*    console.log("Server_year", this.Server_year); */
        });
      });
    });
    setInterval(() => {
      store.Set_Appointment_Store().then((res) => {
        this.serverdatetime = store.Server_Date_TIme;

        // Extracting the date from the response
        const serverDate = store.Server_Date_TIme.date;

        // Create a new Date object from the server date
        const dateObj = new Date(serverDate);

        // Format the date into month name, day, and year
        const options = { year: "numeric", month: "long", day: "numeric" };
        const formattedDate = dateObj.toLocaleDateString("en-US", options);

        // Split the formatted date into components
        const [monthName, day, year] = formattedDate.split(" ");

        // Get the month number (0-11) and add 1 to convert to 1-12
        const monthNumber = dateObj.getMonth() + 1;

        // Assign the values to your component's data properties
        this.Server_monthName = monthName;
        this.Server_day = day.replace(",", ""); // Remove the comma from the day
        this.Server_year = year;
        this.Server_monthNumber = monthNumber;
      });
    }, 1000);
  },
};
</script>

<style scoped>
@media only screen and (max-width: 1023px) {
  .scheduleinterview {
    margin-top: 10px;
    margin-left: 15px;
  }
}

.textbox {
  padding: 10px;
  border: 1px solid #0b66a3;
  border-radius: 13px;
  width: 250px;
  height: 28px;
}

.custom-input .q-field__control {
  height: 2px; /* Adjust the height as needed */
}

.q-page {
  display: flex;
  justify-content: left;
  align-items: flex-start;
  height: 100vh;
}
.scrollable-container {
  max-height: 80vh;
  overflow-y: auto;
  /* Custom scrollbar */
  scrollbar-width: unset; /* For Firefox */
}

/* Custom scrollbar for WebKit browsers */
.scrollable-container::-webkit-scrollbar {
  width: 5px;
}

.scrollable-container::-webkit-scrollbar-track {
  background: transparent;
}

.scrollable-container::-webkit-scrollbar-thumb {
  background-color: rgba(0, 0, 0, 0.2);
  border-radius: 10px;
}

.custom-card_jobpost {
  border-top: 4px solid rgba(136, 152, 133, 0.877);
  border-radius: 8px;
  overflow: hidden;
}

.custom-card_Shortlisted {
  border-top: 4px solid rgba(245, 97, 17, 0.799);
  border-radius: 8px;
  overflow: hidden;
}

.custom-card {
  border-top: 4px solid rgba(14, 170, 176, 0.799);
  border-radius: 8px;
  overflow: hidden;
}

.namecolor {
  color: rgb(8, 131, 189);
  font-size: 15px;
}

.circle-icon {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 20px;
  height: 19px;
  border-radius: 50%;
  background-color: rgb(11, 167, 11);
  margin-right: 4px;
}
.circle-icon q-icon {
  color: white;
}
.custom-icon-class {
  color: #ffffff;
  margin-left: 1px;
}

.circle-icon-reject {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 20px;
  height: 19px;
  border-radius: 50%;
  background-color: rgb(242, 73, 17);
  margin-right: 4px;
}
.circle-icon-reject q-icon {
  color: white;
}
.custom-icon-class-reject {
  color: #ffffff;
  margin-left: 1px;
}

.yellowgold {
  color: rgb(231, 198, 35);
}

.q-page {
  display: flex;
  justify-content: center;
  align-items: flex-start;
  height: 50vh;
}
.scrollable-container {
  max-height: 43vh; /* Adjust based on your preference */
  overflow-y: auto;
  width: 100%;
}
</style>
