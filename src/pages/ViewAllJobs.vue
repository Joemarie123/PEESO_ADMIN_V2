<template>
  <div class="container">
    <div class="row">
      <!-- Top Left Side Toolbar  -->
      <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-xs-12">
        <div>
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
          <div class="row q-mt-lg q-ml-lg">
            <q-btn
              outline
              size="12px"
              rounded
              color="primary"
              icon="add"
              label="JOB POSTING"
              class="q-mr-md q-mb-sm"
              @click="goToPage('/CreateJobPost')"
            />

            <input
              v-model="search_jobpost"
              class="textbox"
              placeholder="Search Job Post"
            />
          </div>

          <!-- Left Side Job Post -->
          <div class="q-gutter-y-sm q-pl-lg q-pr-md">
            <div style="margin-top: 35px">
              <div class="scrollable-container">
                <div class="q-gutter-md">
                  <q-card
                    v-for="jobPost in filteredJobPosts"
                    :key="jobPost.id"
                    class="q-mb-md custom-card_jobpost"
                  >
                    <div class="row">
                      <div class="col-7">
                        <q-card-section class="row items-center">
                          <img
                            style="max-width: 80px"
                            :src="jobPost.Position_Title_Picture"
                            alt="Position Picture"
                            :imgProps="{ width: '100px', height: '100px' }"
                          />
                          <div class="q-ml-sm">
                            <div class="text-h6 namecolor">
                              {{ jobPost.Position_Title }}
                            </div>
                            <div
                              class="text-subtitle2"
                              style="margin-top: -8px"
                            >
                              Salary: ₱ {{ jobPost.Salary }}
                            </div>
                          </div>
                        </q-card-section>
                        <q-card-section class="row items-center" style="margin-top: -18px">
                          <div class="circle-icon-reject">
                            <q-icon
                              name="close"
                              class="q-ml-xs custom-icon-class-reject"
                            />
                          </div>
                          <div>
                            <div class="text-subtitle2">
                              Total Reject / {{ jobPost.Total_Reject }}
                            </div>
                          </div>
                        </q-card-section>
                        <q-card-section
                          class="row items-center"
                          style="margin-top: -23px"
                        >
                          <div class="circle-icon">
                            <q-icon
                              name="check"
                              class="q-ml-xs custom-icon-class-reject"
                            />
                          </div>
                          <div>
                            <div class="text-subtitle2">
                              Total Accept / {{ jobPost.Total_Accept }}
                            </div>
                          </div>
                        </q-card-section>
                      </div>
                      <div class="col-5" style="">
                        <q-card-section class="row items-center">
                          <div class="row no-wrap items-center">
                            <div
                              class="text-h6"
                              style="
                                font-size: 13px;
                                font-weight: 400;
                                line-height: 1.2;
                              "
                            >
                            Total Vacant Count
                            </div>
                            <div
                              class="text-subtitle2 yellowgold q-ml-sm"
                              style="font-weight: bold;"
                            >
                            {{ jobPost.Total_Vacant_Count }}
                            </div>
                          </div>
                        </q-card-section>
                        <q-card-section class="row items-center">
                          <div class="row no-wrap items-center">
                            <div
                              class="text-h6"
                              style="
                                font-size: 13px;
                                font-weight: 400;
                                line-height: 1.2;
                              "
                            >
                              Total Applied
                            </div>
                            <div
                              class="text-subtitle2 yellowgold q-ml-sm"
                              style="font-weight: bold;"
                            >
                              {{ jobPost.Total_Applied }}
                            </div>
                          </div>
                        </q-card-section>

                        <q-card-section class="row items-center">
                          <div class="row no-wrap items-center">
                            <div
                              class="text-h6"
                              style="
                                font-size: 13px;
                                font-weight: 400;
                                line-height: 1.2;
                              "
                            >
                            Total Hired
                            </div>
                            <div
                              class="text-subtitle2 yellowgold q-ml-sm"
                              style="font-weight: bold;"
                            >
                            {{ jobPost.Total_Hired }}
                            </div>
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
                  <q-infinite-scroll
                    :offset="100"
                    @load="loadMoreJobPosts"
                    :disable="!hasMore"
                  >
                    <q-spinner color="primary" />
                  </q-infinite-scroll>
                </div>
              </div>
            </div>
            <!--     </q-tab-panel>
            </q-tab-panels> -->
          </div>
        </div>
      </div>

      <!-- Top Right Side Toolbar -->
      <div class="col-xl-7 col-lg-7 col-md-7 col-sm-7 col-xs-12">
        <div>
          <q-tabs v-model="tab" class="q-mt-lg">
            <q-chip
              clickable
              outline
              color="teal"
              text-color="white"
              icon="bookmark"
            >
              <q-tab name="receievedcvs" label="RECEIVED CV'S" />
            </q-chip>
            <q-chip
              clickable
              outline
              color="orange"
              text-color="white"
              icon-right="star"
            >
              <q-tab name="shortlisted" label="POTENTIAL APPLICANT" />
            </q-chip>
            <input
              v-model="search_jobpost"
              class="textbox"
              placeholder="Search Applicant"
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

          <!-- Right Side Jop Post -->
          <div class="q-gutter-y-sm">
            <q-tab-panels v-model="tab" animated class="text-left">
              <q-tab-panel name="receievedcvs">
                <q-page class="flex flex-center q-pa-md">
                  <div class="scrollable-container">
                    <div class="q-gutter-md">
                      <q-card
                        v-for="user in users"
                        :key="user.id"
                        class="q-mb-md custom-card"
                      >
                        <div class="row">
                          <div class="col-6">
                            <q-card-section class="row items-center">
                              <q-avatar size="53px" class="q-mr-sm">
                                <img :src="user.avatar" alt="Profile Picture" />
                              </q-avatar>
                              <div>
                                <div
                                class="text-h6 namecolor q-pt-sm"
                                style="line-height: 1.2;">
                                  {{ user.firstName }} {{ user.lastName }}
                                </div>
                                <div
                                  class="text-subtitle2"
                                  style="line-height: 1.2;"
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
                                  class="text-h6 q-mt-sm"
                                  style="font-size: 13px; font-weight: 400; line-height: 1.2;"
                                >
                                  Total Experience
                                </div>
                                <div
                                  class="text-subtitle2"
                                  style="margin-top: 2px"
                                >
                                  {{ user.YearsExperience }}
                                </div>
                              </div>
                            </q-card-section>
                          </div>
                          <div class="col-3">
                            <q-card-section class="row items-center">
                              <div>
                                <div
                                  class="text-h6 q-mt-sm"
                                  style="font-size: 13px; font-weight: 400; line-height: 1.2;"
                                >
                                  Expected Salary
                                </div>
                                <div
                                  class="text-subtitle2 yellowgold"
                                  style="margin-top: 2px"
                                >
                                  ₱ {{ user.ExpectedSalary }}
                                </div>
                              </div>
                            </q-card-section>
                          </div>
                          <!-- <div class="col-3">
                            <q-card-section class="row items-center">
                              <div>
                                <div
                                  class="text-h6 q-mt-sm"
                                  style="font-size: 13px; font-weight: 400; line-height: 1.2;"
                                >
                                  Address
                                </div>
                                <div
                                  class="text-subtitle2"
                                  style="margin-top: 2px;"
                                >
                                  {{ user.address }}
                                </div>
                              </div>
                            </q-card-section>
                          </div> -->
                        </div>

                        <div class="row">
                          <div class="col-lg-6 col-xl-6">
                            <br/>
                            <q-card-section
                              class="row items-center"
                              style="margin-top: -30px"
                            >
                              <div class="circle-icon_phone">
                                <q-icon
                                  name="call"
                                  class="q-ml-xs custom-icon-class"
                                />
                              </div>
                              <div><b>095112231223</b></div>
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
                              <div >
                                <div class="text-subtitle2">
                                  Applied Position / {{ user.AppliedPosition }}
                                </div>
                              </div>
                            </q-card-section>
                          </div>
                          <div
                            class="col-lg-6 col-xl-6"
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
                              />
                              <q-btn
                                class="glossy"
                                size="12px"
                                rounded
                                color="green"
                                label="Accept"
                              />
                            </div>

                            <div v-if="$q.screen.lt.lg">
                              <br/>
                            </div>
                          </div>
                        </div>
                        <q-separator />
                      </q-card>
                      <q-infinite-scroll
                        :offset="100"
                        @load="loadMoreUsers"
                        :disable="!hasMore"
                      >
                        <q-spinner color="primary" />
                      </q-infinite-scroll>
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
import { useLoginCheck } from "src/stores/SignUp_Store";
import { ref, onMounted, computed } from "vue";
import axios from "axios";
export default {
  name: "JobPostList",
  data() {
    return {
      userinfo: [],
      applyToAll: false,
      dialog_sched: false,
      search_jobpost: "",
      jobPosts: [],
      page: 1,
      limit: 10,
      hasMore: true,
      loading: false,
      userData: null, // Initialize userData
      Data_Retrieved: [],
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
  methods: {
    goToPage(page) {
      this.$router.push(page);
    },
    schedule_Dialog() {
      this.dialog_sched = true;
    },
    async loadMoreJobPosts() {
      if (this.loading) return;
      this.loading = true;
      try {
        const response = await axios.get(
          `https://joemarie123.github.io/Fake_API_Testing/JobPost_Sample.json`,
          {
            params: {
              _page: this.page,
              _limit: this.limit,
            },
          }
        );
        console.log("API Response:", response.data); // Log the response data
        const newJobPosts = response.data.JobPost;
        this.jobPosts = this.jobPosts.concat(newJobPosts);
        this.page++;
        this.hasMore = newJobPosts.length === this.limit;
      } catch (error) {
        console.error("Error fetching job posts:", error);
      } finally {
        this.loading = false;
      }
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
  },
  created() {
    this.loadMoreJobPosts();
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
    };
  },
};
</script>

<style scoped>
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
  border-top: 4px solid rgba(33, 82, 187, 0.799);
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
.circle-icon_location {
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
  max-height: 85vh; /* Adjust based on your preference */
  overflow-y: auto;
  width: 100%;
}
/* responsiveeeee */
@media only screen and (max-width: 1439px) {
  .responsive {
    margin-left: 45px; /* or any desired value */
  }
}
@media only screen and (max-width: 1904px) {
  .custom-mx-xxl {
    margin-left: 45px; /* or any desired value */
    margin-right: 35px; /* or any desired value */
  }
}
@media (max-width: 768px) {
  .responsivemd {
    margin-left: 25px; /* or any desired value */
  }
}
</style>
