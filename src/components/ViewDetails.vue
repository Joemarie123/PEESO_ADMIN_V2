<template>
  <q-btn
    style="margin: 10px"
    @click="$router.push('/ViewAllJobs').catch((err) => {})"
    outline
    rounded
    color="green"
    label="BACK"
  />
  <div style="margin-top: 12px" class="profile-card">
    <div class="row profile-container">
      <div class="profile-avatar relative-position">
        <q-avatar
          @click="triggerFileUpload"
          class="avatar"
          style="cursor: pointer"
        >
          <img :src="imageUrl" />
        </q-avatar>
        <input
          type="file"
          ref="fileInput"
          style="display: none"
          @change="handleFileUpload"
          accept="image/*"
        />
        <!--   <q-icon
          @click="triggerFileUpload"
          name="camera_alt"
          size="24px"
          class="camera-icon absolute-bottom-right"
          style="cursor: pointer; border-radius: 50%; padding: 4px"
        /> -->
      </div>
      <!--       <q-btn @click="ImagetoDatabase" color=""> Update </q-btn> -->
      <div class="col-12" style="text-align: center">
        <p style="font-weight: 500; margin-bottom: -2px">
          <span style="font-size: 15px">
            {{ Profilepic.personalRecord.Firstname }}
            {{ Profilepic.personalRecord.Surname }}
          </span>
        </p>
        <p>Web Development, JavaScript, CSS, HTML</p>
      </div>
    </div>
  </div>

  <div class="row">
    <q-card class="col-10 skill-card">
      <q-card-section style=""
        ><p style="font-weight: 500; font-size: 16px">Basic Information</p>

        <div class="row">
          <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
            <p>
              Age <br />
              <b>{{ calculateAge(Profilepic.personalRecord.BirthDate) }}</b>
            </p>
            <p>
              Gender <br />
              <b>{{ Profilepic.personalRecord.Sex }}</b>
            </p>
          </div>

          <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
            <p>
              Email Address <br />
              <b>{{ Profilepic.personalRecord.Email }}</b>
            </p>

            <p>
              Address <br />
              <b>{{ Profilepic.personalRecord.Address }}</b>
            </p>
          </div>

          <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
            <p>
              Contact Number <br />
              <b>{{ Profilepic.personalRecord.ContactNo }}</b>
            </p>

            <p>
              Civil Status <br />
              <b>{{ Profilepic.personalRecord.CivilStatus }}</b>
            </p>
          </div>
        </div>
      </q-card-section>
    </q-card>
  </div>

  <div class="row skill-card">
    <div class="col-11 col-sm-4 col-md-2 col-lg-3 col-xl-3">
      <q-card class="q-ma-sm" style="height: 300px; overflow: auto">
        <q-card-section style="margin-left: 10px">
          <p
            style="
              font-weight: 500;
              font-size: 16px;
              color: darkgreen;
              position: sticky;
              top: 10px;
              background-color: white;
              z-index: 1;
            "
          >
            Tranings
          </p>
          <div
            v-for="(train, index) in trainingsdata"
            :key="index"
            style="margin-top: -10px; margin: 1px; margin-left: 10px"
          >
            <ul style="list-style-type: disc; padding-left: 20px">
              <li style="font-weight: 500; font-size: 16px">
                {{ train.Training }}
              </li>
            </ul>
            <p style="margin-left: 20px; margin-top: -10px">
              From: <b>{{ train.DateFrom }}</b>
            </p>
            <p style="margin-left: 20px; margin-top: -10px">
              To: <b>{{ train.DateTo }}</b>
            </p>
          </div>
        </q-card-section>
      </q-card>
    </div>
    <div class="col-12 col-sm-8 col-md-8 col-lg-9">
      <div class="row">
        <!-- Experience Card -->
        <q-card
          class="q-ma-sm col-10 col-sm-11 col-md-5 col-xl-5 col-lg-4 classCard"
          style="height: 300px; overflow: auto"
        >
          <q-card-section style="margin-left: 10px">
            <p
              style="
                font-weight: 500;
                font-size: 16px;
                color: darkgreen;
                position: sticky;
                top: 10px;
                background-color: white;
                z-index: 1;
              "
            >
              Experience
            </p>
            <div
              v-for="(work, index) in WorkExpArray"
              :key="index"
              style="margin-top: -10px; margin: 1px; margin-left: 10px"
            >
              <ul style="list-style-type: disc; padding-left: 20px">
                <li style="font-weight: 500; font-size: 16px">
                  {{ work.WPosition }}
                </li>
              </ul>
              <p style="margin-left: 20px; margin-top: -10px">
                {{ work.WCompany }} - {{ work.WFrom }}-{{ work.WTo }}
              </p>
            </div>
          </q-card-section>
        </q-card>

        <!-- Education Card -->
        <q-card
          class="q-ma-sm col-10 col-sm-5 col-md-3 col-xl-3 col-lg-3"
          style="height: 300px; overflow: auto"
        >
          <q-card-section style="margin-left: 10px">
            <p
              style="
                font-weight: 500;
                font-size: 16px;
                color: darkgreen;
                position: sticky;
                top: 10px;
                background-color: white;
                z-index: 1;
              "
            >
              Education
            </p>
            <div
              v-for="(Edc, index) in EducArray"
              :key="index"
              style="margin-top: -10px; margin: 1px; margin-left: 10px"
            >
              <ul style="list-style-type: disc; padding-left: 20px">
                <li style="font-weight: 500; font-size: 16px">
                  {{ Edc.Education }}
                </li>
              </ul>
              <p style="margin-left: 20px; margin-top: -10px">
                {{ Edc.Degree }}
              </p>
              <p style="margin-left: 20px; margin-top: -10px">
                {{ Edc.School }}
              </p>
              <p style="margin-left: 20px; margin-top: -10px">
                {{ Edc.DateAttend }}
              </p>
            </div>
          </q-card-section>
        </q-card>

        <!-- Skills Card -->

        <q-card
          class="q-ma-sm col-11 col-sm-5 col-md-3 col-xl-3 col-lg-2"
          style="height: 300px; overflow: auto; width: 250px"
        >
          <q-card-section style="margin-left: 10px">
            <p
              style="
                font-weight: 500;
                font-size: 16px;
                color: darkgreen;
                position: sticky;
                top: 10px;
                background-color: white;
                z-index: 1;
              "
            >
              Skills
            </p>
            <div
              v-for="(skill, index) in SkillsArray"
              :key="index"
              style="margin-top: -10px; margin: 1px; margin-left: 10px"
            >
              <ul style="list-style-type: disc; padding-left: 20px">
                <li style="font-weight: 500; font-size: 16px">
                  {{ skill.Skills }}
                </li>
              </ul>
            </div>
          </q-card-section>
        </q-card>
      </div>
    </div>
  </div>
