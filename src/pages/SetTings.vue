<template>
  <div>
    <!-- Display filtered appointments -->
    <div v-for="appointment in filteredAppointments" :key="appointment.ID">
      <h3>{{ appointment.title }}</h3>
      <p>Salary: {{ appointment.salary }}</p>
      <p>Applicant: {{ appointment.firstname }} {{ appointment.surname }}</p>
      <img :src="appointment.pic" alt="Job Pic" />
      <!-- Add more fields as needed -->
    </div>
  </div>
</template>

<script>
import { ref, computed, onMounted, onBeforeUnmount } from "vue";
import { useJobpost } from "src/stores/JobPost_Store";
import { useDashBoard } from "src/stores/DashBoard_Store";

export default {
  data() {
    return {
      potentialApplicant_Selected: [],
      jobID: null,
      pollingInterval: null,
    };
  },
  created() {
    const store = useDashBoard();
    let data = new FormData();
    data.append("CompanyID", "41");
    data.append("month", "8");
    data.append("year", "2024");
    store.GetPotentialApplicant(data).then((res) => {
      this.potentialApplicant_Selected = store.PotentialApplicant.appointment;
      console.log("GET Potential:", this.potentialApplicant_Selected);
    });
  },
  mounted() {
    this.retrieveJobID();
    this.startPolling();
  },
  beforeUnmount() {
    this.stopPolling();
  },
  methods: {
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
      }, 1000); // Poll every second
    },
    stopPolling() {
      clearInterval(this.pollingInterval);
    },
  },
  computed: {
    filteredAppointments() {
      return this.potentialApplicant_Selected.filter(
        (appointment) => appointment.Job_ID === parseInt(this.jobID)
      );
    },
  },
};
</script>
