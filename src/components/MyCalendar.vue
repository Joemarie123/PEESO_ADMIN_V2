<template>
  <div class="subcontent">
    <navigation-bar @today="onToday" @prev="onPrev" @next="onNext" />

    <div class="row justify-center">
      <div style="display: flex; max-width: 800px; width: 100%">

        <!-- Display the passed data -->
        <q-calendar-month
          ref="calendar"
          v-model="selectedDate"
          animated
          bordered
          focusable
          hoverable
          no-active-date
          :day-min-height="64"
          :day-height="0"
          @change="onChange"
          @moved="onMoved"
          @click-date="onClickDate"
          @click-day="onClickDay"
          @click-workweek="onClickWorkweek"
          @click-head-workweek="onClickHeadWorkweek"
          @click-head-day="onClickHeadDay"
        >
          <template #week="{ scope: { week, weekdays } }">
            <template
              v-for="(computedEvent, index) in getWeekEvents(week, weekdays)"
              :key="index"
            >
              <div
                :class="badgeClasses(computedEvent)"
                :style="badgeStyles(computedEvent, week.length)"
              >
                <div
                  v-if="computedEvent.event && computedEvent.event.details"
                  class="title q-calendar__ellipsis"
                  @click="handDataclick(computedEvent)"
                >
                  <q-badge style="background-color: green">
                    {{
                      "Scheduled Interview" +
                      (computedEvent.event.time
                        ? " - " + computedEvent.event.time
                        : "")
                    }}
                    
                  </q-badge>

                  <q-tooltip>{{ computedEvent.event.details }}</q-tooltip>
                </div>
              </div>
            </template>
          </template>
        </q-calendar-month>
      </div>
    </div>
  </div>
</template>

<script>
import {
  QCalendarMonth,
  daysBetween,
  isOverlappingDates,
  parsed,
  parseDate,
  today,
  indexOf,
} from "@quasar/quasar-ui-qcalendar/src/index.js";
import "@quasar/quasar-ui-qcalendar/src/QCalendarVariables.sass";
import "@quasar/quasar-ui-qcalendar/src/QCalendarTransitions.sass";
import "@quasar/quasar-ui-qcalendar/src/QCalendarMonth.sass";
import NavigationBar from "../components/NavigationBar.vue";
import { useDashBoard } from "src/stores/DashBoard_Store";
import { useLoginCheck } from "src/stores/SignUp_Store";
import { useJobpost } from "src/stores/JobPost_Store";
import { useMycalendar } from "src/stores/MyCalendar_Store";

import { defineComponent } from "vue";

// The function below is used to set up our demo data
const CURRENT_DAY = new Date();
function getCurrentDay(day) {
  const newDay = new Date(CURRENT_DAY);
  newDay.setDate(day);
  const tm = parseDate(newDay);
  return tm.date;
}

