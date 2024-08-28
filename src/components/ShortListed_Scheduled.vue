<template>
  <div class="row">
    <q-card-section class="columns items-center">
      <!--  JOB ID: {{ jobID }} -->
      <p>
        Job Title:
        <b>{{
          filteredAppointments && filteredAppointments.length > 0
            ? filteredAppointments[0].title
            : "N/A"
        }}</b>
      </p>

      <p v-if="filteredAppointments" style="margin-top: -15px">
        Date Schedule:
        <b>
          {{
            filteredAppointments.length > 0
              ? formatTime(filteredAppointments[0].Appointment_time)
              : "N/A"
          }}
        </b>
      </p>

      <!--  <div v-for="appointment in filteredAppointments" :key="appointment.ID">
        <h3>{{ appointment.title }}</h3>
        <p>Salary: {{ appointment.salary }}</p>
        <p>Applicant: {{ appointment.firstname }} {{ appointment.surname }}</p>
        <img :src="appointment.pic" alt="Job Pic" />

      </div> -->
    </q-card-section>
    <q-card-section class="columns items-center">
      <p class="potentialapplicant">
        Potential Applicant <b>{{ filteredAppointments.length }}</b>
      </p>
      <div style="margin-top: -13px">
        <input
          v-model="search_jobpost"
          class="textbox"
          placeholder="Search Applicant"
        />
      </div>
    </q-card-section>
  </div>
  <div class="scrollable-container custom_card_Shortlisted">
    <div class="q-gutter-md">
      <q-card
        v-for="user in filteredAppointments"
        :key="user.id"
        class="q-mb-md q-my-md custom-card_Shortlisted"
      >
        <div class="row">
          <div class="col-xl-6 col-lg-5 col-md-7 col-sm-6 col-xs-12">
            <q-card-section class="row items-center">
              <q-avatar size="53px" class="q-mr-sm">
                <img
                  :src="user.pic ? user.pic : 'public/defaultpic.jpg'"
                  alt="Profile Picture"
                />
              </q-avatar>
              <div style="margin-top: -15px">
                <div class="text-h6 namecolor">
                  {{ user.firstname }}
                </div>

                <div class="text-subtitle2" style="margin-top: -8px">
                  <div>
                    <div class="text-subtitle2 namecolor">
                      {{ user.surname }}
                    </div>
                  </div>
                </div>
                <div class="text-subtitle2" style="margin-top: -4px">
                  <div>
                    <div class="text-subtitle2">{{ user.contactno }}</div>
                  </div>
                </div>
              </div>
            </q-card-section>
          </div>

          <q-container>
            <div
              class="col-2 col-xl-3 col-lg-2 col-sm-12 col-md-8 responsive_1"
            >
              <!-- <q-card-section class="row items-center"> -->
              <div style="margin-top: 10px">
                <!--  <q-card-section
                  class="row items-center"
                  style="margin-top: -18px"
                > -->
                <div class="row">
                  <div class="col-2">
                    <q-btn
                      class="glossy"
                      size="10px"
                      rounded
                      color="green"
                      label="Hire"
                    />
                  </div>
                  <div class="col-3">
                    <q-btn
                      class="glossy q-mx-md"
                      size="10px"
                      rounded
                      color="red"
                      label="Decline"
                    />
                  </div>
                  <div class="col-7">
                    <q-btn
                      outline
                      class="q-mx-lg"
                      size="10px"
                      rounded
                      color="blue"
                      label="WAITING LIST"
                    />
                  </div>
                </div>
                <!--   </q-card-section> -->
              </div>
              <!--  </q-card-section> -->
            </div>
          </q-container>
          <!--    <div class="col-3 col-xl-3 col-lg-4 col-md-5 responsive_1">
            <q-card-section class="row items-center" style="margin-top: -5px">
              <div>
                <div class="text-h6" style="font-size: 13px; font-weight: 400">
                  Expected Salary
                </div>
                <div class="text-subtitle2 yellowgold" style="margin-top: -8px">
                  ₱ {{ user.ExpectedSalary }}
                </div>
              </div>
            </q-card-section>
          </div> -->
        </div>

        <div class="row">
          <div class="col-lg-7 col-xl-7">
            <!--   <q-card-section
                  class="row items-center"
                  style="margin-top: -20px"
                >
                  <div class="circle-icon_phone">
                    <q-icon name="call" class="q-ml-xs custom-icon-class" />
                  </div>

                  <div>
                    <div class="text-subtitle2">Contact Number: 0915487625</div>
                  </div>
                </q-card-section>
 -->
            <!--       <q-card-section
                  class="row items-center"
                  style="margin-top: -30px"
                >
                  <div class="circle-icon">
                    <q-icon name="check" class="q-ml-xs custom-icon-class" />
                  </div>

                  <div>
                    <div class="text-subtitle2">
                      Potentiala Applicant / {{ user.AppliedPosition }}
                    </div>
                  </div>
                </q-card-section> -->
          </div>
          <div class="col-lg-4 col-xl-4" style="margin-top: 8px">
            <div class="q-gutter-sm">
              <!--    <div>SCHEDULE INTERVIEW: <b> July 27,2024 10:</b></div>
 -->
              <!--   <q-btn
                    class="glossy"
                    size="12px"
                    rounded
                    color="green"
                    label="Schedule Interview"
                  /> -->
            </div>
          </div>
        </div>

        <q-separator />
      </q-card>
      <!--   <q-infinite-scroll
        :offset="100"
        @load="loadMoreUsers"
        :disable="!hasMore"
      >
        <q-spinner color="primary" />
      </q-infinite-scroll> -->
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from "vue";
import { useJobpost } from "src/stores/JobPost_Store";
import { useDashBoard } from "src/stores/DashBoard_Store";
import { useLoginCheck } from "src/stores/SignUp_Store";
import axios from "axios";

