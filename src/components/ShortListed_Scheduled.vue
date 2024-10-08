<template>
  <div class="row">
    <q-card-section class="columns items-center">
      <!--  JOB ID: {{ jobID }} -->
      <p>
        Job Title:
        <b>{{ events_ME.title }} </b>
      </p>

      <p style="margin-top: -15px">
        Date Schedule:
        <b>
          {{ selctedDates.Appointment_date }}
        </b>
      </p>
    </q-card-section>
    <q-card-section class="columns items-center" style="margin-left: 35px">
      <p class="potentialapplicant">
        Potential Applicant <b>{{ events_ME.totalAppointment }}</b>
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
      <div class="row">
        <div class="col-12 col-sm-8 col-md-4 col-lg-4 col-xl-4">
          <q-card
            class="q-mt-md custom_card_Scheduled_list"
            style="margin-left: 14px"
          >
            <table class="q-table">
              <thead>
                <!--  <tr>
                  <th>Title</th>
                  <th>Total</th>
                  <th>Confirmed</th>
                </tr> -->
              </thead>
              <tbody>
                <tr
                  v-for="ebent in CalendarArray.data"
                  :key="ebent.id"
                  style="cursor: pointer"
                  @click="handleClick(ebent)"
                >
                  <td v-tooltip.bottom="ebent.title">
                    <span v-if="ebent.title.length > 22">
                      {{ truncateTitle(ebent.title, 22) }}
                      <q-tooltip>{{ ebent.title }}</q-tooltip>
                    </span>
                    <span v-else>
                      {{ ebent.title }}
                    </span>
                  </td>
                  <td>{{ ebent.totalAppointment }}</td>
                  <td>{{ ebent.totalconfirm }}</td>
                </tr>
              </tbody>
            </table>
          </q-card>
        </div>

        <div class="col-8">
          <q-card
            v-for="user in Selected_Applicant"
            :key="user.id"
            class="q-mb-md q-my-md custom-card_Shortlisted q-mx-md"
          >
            <div class="row">
              <div class="col-xl-8 col-lg-7 col-md-7 col-sm-11 col-xs-12">
                <q-card-section class="row items-center">
                  <q-avatar size="50px" class="q-mr-sm">
                    <img
                      style="margin-top: -12px"
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
                    <div class="text-subtitle2" style="margin-top: -3px">
                      <div>
                        <div class="text-subtitle2">{{ user.Contactno }}</div>
                      </div>
                    </div>
                  </div>
                </q-card-section>
              </div>

              <q-container>
                <div
                  class="col-2 col-xl-4 col-lg-2 col-sm-12 col-md-8 responsive_1"
                >
                  <div class="row" style="margin-top: 12px">
                    <div class="col-5" style="margin-left: 10px">
                      <p v-if="user.Status !== 'RESCHEDULE'">
                        STATUS:
                        <span
                          :style="{
                            color:
                              user.Status == 'CONFIRM'
                                ? 'darkgoldenrod'
                                : user.Status == 'DECLINE'
                                ? 'red'
                                : '',
                          }"
                        >
                          {{ user.Status }}
                        </span>
                      </p>
                      <!-- Render a button if the status is 'RESCHEDULE' -->
                      <q-btn
                        v-else
                        outline
                        size="11px"
                        rounded
                        label="RESCHEDULE"
                        color="red"
                        @click="handleReschedule(user)"
                      />
                    </div>
                  </div>
                </div>
              </q-container>
            </div>

            <q-dialog v-model="dialogConfirm" persistent>
              <q-card style="width: 400px">
                <div style="margin: 10px">
                  <!--  <p class="text-h6">Reason to Re-Schedule</p> -->
                  <p>
                    Prefered Date:
                    <span style="font-weight: 900">{{
                      formatDate(txttransferDate)
                    }}</span>
                  </p>
                  <p style="margin-top: -15px">
                    Prefered Time:
                    <span style="font-weight: 900">{{
                      formatTime(txttransferTime)
                    }}</span>
                  </p>

                  <p style="font-weight: 900">REASON TO RE-SCHEDULE</p>
                  <q-card
                    style="height: 200px; overflow: auto; margin-top: -10px"
                  >
                    <p style="margin: 10px">
                      {{ txtreasontransfer }}
                    </p>
                  </q-card>
                  <!--  <q-input
                    v-model="txtreasontransfer"
                    readonly
                    illed
                    type="textarea"
                  /> -->
                  <!--    <q-card-section class="q-pt-none"> -->
                  <!--   <p>{{ txtreasontransfer }}</p> -->
                  <!--    </q-card-section> -->
                </div>

                <q-card-actions align="right">
                  <!-- Confirm Button -->
                  <q-btn
                    flat
                    label="Confirm"
                    color="green"
                    @click="handleConfirm()"
                  />

                  <!-- Decline Button -->
                  <q-btn
                    flat
                    label="Decline"
                    color="red"
                    @click="Click_Decline()"
                  />

                  <!-- Reschedule Button -->
                  <q-btn
                    flat
                    label="Reschedule"
                    color="darkgoldenrod"
                    @click="Click_handleReschedule()"
                  />
                </q-card-actions>
              </q-card>

              <q-dialog v-model="dialog_sched" persistent>
                <q-card>
                  <q-card-section>
                    <div class="row items-center justify-start">
                      <p style="font-size: 12px; margin-left: 5px">
                        <span style="font-weight: bold"
                          >Select Prefered Date</span
                        >
                      </p>
                    </div>
                    <q-date dense v-model="date" mask="YYYY-MM-DD" />
                  </q-card-section>
                </q-card>

                <q-card>
                  <q-card-section>
                    <div class="row">
                      <div class="col-10" style="margin-top: -5px">
                        <q-btn
                          class="glossy"
                          size="11px"
                          rounded
                          color="blue"
                          label="SUBMIT"
                          @click="Click_Submit_SetAppointment"
                        />
                      </div>

                      <div class="col-2">
                        <div style="margin-top: -10px; margin-left: 6px">
                          <q-btn
                            flat
                            round
                            icon="close"
                            @click="dialog_sched = false"
                          />
                        </div>
                      </div>
                    </div>

                    <q-time dense v-model="time1" mask="HH:mm" />
                  </q-card-section>
                </q-card>
              </q-dialog>

              <q-card-section style="margin-top: -390px; margin-left: -10px"
                ><button class="button_close" @click="dialogConfirm = false">
                  <b>X</b>
                </button></q-card-section
              >
            </q-dialog>

            <div class="row">
              <div class="col-lg-7 col-xl-7"></div>
              <div class="col-lg-4 col-xl-4" style="margin-top: 8px">
                <div class="q-gutter-sm"></div>
              </div>
            </div>

            <q-separator />
          </q-card>
        </div>
      </div>

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
import { useMycalendar } from "src/stores/MyCalendar_Store";
import { useLoginCheck } from "src/stores/SignUp_Store";
import { useQuasar } from "quasar";
import axios from "axios";

