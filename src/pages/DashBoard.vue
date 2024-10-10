<template>
  <q-page>
    <!-- Main Content -->
    <q-page-section>
      <div class="card_tatal_jobs row q-mx-xl xs:mx-sm q-my-md">
        <!-- Total Jobs Card -->
        <q-card
          class="col-12 col-xl-6 col-lg-6 col-md-11 col-sm-11 custom-card q-mx-md custom_card_TotalJobs"
          style="border-radius: 12px"
        >
          <q-card-section>
            <div class="row items-center" style="margin-top: -12px">
              <div class="row q-mt-md">
                <div class="col-12 text-center">
                  <q-avatar class="custom-avatar" square>
                    <img src="/jobpostingicon.png" />
                  </q-avatar>
                </div>
              </div>
              <div class="col" style="margin-left: 8px; margin-top: 20px">
                <div style="font-size: 14px">Vacant Positions</div>
                <div
                  data-aos="fade-in"
                  data-aos-duration="1500"
                  class="totaljobpostNumber"
                >
                  {{ displayNumber_TotalJobs }}
                </div>
              </div>
            </div>
          </q-card-section>

          <div class="q-mx-md q-my-sm">
            <q-separator></q-separator>
          </div>

          <q-card-section>
            <div class="row" style="margin-top: -38px; margin-left: -10px">
              <div class="col-3">
                <q-card-section class="row items-center">
                  <div>
                    <div class="text-h6 numbersize">
                      {{ TransferArrayData.ActiveJobs }}
                    </div>
                    <div
                      class="text-subtitle2 totalapplicant"
                      style="margin-top: -8px"
                    >
                      Active Job Posts
                    </div>
                  </div>
                </q-card-section>
              </div>

              <div class="col-3">
                <q-card-section class="row items-center">
                  <div>
                    <div class="text-h6 numbersize">
                      {{ TransferArrayData.totaljobs }}
                    </div>
                    <div
                      class="text-subtitle2 totalapplicant"
                      style="margin-top: -8px"
                    >
                      Total Job Posting
                    </div>
                  </div>
                </q-card-section>
              </div>

              <div class="col-3">
                <q-card-section class="row items-center">
                  <div>
                    <div class="text-h6 numbersize">
                      {{ TransferArrayData.ClosedJobs }}
                    </div>
                    <div
                      class="text-subtitle2 totalapplicant"
                      style="margin-top: -8px"
                    >
                      Closed Job
                    </div>
                  </div>
                </q-card-section>
              </div>

              <div class="col-3">
                <q-card-section class="row items-center">
                  <div>
                    <div class="text-h6 numbersize">
                      {{ TransferArrayData.OverdueJobs }}
                    </div>
                    <div
                      class="text-subtitle2 totalapplicant"
                      style="margin-top: -8px"
                    >
                      Overdue Posting
                    </div>
                  </div>
                </q-card-section>
              </div>

              <!--  <div class="col-4">
                <q-card-section class="row items-center">
                  <div>
                    <div
                      class="text-h6"
                      style="font-size: 13px; font-weight: 400"
                    >
                      Potential Applicant
                    </div>
                    <div class="text-subtitle2" style="margin-top: -8px">
                      451
                    </div>
                  </div>
                </q-card-section>
              </div> -->

              <!--   <div class="col-2">
                <q-card-section class="row items-center">
                  <div>
                    <div
                      class="text-h6"
                      style="font-size: 13px; font-weight: 400"
                    >
                      Hired
                    </div>
                    <div class="text-subtitle2" style="margin-top: -8px">
                      478
                    </div>
                  </div>
                </q-card-section>
              </div> -->
            </div>
          </q-card-section>
        </q-card>

        <q-card
          class="col-12 col-xl-5 col-lg-5 col-md-11 col-sm-11 custom_card_Applicant custom_card_TotalApplicant"
          style="border-radius: 12px"
        >
          <q-card-section>
            <div class="row items-center" style="margin-top: -12px">
              <div class="row q-mt-md">
                <div class="col-12 text-center">
                  <q-avatar class="custom-avatar" square>
                    <img src="/applicant.png" />
                  </q-avatar>
                </div>
              </div>
              <div class="col" style="margin-left: 8px; margin-top: 20px">
                <div class="total_applicant">Total Applicant</div>
                <div
                  class="totaljobpostNumber"
                  data-aos="fade-in"
                  data-aos-duration="1500"
                >
                  {{ displayNumber_TotalApplicant }}
                </div>
              </div>
            </div>
          </q-card-section>

          <div class="q-mx-md q-my-sm">
            <q-separator></q-separator>
          </div>

          <q-card-section>
            <div class="row" style="margin-top: -38px; margin-left: -10px">
              <div class="col-4">
                <q-card-section class="row items-center">
                  <div>
                    <div class="text-h6 numbersize">75</div>
                    <div
                      class="text-subtitle2 totalapplicant"
                      style="margin-top: -8px"
                    >
                      Potential Applicant
                    </div>
                  </div>
                </q-card-section>
              </div>

              <div class="col-3">
                <q-card-section class="row items-center">
                  <div>
                    <div class="text-h6 numbersize">20</div>
                    <div
                      class="text-subtitle2 totalapplicant"
                      style="margin-top: -8px"
                    >
                      Hired
                    </div>
                  </div>
                </q-card-section>
              </div>

              <div class="col-3">
                <q-card-section class="row items-center">
                  <div>
                    <div class="text-h6 numbersize">30</div>
                    <div
                      class="text-subtitle2 totalapplicant"
                      style="margin-top: -8px"
                    >
                      Pooling
                    </div>
                  </div>
                </q-card-section>
              </div>

              <div class="col-2">
                <q-card-section class="row items-center">
                  <div>
                    <div class="text-h6 numbersize">105</div>
                    <div
                      class="text-subtitle2 totalapplicant"
                      style="margin-top: -8px"
                    >
                      Declined
                    </div>
                  </div>
                </q-card-section>
              </div>
            </div>
          </q-card-section>
        </q-card>
      </div>

      <div class="row q-mx-xl q-my-md">
        <div
          class="col-12 col-xl-6 col-lg-6 col-md-6 col-sm-11"
          style="margin-left: 13px"
        >
          <q-card class="calendaryo" style="border-radius: 12px">
            <Schedule_Calendar />
          </q-card>
        </div>

        <div
          class="scheduleinterview col-12 col-xl-5 col-lg-5 col-md-5 col-sm-11 q-ml-lg"
        >
          <q-card class="scheduleinterview"><Scheduled_List /> </q-card>
        </div>
      </div>
      <div class=""></div>
    </q-page-section>
  </q-page>
