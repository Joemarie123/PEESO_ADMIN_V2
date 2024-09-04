<template>
  <div class="q-pa-md">
    <!--  <div class="row">
      <p>View All JOBS</p>
    </div> -->
    <q-dialog v-model="dialog_sched" persistent>
      <q-card>
        <q-card-section>
          <div class="row items-center justify-start">
            <p style="font-size: 12px; margin-left: 5px">{{ Pass_title }}</p>
          </div>
          <q-date dense v-model="date" mask="YYYY-MM-DD" />
        </q-card-section>
      </q-card>

      <q-card>
        <q-card-section>
          <!--  <div class="row items-center justify-start">
            <p style="font-size: 15px; margin-left: 5px">
              <b>Apply to All</b>
            </p>
          </div> -->

          <!--  <div class="row items-center justify-end">
            <q-btn flat round icon="close" @click="dialog_sched = false" />
          </div>
 -->

          <div class="row">
            <div class="col-6">
              <q-checkbox v-model="applyToAll" label="APPLY ALL" dense />
            </div>

            <div class="col-4" style="margin-top: -5px">
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
                <q-btn flat round icon="close" @click="dialog_sched = false" />
              </div>
            </div>
          </div>

          <q-time dense v-model="time" mask="HH:mm" />
        </q-card-section>
      </q-card>
    </q-dialog>

    <div class="row">
      <div class="col-4">
        <div style="max-width: 500px; margin-left: 40px">
          <!--    <q-tabs v-model="tab" class=""> -->
          <!-- <q-chip
            clickable
            outline
            color="primary"
            text-color="white"
            icon="add_task"
          >
            <q-btn color="blue" flat rounded size="14px" label="JOB POSTING" />
          </q-chip> -->

          <div>
            <q-btn
              outline
              size="12px"
              rounded
              icon="add"
              label="JOB POSTING"
              class="q-mx-sm colorbutton_applicant"
              @click="goToPage('/CreateJobPost')"
            />
            <input
              v-model="search_jobpost"
              class="textbox"
              placeholder="Search Job Post"
            />
          </div>

          <!-- </q-tabs> -->

          <q-card shadow-5>
            <div class="q-gutter-y-sm">
              <div style="margin-top: 25px; padding: 10px">
                <div class="scrollable-container">
                  <div class="q-gutter-md">
                    <q-card
                      v-for="jobPost in filteredJobPosts"
                      :key="jobPost.ID"
                      :class="[
                        'q-mb-md',
                        'custom-card_jobpost',
                        { 'active-card': activeCard == jobPost.ID },
                      ]"
                      @click="handleRowClick(jobPost)"
                    >
                      <div class="row">
                        <div class="col-7">
                          <q-card-section class="row items-center">
                            <img
                              style="max-width: 35px"
                              :src="getJobImage(jobPost.pic)"
                              alt="Position Picture"
                              :imgProps="{ width: '100px', height: '100px' }"
                            />
                            <div class="q-ml-sm">
                              <div
                                class="text-h6 namecolor"
                                v-if="jobPost.Title.length > 28"
                                v-tooltip.bottom="jobPost.Title"
                              >
                                {{ truncateTitle(jobPost.Title, 28) }}
                                <q-tooltip>{{ jobPost.Title }}</q-tooltip>
                              </div>
                              <div class="text-h6 namecolor" v-else>
                                {{ truncateTitle(jobPost.Title, 28) }}
                              </div>
                              <div
                                class="text-subtitle2"
                                style="margin-top: -8px"
                              >
                                Salary: ₱ {{ jobPost.Salary }}
                              </div>
                            </div>
                          </q-card-section>

                          <div class="row">
                            <!--   <q-card-section class="row items-center">
                            <div class="circle-icon-reject">
                              <q-icon
                                name="close"
                                class="q-ml-xs custom-icon-class-reject"
                              />
                            </div>
                            <div>
                              <div class="text-subtitle2">
                                Total Reject / {{ jobPost.totalrejected }}
                              </div>
                            </div>
                          </q-card-section> -->

                            <q-card-section
                              class="row items-center"
                              style="margin-top: -10px"
                            >
                              <div class="circle-icon">
                                <q-icon
                                  name="check"
                                  class="q-ml-xs custom-icon-class-reject"
                                />
                              </div>
                              <div>
                                <div class="text-subtitle2">
                                  Total Accept / {{ jobPost.totalaccepted }}
                                </div>
                              </div>
                            </q-card-section>
                            <div
                              class="row items-center"
                              style="margin-top: -10px"
                            >
                              <!--     <div class="circle-icon">
                              <q-icon
                                name="check"
                                class="q-ml-xs custom-icon-class-reject"
                              />
                            </div> -->
                              <div>
                                <div
                                  class="text-subtitle2"
                                  style="margin-left: 18px; margin-bottom: 10px"
                                >
                                  Date Posted:
                                  {{ formatDate(jobPost.DateFrom) }}
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="col-5" style="margin-top: -8px">
                          <q-card-section class="row items-center">
                            <div>
                              <div
                                class="text-h6"
                                style="font-size: 13px; font-weight: 400"
                              >
                                Total Vacant: {{ jobPost.VacantCount }}
                              </div>
                            </div>
                          </q-card-section>
                          <q-card-section class="row items-center">
                            <div>
                              <div
                                class="text-h6"
                                style="
                                  font-size: 13px;
                                  font-weight: 400;
                                  margin-top: -40px;
                                "
                              >
                                Total Applied: {{ jobPost.totalapplicant }}
                              </div>
                              <!--   <div
                              class="text-subtitle2 yellowgold"
                              style="margin-top: -8px"
                            >

                            </div> -->
                            </div>
                          </q-card-section>

                          <q-card-section class="row items-center">
                            <div>
                              <div
                                class="text-h6"
                                style="
                                  font-size: 13px;
                                  font-weight: 400;
                                  margin-top: -48px;
                                "
                              >
                                Total Hired: {{ jobPost.totalhired }}
                              </div>
                              <div
                                class="text-h6"
                                style="
                                  font-size: 13px;
                                  font-weight: 400;
                                  margin-top: -10px;
                                "
                              >
                                Total Rejected:
                                <span style="color: red">{{
                                  jobPost.totalrejected
                                }}</span>
                              </div>

                              <!--     <div
                              class="text-subtitle2"
                              style="margin-top: -8px"
                            >

                            </div> -->
                            </div>
                          </q-card-section>
                        </div>
                      </div>

                      <!--   <div class="row">
            <div class="col-7">
              <q-card-section class="row items-center">
                <div class="circle-icon">
                  <q-icon name="check" class="q-ml-xs custom-icon-class" />
                </div>
                <div>
                  <div class="text-subtitle2">
                    Total Accept / {{ jobPost.Total_Accept }}
                  </div>
                </div>
              </q-card-section>
            </div>
            <div class="col-4">
              <div class="q-gutter-lg">

              </div>
            </div>
          </div> -->

                      <q-separator />
                    </q-card>
                    <!--     <q-infinite-scroll
                    :offset="100"
                    @load="loadMoreJobPosts"
                    :disable="!hasMore"
                  >
                    <q-spinner color="primary" />
                  </q-infinite-scroll> -->
                  </div>
                </div>
              </div>
              <!--     </q-tab-panel>
            </q-tab-panels> -->
            </div>
          </q-card>
        </div>
      </div>

      <div class="col-8">
        <div style="max-width: 1000px; margin-left: 40px">
          <q-tabs v-model="tab" class="">
            <q-chip
              clickable
              outline
              class="colorbutton_applicant"
              icon="bookmark"
            >
              <q-tab name="receievedcvs" label="RECEIVED CV'S" />
            </q-chip>
            <q-chip
              clickable
              outline
              class="colorbutton_applicant"
              icon-right="star"
            >
              <q-tab name="shortlisted" label="POTENTIAL APPLICANT" />
            </q-chip>

            <input
              v-if="tab == 'receievedcvs'"
              v-model="search_applicant"
              class="textbox"
              placeholder="Search Applicant"
            />

            <!-- Conditionally render search input for "POTENTIAL APPLICANT" -->
            <input
              v-if="tab == 'shortlisted'"
              v-model="search_potentialApplicant"
              class="textbox"
              placeholder="Search Potential Applicant"
            />

            <!--  <q-chip
          clickable
          outline
          color="orange"
          text-color="white"
          icon-right="star"
        >
          <q-tab name="history" label="HISTORY" />
        </q-chip> -->
          </q-tabs>
          <!--  <q-card> -->
          <div class="q-gutter-y-sm" style="margin-top: -12px">
            <q-tab-panels v-model="tab" animated class="text-left">
              <q-tab-panel name="receievedcvs">
                <q-page class="flex flex-center q-pa-md">
                  <div class="scrollable-container">
                    <div class="q-gutter-md">
                      <q-card
                        v-for="user in filteredJobApplicant"
                        :key="user.id"
                        class="custom-card"
                      >
                        <div class="row">
                          <div class="col-4">
                            <q-card-section class="row items-center">
                              <q-avatar size="53px" class="q-mr-sm">
                                <img
                                  :src="
                                    user.pic
                                      ? user.pic
                                      : 'public/defaultpic.jpg'
                                  "
                                  alt="Profile Picture"
                                />
                              </q-avatar>
                              <div>
                                <div class="text-h6 namecolor">
                                  {{ user.Firstname }} {{ user.Surname }}
                                </div>
                                <div
                                  class="text-subtitle2"
                                  style="margin-top: -8px"
                                >
                                  Age: {{ user.age }}
                                </div>
                              </div>
                            </q-card-section>
                          </div>

                          <div class="col-3">
                            <q-card-section class="row items-center">
                              <div>
                                <div
                                  class="text-h6"
                                  style="font-size: 13px; font-weight: 400"
                                >
                                  Total Experience
                                </div>
                                <div
                                  class="text-subtitle2"
                                  style="margin-top: -8px"
                                >
                                  {{ user.YearsExperience }}
                                </div>
                              </div>
                            </q-card-section>
                          </div>

                          <div class="col-5">
                            <q-card-section class="row items-center">
                              <div>
                                <div
                                  class="text-h6"
                                  style="font-size: 13px; font-weight: 400"
                                >
                                  Address
                                </div>
                                <div
                                  class="text-subtitle2"
                                  style="margin-top: -8px"
                                >
                                  {{ user.Address }}
                                </div>

                                <!--      <div
                                  class="text-subtitle2"
                                  v-if="user.address.length > 20"
                                  v-tooltip.bottom="user.address"
                                  style="margin-top: -8px"
                                >
                                  {{ truncateTitle_Address(user.address, 20) }}
                                  <q-tooltip>{{ user.address }}</q-tooltip>
                                </div>
                                <div class="text-h6" v-else>
                                  {{ truncateTitle_Address(user.address, 20) }}
                                </div> -->
                              </div>
                            </q-card-section>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-lg-7 col-xl-7">
                            <q-card-section
                              class="row items-center"
                              style="margin-top: -20px"
                            >
                              <div class="circle-icon_phone">
                                <q-icon
                                  name="call"
                                  class="q-ml-xs custom-icon-class"
                                />
                              </div>
                              <div>
                                <b>{{ user.ContactNo }}</b>
                              </div>
                            </q-card-section>

                            <q-card-section
                              class="row items-center"
                              style="margin-top: -30px"
                            >
                              <div class="circle-icon">
                                <q-icon
                                  name="check"
                                  class="q-ml-xs custom-icon-class"
                                />
                              </div>

                              <div>
                                <div class="text-subtitle2">
                                  Applied Position / {{ user.title }}
                                </div>
                              </div>
                            </q-card-section>
                          </div>
                          <div
                            class="col-lg-5 col-xl-4"
                            style="margin-top: 8px"
                          >
                            <div class="q-gutter-sm">
                              <q-btn
                                color="blue"
                                flat
                                rounded
                                size="14px"
                                label="View Details"
                              />
                              <q-btn
                                class="glossy"
                                rounded
                                color="red"
                                size="12px"
                                label="DECLINE"
                                @click="Click_Declined(user)"
                              />
                              <q-btn
                                class="glossy"
                                size="12px"
                                rounded
                                color="green"
                                label="Accept"
                                @click="Click_Accepted(user)"
                              />
                            </div>
                          </div>
                        </div>

                        <q-separator />
                      </q-card>
                    </div>
                  </div>
                </q-page>
              </q-tab-panel>
            </q-tab-panels>
          </div>
          <!--  </q-card> -->
          <div class="q-gutter-y-sm" style="margin-top: -8px">
            <q-tab-panels v-model="tab" animated class="text-left">
              <q-tab-panel name="shortlisted">
                <q-page class="flex flex-center q-pa-md">
                  <div class="scrollable-container">
                    <div class="q-gutter-md">
                      <q-card
                        v-for="potential in filteredJob_Potential_Applicant"
                        :key="potential.id"
                        class="q-mb-md custom-card_Shortlisted"
                      >
                        <div class="row">
                          <div class="col-4">
                            <q-card-section class="row items-center">
                              <q-avatar size="53px" class="q-mr-sm">
                                <img
                                  :src="
                                    potential.pic
                                      ? potential.pic
                                      : 'public/defaultpic.jpg'
                                  "
                                  alt="Profile Picture"
                                />
                              </q-avatar>
                              <div>
                                <div class="text-h6 namecolor">
                                  {{ potential.Firstname }}
                                  {{ potential.Surname }}
                                </div>
                                <div
                                  class="text-subtitle2"
                                  style="margin-top: -8px"
                                >
                                  <!--    Age: {{ user.age }} -->
                                </div>
                              </div>
                            </q-card-section>
                          </div>

                          <div class="col-3">
                            <q-card-section class="row items-center">
                              <div>
                                <div
                                  class="text-h6"
                                  style="font-size: 13px; font-weight: 400"
                                >
                                  Total Experience
                                </div>
                                <div
                                  class="text-subtitle2"
                                  style="margin-top: -8px"
                                >
                                  <!--    {{ user.YearsExperience }} -->
                                </div>
                              </div>
                            </q-card-section>
                          </div>

                          <!--    <div class="col-2">
                            <q-card-section class="row items-center">
                              <div>
                                <div
                                  class="text-h6"
                                  style="font-size: 13px; font-weight: 400"
                                >
                                  Expected Salary
                                </div>
                                <div
                                  class="text-subtitle2 yellowgold"
                                  style="margin-top: -8px"
                                >
                                  ₱ {{ user.ExpectedSalary }}
                                </div>
                              </div>
                            </q-card-section>
                          </div> -->

                          <div class="col-3">
                            <q-card-section class="row items-center">
                              <div>
                                <div
                                  class="text-h6"
                                  style="font-size: 13px; font-weight: 400"
                                >
                                  Address
                                </div>
                                <div
                                  class="text-subtitle2"
                                  style="margin-top: -8px"
                                >
                                  {{ potential.Address }}
                                </div>
                              </div>
                            </q-card-section>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-lg-7 col-xl-7">
                            <q-card-section
                              class="row items-center"
                              style="margin-top: -20px"
                            >
                              <div class="circle-icon_phone">
                                <q-icon
                                  name="call"
                                  class="q-ml-xs custom-icon-class"
                                />
                              </div>

                              <div>
                                <div class="text-subtitle2">
                                  Contact Number: {{ potential.ContactNo }}
                                </div>
                              </div>
                            </q-card-section>

                            <q-card-section
                              class="row items-center"
                              style="margin-top: -30px"
                            >
                              <div class="circle-icon">
                                <q-icon
                                  name="check"
                                  class="q-ml-xs custom-icon-class"
                                />
                              </div>

                              <div>
                                <div class="text-subtitle2">
                                  Applied Position / {{ potential.title }}
                                </div>
                              </div>
                            </q-card-section>
                          </div>
                          <div
                            class="col-lg-5 col-xl-4"
                            style="margin-top: 8px"
                          >
                            <div class="q-gutter-sm">
                              <q-btn
                                color="blue"
                                flat
                                rounded
                                size="14px"
                                label="View Details"
                              />
                              <!--  <q-btn
                                class="glossy"
                                rounded
                                color="red"
                                size="12px"
                                label="Reject"
                              /> -->
                              <q-btn
                                @click="schedule_Dialog(potential)"
                                class="glossy"
                                size="12px"
                                rounded
                                color="green"
                                label="Schedule Interview"
                              />
                            </div>
                          </div>
                        </div>

                        <q-separator />
                      </q-card>
                      <!--     <q-infinite-scroll
                        :offset="100"
                        @load="loadMoreUsers"
                        :disable="!hasMore"
                      >
                        <q-spinner color="primary" />
                      </q-infinite-scroll> -->
                    </div>
                  </div>
                </q-page>
              </q-tab-panel>
            </q-tab-panels>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { useJobpost } from "src/stores/JobPost_Store";