export default {
  name: "JobPostList",

  data() {
    return {
      potentialApplicant_Selected: [],
      jobID: "", // Initialize jobID
      search_jobpost: "",
      jobPosts: [],
      page: 1,
      limit: 10,
      hasMore: true,
      loading: false,
      Transfer_JOBID: "",
      users: [],
      page_1: 1,
      limit_1: 10, // Number of records per request
      hasMore_1: true, // To check if more data is available
      loading_1: false, // To prevent multiple simultaneous requests

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
      events: [],

      serverdatetime: [],
    };
  },

  computed: {
    /*   selectedJobID() {
      const jobStore = useJobpost();
      return jobStore.selectedJobID;
    }, */

    filteredAppointments() {
      const jobID = parseInt(this.jobID);
      const searchQuery = this.search_jobpost.toLowerCase(); // Convert search input to lowercase for case-insensitive search

      // Filter by Job_ID first
      let filtered = this.potentialApplicant_Selected.filter(
        (appointment) => appointment.Job_ID === jobID
      );

      // Further filter by search query
      if (searchQuery) {
        filtered = filtered.filter(
          (appointment) =>
            appointment.surname.toLowerCase().includes(searchQuery) || // Assuming 'Surname' is a field in your appointment object
            appointment.firstname.toLowerCase().includes(searchQuery) // Assuming 'FirstName' is a field in your appointment object
        );
      }

      console.log("Filtered Appointments:", filtered);
      return filtered;
    },

    filteredApplicant() {
      const searchTerm = this.search_jobpost.toLowerCase();
      return this.users.filter(
        (users) =>
          users.firstName.toLowerCase().includes(searchTerm) ||
          users.lastName.toLowerCase().includes(searchTerm)
      );
    },
  },

  watch: {},

  mounted() {
    this.retrieveJobID();
    this.startPolling();
  },

  beforeUnmount() {
    this.stopPolling();
  },

  methods: {
    formatTime(timeString) {
      const [hours, minutes] = timeString.split(":").map(Number);
      const period = hours >= 12 ? "PM" : "AM";
      const formattedHours = hours % 12 || 12;
      return `${formattedHours}:${minutes
        .toString()
        .padStart(2, "0")} ${period}`;
    },

    retrieveJobID() {
      this.jobID = localStorage.getItem("jobID");
      console.log("Retrieved jobID:", this.jobID);
    },

    startPolling() {
      this.pollingInterval = setInterval(() => {
        const newJobID = localStorage.getItem("jobID");
        if (this.jobID !== newJobID) {
          this.jobID = newJobID;
          console.log("Updated jobID:", this.jobID);
        }
      }, 100); // Poll every second
    },

    stopPolling() {
      clearInterval(this.pollingInterval);
    },
  },
  /*   created() {
    const store_5 = useDashBoard();
    let data_5 = new FormData();
    data_5.append("CompanyID", "41");
    data_5.append("month", "8");
    data_5.append("year", "2024");
    store_5.GetPotentialApplicant(data_5).then((res) => {
      this.potentialApplicant_Selected = store_5.PotentialApplicant.appointment;
      console.log("GET Potential:", this.potentialApplicant_Selected);
    });
  }, */

  created() {
    console.log("Sample Array", this.events);

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
      /*    console.log("Month Name", this.Server_monthName);
          console.log("Day", this.Server_day);
          console.log("Year", this.Server_year);
          console.log("Month Number", this.Server_monthNumber); */

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
        store2.GetPotentialApplicant(data2).then((res) => {
          this.potentialApplicant_Selected =
            store.PotentialApplicant.appointment;
          console.log(
            "Response from Get Appointment:",
            this.potentialApplicant_Selected
          );
          // Create a map to track unique Job_IDs
          const jobIdMap = new Map();

          this.potentialApplicant_Selected.forEach((event) => {
            if (!jobIdMap.has(event.Job_ID)) {
              // Add the event to the map if the Job_ID is not yet encountered
              jobIdMap.set(event.Job_ID, {
                id: event.ID,
                title: event.title,
                start: event.Appointment_date,
                end: event.Appointment_date,
                details: event.Appointment_time,
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
  setup() {
    const tab = ref("receievedcvs");

    return {
      tab,
    };
  },
};
</script>

<style scoped>
.potentialapplicant {
  margin-top: -5px;
}

.custom_card_Shortlisted {
  margin-top: -19px;
}

@media only screen and (max-width: 599px) {
  .potentialapplicant {
    margin-top: -48px;
  }

  .custom_card_Shortlisted {
    margin-top: -5px;
  }
}

@media only screen and (max-width: 1904px) {
  .responsive_1 {
    margin-left: -40px;
  }
}

@media only screen and (max-width: 16698px) {
  .responsive_1 {
    margin-left: -36px;
  }
}

@media only screen and (max-width: 599px) {
  .responsive_1 {
    margin-left: 10px;
  }
}

.textbox {
  padding: 10px;
  border: 1px solid #0b66a3;
  border-radius: 13px;

  width: 180px;
  height: 18px;
}

@media only screen and (max-width: 1669px) {
  .textbox {
    padding: 10px;
    border: 1px solid #0b66a3;
    border-radius: 13px;

    width: 150px;
    height: 18px;
  }
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
  border-top: 4px solid rgba(33, 82, 187, 0.799);
  border-radius: 8px;
  overflow: hidden;
}

.custom-card_Shortlisted {
  border-top: 4px solid rgba(245, 97, 17, 0.799);
  border-radius: 8px;
  overflow: hidden;
  margin-inline-start: 30px;
  height: 95px;
}

@media only screen and (max-width: 599px) {
  .custom-card_Shortlisted {
    border-top: 4px solid rgba(245, 97, 17, 0.799);
    border-radius: 8px;
    overflow: hidden;
    margin-inline-start: 30px;
    height: 150px;
  }
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

.circle-icon_phone {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 20px;
  height: 19px;
  border-radius: 50%;
  background-color: rgb(167, 60, 11);
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
  color: rgb(195, 164, 11);
}

.q-page {
  display: flex;
  justify-content: center;
  align-items: flex-start;
  height: 50vh;
}
.scrollable-container {
  max-height: 44vh; /* Adjust based on your preference */
  overflow-y: auto;
  width: 100%;
}
</style>