</template>

<script>
import Schedule_Calendar from "../components/Schedule_Calendar.vue";
import Scheduled_List from "../components/Scheduled_List.vue";
import { useDashBoard } from "src/stores/DashBoard_Store";
import { useLoginCheck } from "src/stores/SignUp_Store";
import AOS from "aos";
import { ref } from "vue";
import "aos/dist/aos.css";
export default {
  data() {
    return {
      startNumber: 0,
      dialog_sched: false,
      duration: 1500, // duration of the animation in milliseconds
      startTime: null,
      displayNumber_TotalApplicant: 0,
      displayNumber_TotalJobs: 0,
      totalJobs: 453, // Replace with actual data
      totalApplicants: 300, // Replace with actual data

      getAppointment_me: [],
      events: [],

      dayName: "",
      day: "",
      monthName: "",
      year: "",

      Server_day: "",
      Server_monthName: "",
      Server_year: "",
      Server_monthNumber: "",
      time: "",
      retrievedLogin: "",
      ArrayDashboard: [],
      TransferArrayData: [],
    };
  },
  components: {
    Schedule_Calendar,
    Scheduled_List,
  },

  created() {
    this.retrievedLogin = localStorage.getItem("Login");

    const store2 = useLoginCheck();
    let data2 = new FormData();
    data2.append("LoginID", this.retrievedLogin);

    store2.RetrievedData_function(data2).then((res) => {
      this.userinfo = store2.RetrievedData;

      // Directly access the first element of the data array
      this.userData = this.userinfo.data[0];

      console.log("Data Retrieved:", this.userData);

      const store = useDashBoard();
      let data = new FormData();
      data.append("CompanyID", this.userData.ID);

      store.GetDashboard(data).then((res) => {
        this.ArrayDashboard = store.DashBoardArray;
        this.TransferArrayData = this.ArrayDashboard.data[0];
        console.log("DashBoard Count", this.TransferArrayData);
      });
    });
  },

  methods: {
    schedule_Dialog() {
      this.dialog_sched = true;
    },

    animateNumber(timestamp) {
      if (!this.startTime) this.startTime = timestamp;
      const progress = timestamp - this.startTime;
      const progressFraction = progress / this.duration;
      this.displayNumber_TotalApplicant = Math.min(
        Math.floor(
          this.startNumber +
            progressFraction * (this.totalApplicants - this.startNumber)
        ),
        this.totalApplicants
      );
      if (progress < this.duration) {
        requestAnimationFrame(this.animateNumber);
      } else {
        this.displayNumber_TotalApplicant = this.totalApplicants;
      }
    },
    startAnimation() {
      this.startTime = null;
      requestAnimationFrame(this.animateNumber);
    },

    animateNumber_TotalJobs(timestamp) {
      if (!this.startTime) this.startTime = timestamp;
      const progress = timestamp - this.startTime;
      const progressFraction = progress / this.duration;
      this.displayNumber_TotalJobs = Math.min(
        Math.floor(
          this.startNumber +
            progressFraction * (this.totalJobs - this.startNumber)
        ),
        this.totalJobs
      );
      if (progress < this.duration) {
        requestAnimationFrame(this.animateNumber_TotalJobs);
      } else {
        this.displayNumber_TotalJobs = this.totalJobs;
      }
    },
    startAnimation_TotalJobs() {
      this.startTime = null;
      requestAnimationFrame(this.animateNumber_TotalJobs);
    },
  },
  mounted() {
    AOS.init();
    this.startAnimation();
    this.startAnimation_TotalJobs();
  },
  directives: {
    AOS: {
      mounted(el) {
        el.addEventListener("aos:in", () => {
          this.startAnimation();
        });
      },
    },
  },
};
</script>