import { useQuasar } from "quasar";
import { useLoginCheck } from "src/stores/SignUp_Store";
import { ref, onMounted, computed } from "vue";
import axios from "axios";

export default {
  name: "JobPostList",

  data() {
    return {
      UpdateJobPosting: [],
      Data_Retrieved_Applicant: [],
      activeCard: null,
      userinfo: [],
      applyToAll: false,
      dialog_sched: false,
      search_jobpost: "",
      search_applicant: "",
      search_potentialApplicant: "",

      jobPosts: [],
      page: 1,
      limit: 10,
      hasMore: true,
      loading: false,
      userData: null, // Initialize userData
      /*     Data_Retrieved: [], */

      Data_Retrieved: {
        data: [], // Ensure it's always an array, even if empty
      },

      users: [],
      page_1: 1,
      limit_1: 10, // Number of records per request
      hasMore_1: true, // To check if more data is available
      // loading_1: false, // To prevent multiple simultaneous requests
      screenWidth: window.innerWidth,
      GetJobPosting: [],
      UpdateAplikante: [],
      Potential_Applicant: [],
      SetAppointment_ME: [],
      Pass_JOBID: "",
      Pass_ApplicantID: "",
      Pass_title: "",
      allRecords: [], // Define the array to hold all the records
    };
  },

  computed: {
    filteredJob_Potential_Applicant() {
      return this.Potential_Applicant.filter((potential) => {
        const SearhOverAll =
          `${potential.Firstname} ${potential.Surname} ${potential.Address} ${potential.title}`.toLowerCase();
        return SearhOverAll.includes(
          this.search_potentialApplicant.toLowerCase()
        );
      });
    },

    filteredJobApplicant() {
      return this.GetJobPosting.filter((user) => {
        const fullName =
          `${user.Firstname} ${user.Surname} ${user.Address} ${user.title}`.toLowerCase();
        return fullName.includes(this.search_applicant.toLowerCase());
      });
    },

    filteredJobPosts() {
      return this.Data_Retrieved.data.filter((jobPost) =>
        jobPost.Title.toLowerCase().includes(this.search_jobpost.toLowerCase())
      );
    },

    truncateLength() {
      return this.screenWidth <= 1439 ? 13 : 25;
    },
    shouldShowTooltip() {
      return jobPost.Title.length > (this.screenWidth <= 1439 ? 13 : 28);
    },
  },
  mounted() {
    window.addEventListener("resize", this.updateScreenWidth);
  },
  beforeUnmount() {
    window.removeEventListener("resize", this.updateScreenWidth);
  },

  methods: {
    Click_Submit_SetAppointment() {
      const store = useJobpost();
      if (this.applyToAll) {
        for (const item of this.Potential_Applicant) {
          let data = new FormData();
          data.append("JobID", this.Pass_JOBID);
          data.append("ApplicantID", item.PMID);
          data.append("Appointment_date", this.date);
          data.append("Appointment_time", this.time);
          store.Set_Appointment_Store(data);
        }
        this.SuccessfullyAppoint();
        this.dialog_sched = false;
      } else {
        let data = new FormData();
        data.append("JobID", this.Pass_JOBID);
        data.append("ApplicantID", this.Pass_ApplicantID);
        data.append("Appointment_date", this.date);
        data.append("Appointment_time", this.time);

        store.Set_Appointment_Store(data).then((res) => {
          this.SetAppointment_ME = store.SetAppointment_Array;
          this.SuccessfullyAppoint();
          this.dialog_sched = false;
        });
      }
    },

    handleRowClick(jobPost) {
      console.log("Job Post Clicked:", jobPost.ID);
      this.activeCard = jobPost.ID;

      const store = useJobpost();
      let data = new FormData();
      data.append("JobID", jobPost.ID);

      store
        .Get_Applicant(data)
        .then((res) => {
          // Ensure GetJobs_Array is a valid array
          if (!Array.isArray(store.GetJobs_Array)) {
            console.warn(
              "GetJobs_Array is not a valid array. Resetting to empty array."
            );
            store.GetJobs_Array = []; // Reset to an empty array if the data is not valid
          }

          this.GetJobPosting = store.GetJobs_Array.filter(
            (job) => job.status == "APPLIED"
          );
          console.log(
            "Filtered GetJobPosting (APPLIED only):",
            this.GetJobPosting
          );
        })
        .catch((error) => {
          console.error("Error fetching applicants:", error);
          this.GetJobPosting = []; // Optional: Reset to empty array on error
        });

      const store3 = useJobpost();
      let data3 = new FormData();
      data3.append("JobID", jobPost.ID);

      store3
        .Potential_Applicant_Store(data3)
        .then((res) => {
          // Ensure PotentialApplicant_Array is a valid array
          if (!Array.isArray(store3.PotentialApplicant_Array)) {
            console.warn(
              "PotentialApplicant_Array is not a valid array. Resetting to empty array."
            );
            store3.PotentialApplicant_Array = []; // Reset to an empty array if the data is not valid
          }

          this.Potential_Applicant = store3.PotentialApplicant_Array.filter(
            (job) => job.status == "ACCEPTED"
          );

          console.log(
            "Filtered Potential Applicant (ACCEPTED only):",
            this.Potential_Applicant
          );
        })
        .catch((error) => {
          console.error("Error fetching potential applicants:", error);
          this.Potential_Applicant = []; // Optional: Reset to empty array on error
        });
    },

    Click_Declined(user) {
      /*    console.log("APPLICANT ID:", user.PMID);
      console.log("JOB ID:", this.activeCard);
 */
      const store = useJobpost();
      let data = new FormData();
      data.append("JobID", user.jobID);
      data.append("ApplicantID", user.PMID);
      data.append("Status", "DECLINED");

      store.Update_Applicant(data).then((res) => {
        this.UpdateAplikante = store.UpdateApplicant_Array;
        console.log("Response from DECLINED:", this.UpdateAplikante);
        /////////////////////////// CODE TO REFRESH //////////////////////////////////////
        const store2 = useJobpost();
        let data2 = new FormData();

        if (this.activeCard) {
          data2.append("JobID", this.activeCard);
          console.log("Active Card", this.activeCard);
        } else {
          data2.append("CompanyID", this.userData.ID);
          console.log("CompanyID", this.activeCard);
        }

        store2.Get_Applicant(data2).then((res) => {
          this.GetJobPosting = store2.GetJobs_Array.filter(
            (job) => job.status == "APPLIED"
          );
          console.log(
            "Filtered GetJobPosting (APPLIED only):",
            this.GetJobPosting
          );

          /////////////////////////////////////////////////
          const store1 = useJobpost();
          let data1 = new FormData();
          data1.append("CompanyID", this.userData.ID);
          store1.Retrieve_Jobs(data1).then((res) => {
            this.Data_Retrieved = store1.RetrieveJobs_Array;
            console.log(" Database:", this.Data_Retrieved);
          });
        });
        this.SuccessfullyDeclined();
      });
    },

    Click_Accepted(user) {
      /*    console.log("APPLICANT ID:", user.PMID);
      console.log("JOB ID:", this.activeCard);
 */
      const store = useJobpost();
      let data = new FormData();
      data.append("JobID", user.jobID);
      data.append("ApplicantID", user.PMID);
      data.append("Status", "ACCEPTED");

      store.Update_Applicant(data).then((res) => {
        this.UpdateAplikante = store.UpdateApplicant_Array;
        console.log("Response from ACCEPTED:", this.UpdateAplikante);
        /////////////////////////// CODE TO REFRESH //////////////////////////////////////
        const store2 = useJobpost();
        let data2 = new FormData();

        if (this.activeCard) {
          data2.append("JobID", this.activeCard);
          console.log("Active Card", this.activeCard);
        } else {
          data2.append("CompanyID", this.userData.ID);
          console.log("CompanyID", this.activeCard);
        }

        store2.Get_Applicant(data2).then((res) => {
          this.GetJobPosting = store2.GetJobs_Array.filter(
            (job) => job.status == "APPLIED"
          );
          console.log(
            "Filtered GetJobPosting (APPLIED only):",
            this.GetJobPosting
          );
        });

        /////////////////////////// CODE TO REFRESH POTENTIAL APPLICANT //////////////////////////////////////

        const store3 = useJobpost();
        let data3 = new FormData();

        if (this.activeCard) {
          data3.append("JobID", this.activeCard);
        } else {
          data3.append("CompanyID", this.userData.ID);
        }

        store3.Potential_Applicant_Store(data3).then((res) => {
          this.Potential_Applicant = store3.PotentialApplicant_Array.filter(
            (job) => job.status == "ACCEPTED"
          );

          console.log("Potential Applicant", this.Potential_Applicant);
        });

        this.SuccessfullyAccepted();

        /////////////////////////////////////////////////////////
        const store1 = useJobpost();
        let data1 = new FormData();
        data1.append("CompanyID", this.userData.ID);
        store1.Retrieve_Jobs(data1).then((res) => {
          this.Data_Retrieved = store1.RetrieveJobs_Array;
          console.log(" Database:", this.Data_Retrieved);
        });
      });
    },

    truncateTitle(title, maxLength) {
      if (title.length > maxLength) {
        return title.substring(0, maxLength - 3) + "...";
      } else {
        return title;
      }
    },

    truncateTitle_Address(title, maxLength) {
      if (title.length > maxLength) {
        return title.substring(0, maxLength - 3) + "...";
      } else {
        return title;
      }
    },

    updateScreenWidth() {
      this.screenWidth = window.innerWidth;
    },

    formatDate(dateString) {
      const options = { year: "numeric", month: "long", day: "numeric" };
      return new Date(dateString).toLocaleDateString("en-US", options);
    },

    async loadMoreUsers() {
      if (this.loading1) return;
      this.loading1 = true;
      try {
        const response = await axios.get(
          `https://joemarie123.github.io/Fake_API_Testing/users_sampe.json`,
          {
            params: {
              _page: this.page_1,
              _limit: this.limit_1,
            },
          }
        );
        console.log("kini", response.data); // Add this line to log the response data
        // Extract the users array from the response
        const newUsers = response.data.users;
        this.users = this.users.concat(newUsers);
        this.page++;
        this.hasMore_1 = newUsers.length === this.limit;
      } catch (error) {
        console.error("Error fetching users:", error);
      } finally {
        this.loading1 = false;
      }
    },

    getJobImage(pic) {
      const baseUrl = "http://10.0.1.26:82/peesoportal/jobs/admin/jobpic/";
      const imgUrl = pic
        ? `${baseUrl}${encodeURIComponent(pic)}`
        : "http://10.0.1.26:82/peesoportal/jobs/admin/jobpic/11e1bd61fc0e33272c58.png";
      console.log("Image URL:", imgUrl);
      return imgUrl;
    },

    goToPage(page) {
      this.$router.push(page);
    },

    schedule_Dialog(potential) {
      console.log("Schedule Dialog", potential);

      this.Pass_JOBID = potential.jobID;
      this.Pass_ApplicantID = potential.PMID;
      this.Pass_title = potential.title;

      this.dialog_sched = true;
    },
  },
  created() {
    /*  this.loadMoreJobPosts();
     */

    this.loadMoreUsers();

    this.retrievedLogin = localStorage.getItem("Login");
    console.log("Retrieved Login Local Storage:", this.retrievedLogin);

    if (!this.retrievedLogin) {
      console.error("No login found in localStorage.");
      return;
    }

    const store = useLoginCheck();
    let data = new FormData();
    data.append("LoginID", this.retrievedLogin);

    store
      .RetrievedData_function(data)
      .then((res) => {
        this.userinfo = store.RetrievedData;

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

        console.log("Data Retrieved View ALl jobs:", this.userData);

        const store1 = useJobpost();
        let data1 = new FormData();
        data1.append("CompanyID", this.userData.ID);
        store1.Retrieve_Jobs(data1).then((res) => {
          this.Data_Retrieved = store1.RetrieveJobs_Array;
          console.log(" Database:", this.Data_Retrieved);
        });

        const store2 = useJobpost();
        let data2 = new FormData();
        data2.append("CompanyID", this.userData.ID);
        store2.Get_Applicant(data2).then((res) => {
          this.GetJobPosting = store2.GetJobs_Array.filter(
            (job) => job.status == "APPLIED"
          );

          console.log("Get Applicant", this.GetJobPosting);
        });

        const store3 = useJobpost();
        let data3 = new FormData();
        data3.append("CompanyID", this.userData.ID);
        store3.Potential_Applicant_Store(data3).then((res) => {
          this.Potential_Applicant = store3.PotentialApplicant_Array.filter(
            (job) => job.status == "ACCEPTED"
          );

          console.log("Potential Applicant", this.Potential_Applicant);
        });

        const baseUrl =
          "http://10.0.1.26:82/PEESOPORTAL/REGISTRATION/ADMIN/Logos/";
        const companyName = encodeURIComponent(this.userData.Company_name);
        const companyLogo = this.userData.Company_Logo
          ? encodeURIComponent(this.userData.Company_Logo)
          : "Company_Profile/e5d3982a1f7a511f789d.jpg";

        this.imgurl =
          companyLogo === "Company_Profile/e5d3982a1f7a511f789d.jpg"
            ? `${baseUrl}${companyLogo}`
            : `${baseUrl}${companyName}/${companyLogo}`;
        console.log("Image URL:", this.imgurl);
      })
      .catch((error) => {
        console.error("Error retrieving data:", error);
      });

    ////////////////////////////////////////////////
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
    const time = ref(formatTime(now));

    const combinedModel = computed(() => {
      return `${date.value} ${time.value}`;
    });

    const formattedTime = computed(() => {
      // Ensures the time is always displayed in 24-hour format
      const [hours, minutes] = time.value.split(":");
      const hours24 = String(parseInt(hours, 10)).padStart(2, "0");
      return `${hours24}:${minutes}`;
    });
    return {
      tab,
      date,
      time,
      combinedModel,
      formattedTime,

      SuccessfullyAccepted() {
        $q.notify({
          icon: "star",
          color: "green",
          message: "Successfully Accepted",
          position: "right",
          timeout: "1500",
        });
      },

      SuccessfullyDeclined() {
        $q.notify({
          icon: "star",
          color: "green",
          message: "Successfully Declined",
          position: "right",
          timeout: "1500",
        });
      },

      SuccessfullyAppoint() {
        $q.notify({
          icon: "star",
          color: "green",
          message: "Successfully Appoint",
          position: "center",
          timeout: "1500",
        });
      },
    };
  },
};
</script>

<style scoped>
.backgroundcolorbotton {
  background-color: #0d8209;
}

.textbox {
  padding: 10px;
  border: 1px solid rgba(90, 92, 91, 0.799);
  border-radius: 13px;

  width: 240px;
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

.custom-card_jobpost.active-card {
  background-color: rgba(44, 50, 43, 0.425);
  border: 4px solid rgba(44, 50, 43, 0);
  color: white; /* Change text color if needed */
}

.custom-card_jobpost {
  border: 1px solid rgba(0, 0, 0, 0.192);
  border-radius: 8px;
  overflow: hidden;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.custom-card_Shortlisted {
  border: 1px solid rgba(0, 0, 0, 0.192);
  border-radius: 8px;
  overflow: hidden;
}

.colorbutton_applicant {
  color: rgba(90, 92, 91, 0.799);
}

.custom-card {
  border: 1px solid rgba(0, 0, 0, 0.192);
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
  color: rgb(231, 198, 35);
}

.q-page {
  display: flex;
  justify-content: center;
  align-items: flex-start;
  height: 50vh;
}
.scrollable-container {
  max-height: 85vh; /* Adjust based on your preference */
  overflow-y: auto;
  width: 100%;
}
</style>