export default defineComponent({
  name: "MonthSlotWeek",

  components: {
    NavigationBar,
    QCalendarMonth,
  },

  data() {
    return {
      selectedDate: today(),
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
      CalendarArray: [],
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
    filteredJobPosts() {
      const searchTerm = this.search_jobpost.toLowerCase();
      return this.jobPosts.filter((jobPost) =>
        jobPost.Position_Title.toLowerCase().includes(searchTerm)
      );
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
          let jobIdMap = new Map();

          // Iterate through each event in this.getAppointment_me
          this.getAppointment_me.forEach((event) => {
            // Check if the start date already exists in jobIdMap
            if (!jobIdMap.has(event.Appointment_date)) {
              // Add the event to the map if the start date is not yet encountered
              jobIdMap.set(event.Appointment_date, {
                id: event.ID,
                title: event.title,
                start: event.Appointment_date,
                end: event.Appointment_date,
                details: event.Appointment_time,
                salary: event.salary,
                Job_ID: event.Job_ID,
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

  methods: {
    handDataclick(computedEvent) {
      let Petsa = computedEvent.event.start;

      console.log("Event clicked:", Petsa);

      const store = useMycalendar();
      let data = new FormData();

      data.append("CompanyID", this.userData.ID);
      data.append("Date", Petsa);
      store.SetCalendar_Events(data).then((res) => {
        this.CalendarArray = store.Events_Calendar;
        console.log("Calendar Events", this.CalendarArray);
        localStorage.setItem("Calendar", JSON.stringify(this.CalendarArray));
      });
    },

    getWeekEvents(week, weekdays) {
      const firstDay = parsed(week[0].date + " 00:00");
      const lastDay = parsed(week[week.length - 1].date + " 23:59");

      const eventsWeek = [];
      this.events.forEach((event, id) => {
        const startDate = parsed(event.start + " 00:00");
        const endDate = parsed(event.end + " 23:59");

        if (isOverlappingDates(startDate, endDate, firstDay, lastDay)) {
          const left = daysBetween(firstDay, startDate, true);
          const right = daysBetween(endDate, lastDay, true);

          eventsWeek.push({
            id, // index event
            left, // Position initial day [0-6]
            right, // Number days available
            size: week.length - (left + right), // Size current event (in days)
            event, // Info
          });
        }
      });

      const events = [];
      if (eventsWeek.length > 0) {
        const infoWeek = eventsWeek.sort((a, b) => a.left - b.left);
        infoWeek.forEach((_, i) => {
          this.insertEvent(events, week.length, infoWeek, i, 0, 0);
        });
      }

      return events;
    },

    insertEvent(events, weekLength, infoWeek, index, availableDays, level) {
      const iEvent = infoWeek[index];
      if (iEvent !== undefined && iEvent.left >= availableDays) {
        // If you have space available, more events are placed
        if (iEvent.left - availableDays) {
          // It is filled with empty events
          events.push({ size: iEvent.left - availableDays });
        }
        // The event is built
        events.push({ size: iEvent.size, event: iEvent.event });

        if (level !== 0) {
          // If it goes into recursion, then the item is deleted
          infoWeek.splice(index, 1);
        }

        const currentAvailableDays = iEvent.left + iEvent.size;

        if (currentAvailableDays < weekLength) {
          const indexNextEvent = indexOf(
            infoWeek,
            (e) => e.id !== iEvent.id && e.left >= currentAvailableDays
          );

          this.insertEvent(
            events,
            weekLength,
            infoWeek,
            indexNextEvent !== -1 ? indexNextEvent : index,
            currentAvailableDays,
            level + 1
          );
        } // else: There are no more days available, end of iteration
      } else {
        events.push({ size: weekLength - availableDays });
        // end of iteration
      }
    },

    badgeClasses(computedEvent) {
      if (computedEvent.event !== undefined) {
        return {
          "my-event": true,
          "text-white": false,

          "rounded-border": true,
          "q-calendar__ellipsis": true,
        };
      }
      return {
        "my-void-event": true,
      };
    },

    badgeStyles(computedEvent, weekLength) {
      const s = {};
      if (computedEvent.size !== undefined) {
        s.width = (100 / weekLength) * computedEvent.size + "%";
      }
      return s;
    },

    isBetweenDatesWeek(dateStart, dateEnd, weekStart, weekEnd) {
      return (
        (dateEnd < weekEnd && dateEnd >= weekStart) ||
        dateEnd === weekEnd ||
        (dateEnd > weekEnd && dateStart <= weekEnd)
      );
    },

    onToday() {
      this.$refs.calendar.moveToToday();
    },
    onPrev() {
      this.$refs.calendar.prev();
    },
    onNext() {
      this.$refs.calendar.next();
    },
    onMoved(data) {
      console.log("onMoved", data);
    },
    onChange(data) {
      console.log("onChange", data);
    },
    onClickDate(data) {
      const DateClick = data.scope.timestamp.date;

      console.log("on Click Date", DateClick);
    },
    onClickDay(data) {
      /*  console.log("onClickDay", data); */
    },
    onClickWorkweek(data) {
      console.log("onClickWorkweek", data);
    },
    onClickHeadDay(data) {
      /*  console.log("onClickHeadDay", data);

      console.log("onClickHeadDay 11", data.scope.timestamp.date); */
    },
    onClickHeadWorkweek(data) {
      console.log("onClickHeadWorkweek", data);
    },
  },
});
</script>

<style lang="sass" scoped>
.my-event
  position: relative
  display: inline-flex
  white-space: nowrap
  font-size: 12px
  height: 16px
  max-height: 16px
  margin: 1px 0 0 0
  justify-content: center
  text-overflow: ellipsis
  overflow: hidden
  cursor: pointer

.title
  position: relative
  display: flex
  justify-content: center
  align-items: center
  height: 100%

.my-void-event
  display: inline-flex
  white-space: nowrap
  height: 1px

.text-white
  color: white

.bg-blue
  background: blue

.bg-green
  background: green

.bg-orange
  background: orange

.bg-red
  background: red

.bg-teal
  background: teal

.bg-grey
  background: grey

.bg-purple
  background: purple

.rounded-border
  border-radius: 2px
</style>