export default {
  name: "JobPostList",

  data() {
    return {
      dialog_sched: false,
      dialogConfirm: false,
      txtreasontransfer: "",
      txtappintmentIDtransfere: "",
      txttransferDate: "",
      txttransferTime: "",

      CalendarArrayBai: [],

      CalendarArray: [],
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
      txtAppointmentDateTransfer: "",
      selectedID: "",

      serverdatetime: [],

      ebents: [
        { eventsname: "Back End Devddddddf" },
        { eventsname: "Truck Driver" },
        { eventsname: "Sales Manager" },
      ],

      Selected_Applicant: [],
      events_ME: [],
      selctedDates: [],
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

    setInterval(() => {
      this.fetchCalendarData();
    }, 500); // Call fetchCalendarData every 60 seconds (60000 milliseconds)

    // Listen to the storage event for changes in localStorage across tabs/windows
    window.addEventListener("storage", this.fetchCalendarData);
  },

  beforeUnmount() {
    // Clean up the event listener when the component is destroyed
    window.removeEventListener("storage", this.fetchCalendarData);
  },

  beforeUnmount() {
    this.stopPolling();
  },

  methods: {
    Click_Submit_SetAppointment() {
      const store = useMycalendar();
      let data = new FormData();
      data.append("AppointmentID", this.txtappintmentIDtransfere);
      data.append("Action", "NEW SCHEDULE");
      data.append("status", "NEW SCHEDULE");
      data.append("Appointment_date", this.date);
      data.append("Appointment_time", this.time);
      /*  console.log("DATAA", data); */
      store.Set_UpdateReschedule(data).then((res) => {
        this.showsuccessfullsubmited();

        this.dialogConfirm = false;
        this.dialog_sched = false;
      });
    },

    Click_handleReschedule() {
      this.dialog_sched = true;
    },
    /*   formatTime(time) {
      const [hours, minutes] = time.split(":");
      let hour = parseInt(hours, 10);
      const ampm = hour >= 12 ? "PM" : "AM";
      hour = hour % 12 || 12; // Convert to 12-hour format and handle midnight (0) case
      return `${hour}:${minutes} ${ampm}`;
    }, */

    formatDate(dateStr) {
      const options = { year: "numeric", month: "long", day: "numeric" };
      const date = new Date(dateStr);
      return date.toLocaleDateString("en-US", options);
    },

    handleConfirm() {
      const store = useMycalendar();
      let data = new FormData();
      data.append("AppointmentID", this.txtappintmentIDtransfere);
      data.append("Action", "ACCEPT");
      data.append("status", "CONFIRM");
      data.append("Appointment_date", this.txttransferDate);
      data.append("Appointment_time", this.txttransferTime);
      console.log("DATAA", data);
      store.Set_UpdateReschedule(data).then((res) => {
        ////////// CODE TO REFRESH LOCSL STORAGE

        const store = useMycalendar();
        let data = new FormData();

        data.append("CompanyID", this.userData.ID);
        data.append("Date", this.txtAppointmentDateTransfer);
        store.SetCalendar_Events(data).then((res) => {
          this.CalendarArrayBai = store.Events_Calendar;
          console.log("Calendar Events", this.CalendarArrayBai);
          localStorage.setItem(
            "Calendar",
            JSON.stringify(this.CalendarArrayBai)
          );
          console.log("Object", Object.values(this.CalendarArrayBai.data));
          const event = Object.values(this.CalendarArrayBai.data).find(
            (event) => event.appointmentID == this.selectedID
          );

          if (event) {
            this.handleClick(event);
            console.log("Event found:", event);
          } else {
            console.log("Event not found with ID:", this.selectedID);
          }

          /* window.location.reload(); */
          /*   eventBus.value?.emit("reload-calendar"); */

          /*  this.$router.push({ name: "MyCalendar" }).then(() => {
            window.location.reload();
          }); */

    
        });

        ////////// CODE TO REFRESH LOCSL STORAGE

        this.showsuccessfulldialog();
        this.dialogConfirm = false;
      });
    },

    Click_Decline() {
      const store = useMycalendar();
      let data = new FormData();
      data.append("AppointmentID", this.txtappintmentIDtransfere);
      data.append("Action", "Decline");

      store.Set_UpdateReschedule(data).then((res) => {
        this.showDecline();
        this.dialogConfirm = false;
      });
    },

    handleReschedule(user) {
      console.log("User bai bai ", user);
      this.dialogConfirm = true;
      this.txtreasontransfer = user.Remarks;
      this.txtappintmentIDtransfere = user.ID;
      this.txttransferDate = user.RescheduleDate;
      this.txttransferTime = user.rescheduleTime;
      this.txtAppointmentDateTransfer = user.Appointment_date;
    },

    handleClick(ebent) {
      this.Selected_Applicant = ebent.applicants;
      this.selectedID = ebent.appointmentID;
      this.events_ME = ebent;
      this.selctedDates = ebent.applicants[0];

      console.log("Item clicked:", this.Selected_Applicant);

      console.log("ITEMBAI ", this.events_ME);
    },

    fetchCalendarData() {
      const storedCalendar = localStorage.getItem("Calendar");

      if (storedCalendar) {
        try {
          this.CalendarArray = JSON.parse(storedCalendar);
          /*    console.log("Fetched Calendar Events:", this.CalendarArray); */
        } catch (error) {
          /*          console.error("Error parsing stored calendar data:", error); */
        }
      } else {
        /*         console.log("No calendar data found in localStorage."); */
      }
    },

    updateCalendarData(newData) {
      // This function is triggered whenever new data is added to localStorage
      localStorage.setItem("Calendar", JSON.stringify(newData));

      // Re-fetch the calendar data to update the component
      this.fetchCalendarData();
    },

    truncateTitle(title, maxLength) {
      if (title.length > maxLength) {
        return title.substring(0, maxLength - 3) + "... ";
      } else {
        return title;
      }
    },

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
    const $q = useQuasar();
    const now = new Date();

    const formatDate = (date) => {
      const year = date.getFullYear();
      const month = String(date.getMonth() + 1).padStart(2, "0");
      const day = String(date.getDate()).padStart(2, "0");
      return `${year}-${month}-${day}`;
    };

    const formatTime = (date) => {
      const hours = String(date.getHours()).padStart(2, "0");
      const minutes = String(date.getMinutes()).padStart(2, "0");
      return `${hours}:${minutes}`;
    };

    const date = ref(formatDate(now));
    const time1 = ref(formatTime(now));

    return {
      tab,
      date,
      time1,

      showsuccessfullsubmited() {
        $q.notify({
          icon: "star",
          color: "green",
          message: "Successfully Submited",
          position: "center",
          timeout: "1500",
        });
      },

      showsuccessfulldialog() {
        $q.notify({
          icon: "star",
          color: "green",
          message: "Successfully Accepted",
          position: "center",
          timeout: "1500",
        });
      },

      showDecline() {
        $q.notify({
          icon: "star",
          color: "red",
          message: "Successfully Declined",
          position: "center",
          timeout: "1500",
        });
      },
    };
  },
};
</script>

<style scoped>
.button_close {
  width: 40px; /* Adjust the size as needed */
  height: 40px; /* Ensure height matches width for a perfect circle */
  border-radius: 50%; /* This makes the button circular */
  background-color: #e7111fcb; /* Background color of the button */
  color: white; /* Text color */
  border: none; /* Remove default border */
  display: flex; /* Center text horizontally and vertically */
  align-items: center; /* Center text vertically */
  justify-content: center; /* Center text horizontally */
  cursor: pointer; /* Pointer cursor on hover */
  font-size: 16px; /* Adjust font size as needed */
}

.q-table {
  width: 100%;
  border-collapse: collapse;
}

.q-table th,
.q-table td {
  padding: 5px;
  text-align: left;
  border: 1px solid #ddd;
}

.q-table th {
  background-color: #f4f4f4;
}

.q-table tbody tr:hover {
  background-color: #f1f1f1;
}

.no-margin {
  margin: 20px;
}

.no-padding {
  padding: 20;
}

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
  border: 1px solid #1cb109;
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
  border-top: 4px solid rgba(33, 187, 56, 0.799);
  border-radius: 8px;
  overflow: hidden;
}

.custom-card_Shortlisted {
  border-top: 4px solid rgba(17, 152, 38, 0.799);
  border-radius: 8px;
  overflow: hidden;
  margin-inline-start: 30px;
  height: 82px;
}

.custom_card_Scheduled_list {
  margin-left: 15px;
  border-top: 4px solid rgba(17, 152, 38, 0.799);
  border-radius: 8px;
  overflow: hidden;
  margin-inline-start: 30px;
  height: 310px;
  margin-bottom: 15px;
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
  color: rgb(10, 10, 10);
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