<style scoped>
.scheduleinterview {
  border-radius: 10px;
  margin-top: -2px;
  margin-left: 13px;
}
.calendaryo {
  margin-left: 4px;
  margin-right: 1px;
}

@media only screen and (max-width: 1439px) {
  .scheduleinterview {
    margin-top: -3px;
    margin-left: 7px;
  }

  .calendaryo {
    margin-left: 10px;
  }
}

@media only screen and (max-width: 1023px) {
  .scheduleinterview {
    margin-top: 6px;
    margin-left: 12px;
    margin-right: 1px;
  }
}

@media only screen and (max-width: 599px) {
  .card_tatal_jobs {
    margin-left: -10px;
    margin-right: 25px;
  }

  .calendaryo {
    margin-left: -50px;
    margin-right: -25px;
  }

  .scheduleinterview {
    margin-top: 4px;
    margin-left: -20px;
    margin-right: -55px;
  }
}

.custom-avatar {
  width: 50px;
  height: 50px;
}

.totaljobpostNumber {
  font-size: 20px;
  font-weight: bolder;
}

.total_applicant {
  font-size: 14px;
}

.numbersize {
  font-size: 16px;
  font-weight: 400;
  font-weight: bolder;
}
.totalapplicant {
  color: rgb(50, 81, 139);
}

@media only screen and (max-width: 1565px) {
  .numbersize {
    font-size: 14px;
  }

  .totalapplicant {
    color: rgb(50, 81, 139);
    font-size: 12px;
  }

  .custom-avatar {
    width: 45px;
    height: 45px;
  }

  .total_applicant {
    font-size: 12px;
  }

  .totaljobpostNumber {
    font-size: 15px;
    font-weight: bolder;
  }
}

@media only screen and (max-width: 1440px) {
  .custom_card_TotalApplicant {
    margin-left: 19px;
    margin-top: 10px;
  }
  .totalapplicant {
    color: rgb(50, 81, 139);
    font-weight: bold;
    font-size: 14px;
  }

  .numbersize {
    font-size: 16px;
  }

  .custom-avatar {
    width: 50px;
    height: 50px;
  }
}

.icon-background {
  background-color: rgba(34, 72, 223, 0.132);

  border-radius: 10%;
  padding: 10px;
}

.custom_card_TotalJobs {
  border-top: 4px solid rgba(46, 173, 8, 0.799);
  border-radius: 8px;
  overflow: hidden;
}

.custom_card_TotalApplicant {
  border-top: 4px solid rgba(46, 173, 8, 0.799);
  border-radius: 8px;
  overflow: hidden;
}
</style>