</template>

<script>
import { useLoginCheck } from "src/stores/SignUp_Store";
import { useQuasar } from "quasar";
export default {
  data() {
    return {
      retrievedLogin: "",
      userinfo: [],
      WorkExpArray: [],
      trainingsdata: [],

      imageUrl: "/upload.jpg",
      file: null,
      rows: [
        { name: "John Doe", age: 30, job: "Developer" },
        { name: "Jane Smith", age: 28, job: "Designer" },
        { name: "Michael Johnson", age: 32, job: "Manager" },
        { name: "Sarah Connor", age: 29, job: "Analyst" },
        { name: "Chris Evans", age: 35, job: "Engineer" },
        { name: "Emma Watson", age: 27, job: "Actress" },
        { name: "Robert Downey", age: 45, job: "Actor" },
        // Add more rows as needed
      ],

      rowEmployers: [
        { name: "John Doe", age: 30, job: "Developer" },
        { name: "Jane Smith", age: 28, job: "Designer" },
        { name: "Michael Johnson", age: 32, job: "Manager" },
        { name: "Sarah Connor", age: 29, job: "Analyst" },
        { name: "Chris Evans", age: 35, job: "Engineer" },
        { name: "Emma Watson", age: 27, job: "Actress" },
        { name: "Robert Downey", age: 45, job: "Actor" },
      ],

      columnEmployer: [
        {
          name: "age",
          label: "DATE HIRED",
          field: "age",
          sortable: true,
          align: "left",
        },
        {
          name: "job",
          label: "BUSINESS NAME",
          field: "job",
          sortable: true,
          align: "left",
        },
        {
          name: "age",
          label: "STATUS",
          field: "age",
          sortable: true,
          align: "left",
        },
        {
          name: "age",
          label: "ACTION",
          field: "age",
          sortable: true,
          align: "left",
        },
      ],
      transferUser: [],
      Profilepic: [],
      EducArray: [],
      SkillsArray: [],

      ControlnoDetails: "",
      columns: [
        {
          name: "name",
          label: "DATE",
          field: "name",
          sortable: true,
          align: "left",
        },
        { name: "age", label: "JOB", field: "age", sortable: true },
        { name: "job", label: "ACTIONS", field: "job", sortable: true },
      ],
      pagination: {
        rowsPerPage: 5, // This controls how many rows are shown per page; set to the number you want to show
      },
    };
  },

  watch: {
    "store.RetrievedData"(newval) {
      this.imageUrl = newval.data[0].pic;
    },
  },

  methods: {
    calculateAge(birthDate) {
      const today = new Date();
      const dob = new Date(birthDate);
      let age = today.getFullYear() - dob.getFullYear();
      const monthDiff = today.getMonth() - dob.getMonth();

      if (
        monthDiff < 0 ||
        (monthDiff === 0 && today.getDate() < dob.getDate())
      ) {
        age--;
      }

      return age;
    },

    async ImagetoDatabase() {
      const store = useLoginCheck();
      let data = new FormData();
      if (this.file) {
        data.append("file", this.file);
      }
      data.append("userid", this.transferUser.PMID);

      store.Store_ImageDatabase(data).then((res) => {
        /*  console.log("Response Store Image:", res.data); */
        const store2 = useLoginCheck();
        let data2 = new FormData();
        data2.append("action", "view");
        data2.append("ControlNo", this.transferUser.ControlNo);
        store2.PersonalData(data2).then((res) => {
          this.Profilepic = store2.PI;
          /*   this.transferUser = this.Profilepic.personalRecord; */
          console.log("Profile PIC", this.transferUser);
          this.imageUrl = this.Profilepic.personalRecord.pic;
          this.showSuccessfullyUPdated();
        });
      });
    },

    triggerFileUpload() {
      this.$refs.fileInput.click();
    },
    handleFileUpload(event) {
      const file = event.target.files[0];
      if (file) {
        this.file = file; // bind the file object to the data property
        const reader = new FileReader();
        reader.onload = (e) => {
          this.imageUrl = e.target.result; // set the image URL to the loaded file
          this.ImagetoDatabase();
        };
        reader.readAsDataURL(file); // read the file as a data URL
      }
    },
  },

  created() {
    const storeControlno = localStorage.getItem("ControlNo_ViewDetails");

    if (storeControlno) {
      try {
        this.ControlnoDetails = JSON.parse(storeControlno);
        /*    console.log("Fetched Calendar Events:", this.CalendarArray); */
      } catch (error) {
        /*          console.error("Error parsing stored calendar data:", error); */
      }
    } else {
      /*         console.log("No calendar data found in localStorage."); */
    }

    const store2 = useLoginCheck();
    let data2 = new FormData();
    data2.append("action", "view");
    data2.append("ControlNo", this.ControlnoDetails);
    store2.PersonalData(data2).then((res) => {
      this.Profilepic = store2.PI;
      console.log("Profile PIC", this.Profilepic);
      this.imageUrl = this.Profilepic.personalRecord.pic;
    });

    const store3 = useLoginCheck();
    let data3 = new FormData();
    data3.append("action", "view");
    data3.append("ControlNo", this.ControlnoDetails);

    store3.WorkExperience_Data(data3).then((res) => {
      this.WorkExpArray = store3.WE;

      console.log("WorkExpe => ", this.WorkExpArray);
    });

    const store4 = useLoginCheck();
    let data4 = new FormData();
    data4.append("action", "view");
    data4.append("ControlNo", this.ControlnoDetails);

    store4.EducationalData(data4).then((res) => {
      this.EducArray = store4.EB;

      console.log("Educ Background => ", this.EducArray);
    });

    const store5 = useLoginCheck();
    let data5 = new FormData();
    data5.append("action", "view");
    data5.append("ControlNo", this.ControlnoDetails);

    store5.SkillsData(data5).then((res) => {
      this.SkillsArray = store5.SH.data;

      console.log("Skills => ", this.SkillsArray);
    });

    const store6 = useLoginCheck();
    let data6 = new FormData();
    data6.append("action", "view");
    data6.append("ControlNo", this.ControlnoDetails);

    store6.TrainingData(data6).then((res) => {
      this.trainingsdata = store6.LD.data;
      console.log("TrainingData => ", this.trainingsdata);
    });
  },

  setup() {
    const $q = useQuasar();

    return {
      showSuccessfullyUPdated() {
        $q.notify({
          icon: "star_half",
          color: "green",
          message: "Sucessfully Updated",
          position: "center",
          timeout: "1500",
        });
      },
    };
  },

  computed: {
    limitedRows() {
      // Limit the rows to the number set in pagination rowsPerPage
      return this.rows.slice(0, this.pagination.rowsPerPage);
    },
    limitedRowsEmployers() {
      // Limit the rows to the number set in pagination rowsPerPage
      return this.rowEmployers.slice(0, this.pagination.rowsPerPage);
    },
  },
};
</script>

<style scoped>
.q-card::-webkit-scrollbar {
  width: 4px;
}

.q-card::-webkit-scrollbar-thumb {
  background-color: #788178; /* Scrollbar color */
  border-radius: 5px;
}

.q-card::-webkit-scrollbar-track {
  background-color: #f1f1f1; /* Track color */
}

.classCard {
  overflow-y: auto;
  scrollbar-width: unset;
}

.relative-position {
  position: relative;
}

.camera-icon {
  right: 0;
  bottom: 20px;
  background-color: black;
  color: white;
}

.avatar {
  width: 100px;
  height: 100px;
}

.profile-card {
  max-width: 80%;
  margin: auto;
  margin-top: 2%;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.skill-card {
  max-width: 80%;
  margin: auto;
  margin-top: 2%;
  border-radius: 5px;
  overflow: hidden;
}

/* .skill-card_1 {
  max-width: 87%;
  margin: auto;
  margin-left: 135px;
  margin-top: 2%;
  border-radius: 5px;
  overflow: hidden;
} */

.profile-container {
  display: flex;
  align-items: center;
  justify-content: center; /* Center horizontally */
  background: linear-gradient(to bottom, #06372c 50%, #ffffff 50%);
  padding: 20px;
  height: 100%; /* Ensure the container fills vertical space */
}

.profile-avatar {
  flex: 0 0 150px;
  display: flex;
  justify-content: center;
  align-items: center;
  background: white;
  padding: 10px;
  border-radius: 50%;
}

.avatar {
  width: 150px;
  height: 150px;
  border-radius: 50%;
  overflow: hidden;
}

.profile-details {
  flex: 1;
  padding: 10px;
  text-align: left;
}
.title {
  color: white;
}

.profile-details h2 {
  margin: 0 0 10px 0;
  font-size: 24px;
}

.profile-details p {
  margin: 5px 0;
  font-size: 15px;
}

/* Responsive design */
@media (max-width: 768px) {
  .profile-container {
    flex-direction: column;
    align-items: center;
    background: linear-gradient(to bottom, rgb(3, 69, 113) 50%, #ffffff 50%);
    padding: 20px;
  }

  .profile-avatar {
    margin-right: 0;
    margin-bottom: 20px;
    background: white; /* Blue background for the avatar */
  }

  .profile-details {
    text-align: center;
    background: #ffffff; /* White background for the details */
    padding: 20px;
    border-radius: 8px;
  }
  .title {
    color: black;
  }
}
</style>
