<template>
  <q-page>
    <div class="row q-mx-lg q-my-lg">
      <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
        <q-card class="card_1" style="border-radius: 12px">
          <div class="row">
            <div class="col-12 col-sm-9 col-md-9 col-lg-9 col-xl-9">
              <div class="flex-container">
                <div class="q-mx-lg q-mt-lg">
                  <p style="font-size: 25px"><b>Create Job Posting</b></p>
                  <p style="margin-bottom: -8px">
                    Please Enter Information Details
                  </p>
                </div>
              </div>
            </div>

            <div
              class="uploadpic_margin col-12 col-sm-3 col-md-3 col-lg-3 col-xl-3 q-mt-md"
              style="margin-top: 11px"
            >
              <q-avatar
                square=""
                size="65px"
                class="hoverimage"
                @click="triggerFileUpload"
                style="margin-left: 30px"
              >
                <img :src="imageUrl" alt="Upload" />
                <div
                  data-aos="fade-in"
                  data-aos-duration="1500"
                  v-if="errors.file"
                  class="tooltip_JobProfile"
                >
                  {{ errors.file }}
                </div>
              </q-avatar>
              <p style="margin-left: 5px">Upload Campaign Add</p>

              <input
                type="file"
                ref="fileInput"
                style="display: none"
                @change="handleFileUpload"
                accept="image/*"
              />
            </div>
          </div>
          <!--   <q-form > -->
          <div class="row q-mx-xs q-px-md q-py-md" style="margin-top: -23px">
            <div class="col-12">
              <div class="flex-container">
                <input
                  type="text"
                  placeholder="Job Title"
                  v-model="txtjobtitle"
                  @focus="hideErrorTooltip('jobtitle')"
                  class="inputbai custom-input"
                />
                <q-icon name="add_business" class="input-icon" />
                <div
                  data-aos="fade-in"
                  data-aos-duration="1500"
                  v-if="showTooltip.jobtitle && errors.txtjobtitle"
                  class="tooltip_jobtitle"
                >
                  {{ errors.txtjobtitle }}
                </div>
              </div>
            </div>
          </div>

          <div class="row q-px-md q-pb-md">
            <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 q-px-xs">
              <div class="flex-container">
                <input
                  type="text"
                  v-model="txtsalary"
                  placeholder="Expected Salary"
                  class="inputbai custom-input"
                  @input="validate_ExpectedSalary"
                  @focus="hideErrorTooltip('salary')"
                />
                <q-icon name="payments" class="input-icon" />
                <div
                  data-aos="fade-in"
                  data-aos-duration="1500"
                  v-if="showTooltip.salary && errors.txtsalary"
                  class="tooltip"
                >
                  {{ errors.txtsalary }}
                </div>
              </div>
            </div>

            <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 q-px-xs">
              <div class="flex-container">
                <input
                  type="text"
                  placeholder="Vacant Count"
                  v-model="txtvacantcount"
                  @input="validate_VacantCount"
                  class="inputbai custom-input mobileresponsive"
                  @focus="hideErrorTooltip('vacantcount')"
                />
                <q-icon name="chair_alt" class="input-icon" />
                <div
                  data-aos="fade-in"
                  data-aos-duration="1500"
                  v-if="showTooltip.vacantcount && errors.txtvacantcount"
                  class="tooltip"
                >
                  {{ errors.txtvacantcount }}
                </div>
              </div>
            </div>
          </div>

          <div class="row q-px-md q-pb-md">
            <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 q-px-xs">
              <div class="flex-container input-container">
                <label for="date-from">Date From</label>
                <input
                  @focus="hideErrorTooltip('datefrom')"
                  v-model="txtdate_from"
                  type="date"
                  id="date-checkin"
                />
                <div
                  data-aos="fade-in"
                  data-aos-duration="1500"
                  v-if="showTooltip.datefrom && errors.txtdate_from"
                  class="tooltip"
                >
                  {{ errors.txtdate_from }}
                </div>
              </div>
            </div>

            <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 q-px-xs">
              <div
                class="flex-container input-container mobileresponsive_date_to"
              >
                <label for="date-from">Date To</label>
                <input
                  @focus="hideErrorTooltip('dateto')"
                  v-model="txtdate_to"
                  type="date"
                  id="date-checkin"
                />
                <div
                  data-aos="fade-in"
                  data-aos-duration="1500"
                  v-if="showTooltip.dateto && errors.txtdate_to"
                  class="tooltip"
                >
                  {{ errors.txtdate_to }}
                </div>
              </div>
            </div>
          </div>

          <div class="row q-px-md q-pb-md">
            <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 q-px-xs">
              <div class="flex-container">
                <input
                  @focus="hideErrorTooltip('numhours')"
                  type="text"
                  @input="validate_Numhours"
                  placeholder="Number of Hours"
                  v-model="txtnumber_hours"
                  class="inputbai custom-input"
                />
                <q-icon name="chair_alt" class="input-icon" />
                <div
                  data-aos="fade-in"
                  data-aos-duration="1500"
                  v-if="showTooltip.numhours && errors.txtnumber_hours"
                  class="tooltip"
                >
                  {{ errors.txtnumber_hours }}
                </div>
              </div>
            </div>

            <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 q-px-xs">
              <div class="flex-container">
                <!--  <input
                  @focus="hideErrorTooltip('naturework')"
                  type="text"
                  placeholder="Nature of Work"
                  v-model="txtnatureofWork"
                  class="inputbai custom-input mobileresponsive"
                />
 -->
                <select
                  v-model="txtnatureofWork"
                  class="inputbai custom-input mobileresponsive"
                  @focus="hideErrorTooltip('naturework')"
                >
                  <option disabled value="">
                    <span class="siffixcss">Nature of Work</span>
                  </option>
                  <!-- Add your options here -->
                  <option value="Permanent">Permanent</option>
                  <option value="Contractual">Contractual</option>
                  <option value="Part-time">Part-time</option>
                  <option value="Project-based">Project-based</option>
                  <option value="Internship/OJT">Internship/OJT</option>
                </select>

                <q-icon name="work" class="input-icon" />
                <div
                  data-aos="fade-in"
                  data-aos-duration="1500"
                  v-if="showTooltip.naturework && errors.txtnatureofWork"
                  class="tooltip"
                >
                  {{ errors.txtnatureofWork }}
                </div>
              </div>
            </div>
          </div>

          <div class="row q-px-md q-pb-md">
            <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 q-px-xs">
              <div class="flex-container">
                <!--  <input
                  @focus="hideErrorTooltip('educationlevel')"
                  type="text"
                  v-model="txteducation_Level"
                  placeholder="Educational Level"
                  class="inputbai custom-input"
                /> -->
                <select
                  v-model="txteducation_Level"
                  class="inputbai custom-input mobileresponsive"
                  @focus="hideErrorTooltip('educationlevel')"
                >
                  <option disabled value="">
                    <span class="siffixcss">Educational Level</span>
                  </option>
                  <!-- Add your options here -->

                  <option value="Elementary Graduate">
                    Elementary Graduate
                  </option>
                  <option value="High School Graduate">
                    High School Graduate
                  </option>
                  <option value="College Level">College Level</option>
                  <option value="Graduate/Post Graduate Studies">
                    Graduate/Post Graduate Studies
                  </option>
                  <option value="College Graduate">College Graduate</option>
                </select>

                <q-icon name="history_edu" class="input-icon" />
                <div
                  data-aos="fade-in"
                  data-aos-duration="1500"
                  v-if="showTooltip.educationlevel && errors.txteducation_Level"
                  class="tooltip"
                >
                  {{ errors.txteducation_Level }}
                </div>
              </div>
            </div>

            <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 q-px-xs">
              <div class="flex-container">
                <input
                  @focus="hideErrorTooltip('course')"
                  type="text"
                  placeholder="Course"
                  class="inputbai custom-input mobileresponsive"
                  v-model="txtcourse"
                />
                <q-icon name="school" class="input-icon" />
                <div
                  data-aos="fade-in"
                  data-aos-duration="1500"
                  v-if="showTooltip.course && errors.txtcourse"
                  class="tooltip"
                >
                  {{ errors.txtcourse }}
                </div>
              </div>
            </div>
          </div>

          <div class="row q-px-md q-pb-md">
            <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 q-px-xs">
              <div class="flex-container">
                <input
                  @focus="hideErrorTooltip('experience')"
                  type="text"
                  @input="validate_Experience"
                  v-model="txtworkexperience"
                  placeholder="Enter Years of Experience"
                  class="inputbai custom-input"
                />
                <q-icon name="receipt_long" class="input-icon" />
                <div
                  data-aos="fade-in"
                  data-aos-duration="1500"
                  v-if="showTooltip.experience && errors.txtworkexperience"
                  class="tooltip"
                >
                  {{ errors.txtworkexperience }}
                </div>
              </div>
            </div>

            <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 q-px-xs">
              <div class="flex-container">
                <input
                  @focus="hideErrorTooltip('license')"
                  type="text"
                  v-model="txtlicense"
                  placeholder="Required License"
                  class="inputbai custom-input mobileresponsive"
                />
                <q-icon name="recent_actors" class="input-icon" />
                <div
                  data-aos="fade-in"
                  data-aos-duration="1500"
                  v-if="showTooltip.license && errors.txtlicense"
                  class="tooltip"
                >
                  {{ errors.txtlicense }}
                </div>
              </div>
            </div>

            <div class="col-12 q-px-xs q-py-md">
              <div class="flex-container">
                <input
                  @focus="hideErrorTooltip('placeofwork')"
                  type="text"
                  placeholder="Place of Work"
                  v-model="txtplaceofwork"
                  class="inputbai custom-input"
                />
                <q-icon name="add_business" class="input-icon" />
                <div
                  data-aos="fade-in"
                  data-aos-duration="1500"
                  v-if="showTooltip.placeofwork && errors.txtplaceofwork"
                  class="tooltip_placeofwork"
                >
                  {{ errors.txtplaceofwork }}
                </div>
              </div>
            </div>

            <div class="col-12 q-px-xs q-py-xs">
              <div class="flex-container">
                <q-icon name="note_add" class="input-icon" />
                <div class="inputbai custom-input_AddTags" @click="focusInput">
                  <template v-for="(item, index) in items" :key="index">
                    <q-chip
                      removable
                      @remove="removeItem(index)"
                      class="chip-inline"
                      >{{ item }}</q-chip
                    >
                  </template>

                  <input
                    @focus="hideErrorTooltip('addtags')"
                    ref="inputField"
                    type="text"
                    placeholder="Add Tags"
                    class="chips-input-field"
                    @keyup.enter="addItem"
                    v-model="txtaddtags"
                  />
                </div>

                <div
                  data-aos="fade-in"
                  data-aos-duration="1500"
                  v-if="showTooltip.addtags && errors.txtaddtags"
                  class="tooltip_placeofwork"
                >
                  {{ errors.txtaddtags }}
                </div>
              </div>
            </div>
          </div>
          <!--   </q-form> -->
        </q-card>
      </div>

      <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 q-px-md">
        <q-card class="card_1 cardmargin" style="border-radius: 12px">
          <div class="row">
            <div class="col-9">
              <div class="flex-container">
                <div class="q-mx-lg q-mt-lg">
                  <p style="font-size: 25px"><b>Create Description</b></p>
                  <p style="margin-bottom: -8px">
                    Please Enter Description Details
                  </p>
                </div>
              </div>
            </div>
          </div>

          <div class="row q-mx-xs q-px-md q-py-md" style="margin-top: -2px">
            <div class="col-12">
              <div class="flex-container">
                <div class="q-pa-xs" style="width: 940px">
                  <q-editor
                    v-model="txtdescription"
                    :dense="$q.screen.lt.md"
                    :toolbar="toolbarOptions"
                    :fonts="{
                      arial: 'Arial',
                      arial_black: 'Arial Black',
                      comic_sans: 'Comic Sans MS',
                      courier_new: 'Courier New',
                      impact: 'Impact',
                      lucida_grande: 'Lucida Grande',
                      times_new_roman: 'Times New Roman',
                      verdana: 'Verdana',
                    }"
                    style="height: 370px; overflow: auto"
                  />
                </div>
                <div
                  data-aos="fade-in"
                  data-aos-duration="1500"
                  v-if="errors.txtdescription"
                  class="tooltip_description"
                >
                  {{ errors.txtdescription }}
                </div>
              </div>
            </div>
            <!-- <p>{{ userData.Company_name }}</p> -->
            <!--  <div>{{ companyName }}</div> -->
            <div class="col-12 q-px-xs q-py-md">
              <div class="flex-container">
                <button
                  class="custom-input_button custom_input_button"
                  @click="validateForm()"
                >
                  SUBMIT
                </button>
              </div>
            </div>
          </div>
        </q-card>
      </div>
    </div>
  </q-page>
</template>

<script>
import { useJobpost } from "src/stores/JobPost_Store";
import { useLoginCheck } from "src/stores/SignUp_Store";
import { useQuasar } from "quasar";
import { defineComponent } from "vue";
import { ref } from "vue";

export default defineComponent({
  name: "MonthSlotWeek",
  data() {
    return {
      txtaddtags: "",
      items: [], // Array to store the entered items
      userinfo: [],
      userData: null, // Initialize userData
      retrievedLogin: "",
      imgurl: "",
      imageUrl: "/upload.jpg",
      qeditor: "",
      txtjobtitle: "",
      txtsalary: "",
      txtvacantcount: "",
      txtdate_from: "",
      txtdate_to: "",
      txtnumber_hours: "",
      txtnatureofWork: "",
      txteducation_Level: "",
      txtcourse: "",
      txtworkexperience: "",
      txtlicense: "",
      txtplaceofwork: "",
      txtdescription: "",
      file: null,
      /*  showTooltip: true, */
      errors: {
        txtjobtitle: "",
        txtsalary: "",
        txtvacantcount: "",
        txtdate_from: "",
        txtdate_to: "",
        txtnumber_hours: "",
        txtnatureofWork: "",
        txteducation_Level: "",
        txtcourse: "",
        txtworkexperience: "",
        txtlicense: "",
        txtplaceofwork: "",
        txtdescription: "",
        txtaddtags: "",
        file: null,
      },

      showTooltip: {
        jobtitle: true,
        salary: true,
        vacantcount: true,
        datefrom: true,
        dateto: true,
        numhours: true,
        naturework: true,
        educationlevel: true,
        course: true,
        experience: true,
        license: true,
        placeofwork: true,
        addtags: true,
      },
    };
  },

  setup() {
    const $q = useQuasar();

    return {
      showsuccessfulldialog() {
        $q.notify({
          icon: "star",
          color: "green",
          message: "Successfully Saved",
          position: "center",
          timeout: "1500",
        });
      },
    };
  },

  watch: {
    txtjobtitle(newVal) {
      if (newVal) {
        this.errors.txtjobtitle = "";
      }
    },

    txtsalary(newVal) {
      if (newVal) {
        this.errors.txtsalary = "";
      }
    },

    txtvacantcount(newVal) {
      if (newVal) {
        this.errors.txtvacantcount = "";
      }
    },

    txtdate_from(newVal) {
      if (newVal) {
        this.errors.txtdate_from = "";
      }
    },

    txtdate_to(newVal) {
      if (newVal) {
        this.errors.txtdate_to = "";
      }
    },

    txtnumber_hours(newVal) {
      if (newVal) {
        this.errors.txtnumber_hours = "";
      }
    },

    txtjobtitle(newVal) {
      if (newVal) {
        this.errors.txtjobtitle = "";
      }
    },

    txtnatureofWork(newVal) {
      if (newVal) {
        this.errors.txtnatureofWork = "";
      }
    },

    file(newVal) {
      if (newVal) {
        this.errors.file = null;
      }
    },

    txtjobtitle(newVal) {
      if (newVal) {
        this.errors.txtjobtitle = "";
      }
    },

    txteducation_Level(newVal) {
      if (newVal) {
        this.errors.txteducation_Level = "";
      }
    },

    txtjobtitle(newVal) {
      if (newVal) {
        this.errors.txtjobtitle = "";
      }
    },

    txtcourse(newVal) {
      if (newVal) {
        this.errors.txtcourse = "";
      }
    },

    txtworkexperience(newVal) {
      if (newVal) {
        this.errors.txtworkexperience = "";
      }
    },

    txtlicense(newVal) {
      if (newVal) {
        this.errors.txtlicense = "";
      }
    },

    txtplaceofwork(newVal) {
      if (newVal) {
        this.errors.txtplaceofwork = "";
      }
    },

    txtdescription(newVal) {
      if (newVal) {
        this.errors.txtdescription = "";
      }
    },

    txtaddtags(newVal) {
      if (newVal) {
        this.errors.txtaddtags = "";
      }
    },
  },

  methods: {
    focusInput() {
      this.$refs.inputField.focus();
    },

    addItem() {
      const trimmedValue = this.txtaddtags.trim();
      if (trimmedValue) {
        this.items.push(trimmedValue);
        this.txtaddtags = ""; // Clear the input field
        console.log("TAGS", this.items);
      }
    },
    removeItem(index) {
      this.items.splice(index, 1); // Remove the item at the given index
    },

    validate_ExpectedSalary(event) {
      // Remove non-digit characters
      let cleaned = event.target.value.replace(/\D/g, "");
      // Limit to 11 characters
      if (cleaned.length > 11) {
        cleaned = cleaned.substring(0, 11);
      }
      // Set the cleaned value back to the model
      this.txtsalary = cleaned;
    },

    validate_VacantCount(event) {
      // Remove non-digit characters
      let cleaned = event.target.value.replace(/\D/g, "");
      // Limit to 11 characters
      if (cleaned.length > 11) {
        cleaned = cleaned.substring(0, 11);
      }
      // Set the cleaned value back to the model
      this.txtvacantcount = cleaned;
    },

    validate_Numhours(event) {
      // Remove non-digit characters
      let cleaned = event.target.value.replace(/\D/g, "");
      // Limit to 11 characters
      if (cleaned.length > 11) {
        cleaned = cleaned.substring(0, 11);
      }
      // Set the cleaned value back to the model
      this.txtnumber_hours = cleaned;
    },

    validate_Experience(event) {
      // Remove non-digit characters
      let cleaned = event.target.value.replace(/\D/g, "");
      // Limit to 11 characters
      if (cleaned.length > 11) {
        cleaned = cleaned.substring(0, 11);
      }
      // Set the cleaned value back to the model
      this.txtworkexperience = cleaned;
    },

    hideErrorTooltip(field) {
      this.showTooltip[field] = false;
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
        };
        reader.readAsDataURL(file); // read the file as a data URL
      }
    },
    clearErrors() {
      this.errors.txtjobtitle = "";
      this.errors.txtsalary = "";
      this.errors.txtvacantcount = "";
      this.errors.txtdate_from = "";
      this.errors.txtdate_to = "";
      this.errors.txtnumber_hours = "";
      this.errors.txtnatureofWork = "";
      this.errors.txteducation_Level = "";
      this.errors.txtcourse = "";
      this.errors.txtworkexperience = "";
      this.errors.txtlicense = "";
      this.errors.txtplaceofwork = "";
      this.errors.txtdescription = "";
    },

    async validateForm() {
      this.clearErrors();
      let valid = true;

      if (!this.txtjobtitle) {
        this.errors.txtjobtitle = "Please Fill up Job Title";
        valid = false;
      }
      console.log("before save1", valid);
      if (!this.txtsalary) {
        this.errors.txtsalary = "Please Fill up Salary Expected";
        valid = false;
      }
      console.log("before save2", valid);
      if (!this.txtvacantcount) {
        this.errors.txtvacantcount = "Please Fill up Vacant Count";
        valid = false;
      }
      console.log("before save3", valid);
      if (!this.txtdate_from) {
        this.errors.txtdate_from = "Please Fill Date From";
        valid = false;
      }
      console.log("before save4".valid);
      if (!this.txtdate_to) {
        this.errors.txtdate_to = "Please Fill up Date To";
        valid = false;
      }
      console.log("before save5", valid);
      if (!this.txtnumber_hours) {
        this.errors.txtnumber_hours = "Please Fill up Number of Hours";
        valid = false;
      }
      console.log("before save6", valid);
      if (!this.txtnatureofWork) {
        this.errors.txtnatureofWork = "Please Fill up Nature of Work";
        valid = false;
      }
      console.log("before save7", valid);
      if (!this.txteducation_Level) {
        this.errors.txteducation_Level = "Please Fill up Educational Level";
        valid = false;
      }
      console.log("before save8", valid);
      if (!this.txtcourse) {
        this.errors.txtcourse = "Please Fill up Course";
        valid = false;
      }
      console.log("before save9", valid);
      if (!this.txtworkexperience) {
        this.errors.txtworkexperience = "Please Fill up Experience";
        valid = false;
      }
      console.log("before save1o", valid);
      if (!this.txtlicense) {
        this.errors.txtlicense = "Please Fill up License Required";
        valid = false;
      }
      console.log("before save11", valid);
      if (!this.txtplaceofwork) {
        this.errors.txtplaceofwork = "Please Fill up Place of Work";
        valid = false;
      }
      console.log("before save12", valid);
      if (!this.txtdescription) {
        this.errors.txtdescription = "Please Fill up Description";
        valid = false;
      }
      console.log("before save13", valid);
      /*  if (!this.txtaddtags) {
        this.errors.txtaddtags = "Please Fill up Tags";
        valid = false;
      } */

      console.log("before save14", this.txtaddtags);
      if (!this.file) {
        this.errors.file = "Please Choose Job Profile";
        valid = false;
      }
      console.log("before save15", valid);
      if (valid) {
        /*  this.Loading(); */
        this.ClickMe_SavetoDatabase();
      }
    },

    async ClickMe_SavetoDatabase() {
      /*  if (!this.userData) {
        console.error("User data is not available.");
        return;
      } */
      console.log("before2 save");
      const store = useJobpost();
      let data = new FormData();
      data.append("Title", this.txtjobtitle);
      if (this.file) {
        data.append("file", this.file);
      }
      console.log("before3 save");
      data.append("Salary", this.txtsalary);
      data.append("DateFrom", this.txtdate_from);
      data.append("DateTo", this.txtdate_to);
      data.append("Description", this.txtdescription);
      data.append("NumHours", this.txtnumber_hours);
      data.append("Type", this.txtnatureofWork);
      data.append("WorkPlace", this.txtplaceofwork);
      data.append("VacantCount", this.txtvacantcount);
      data.append("EducationLevel", this.txteducation_Level);
      data.append("Course", this.txtcourse);
      data.append("WorkExperience", this.txtworkexperience);
      data.append("License", this.txtlicense);
      data.append("Company_ID", this.userData.ID);
      data.append("tags", JSON.stringify(this.items));
      console.log("before save");
      store.SaveToDatabase_jobPost(data).then((res) => {
        console.log("Response from Save to Database:", res);
        this.showsuccessfulldialog();

        this.txtjobtitle = "";

        this.txtsalary = "";
        this.txtdate_from = "";
        this.txtdate_to = "";
        this.txtdescription = "";
        this.txtnumber_hours = "";
        this.txtnatureofWork = "";
        this.txtplaceofwork = "";
        this.txtvacantcount = "";
        this.txteducation_Level = "";
        this.txtcourse = "";
        this.txtworkexperience = "";
        this.txtlicense = "";
        this.items = "";
        this.txtaddtags = "";
        this.file = { imageUrl: "/upload.jpg" };

        this.$router.push("/ViewAllJobs");
      });
    },
  },

  created() {
    console.log("selected=>", this.$route.params.id);

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

        console.log("Data Retrieved:", this.userData);

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
  },
  /*  computed: {}, */
  computed: {
    companyName() {
      return this.userData ? this.userData.Company_name : "";
    },

    toolbarOptions() {
      if (this.$q.screen.lt.sm) {
        // Toolbar options for small screens
        return [
          ["bold", "italic", "underline", "subscript"],
          [
            {
              label: this.$q.lang.editor.align,
              icon: this.$q.iconSet.editor.align,
              fixedLabel: true,
              list: "only-icons",
              options: ["left", "center", "right", "justify"],
            },
          ],
          ["undo", "redo"],
        ];
      } else if (this.$q.screen.lt.md) {
        // Toolbar options for medium screens
        return [
          [
            {
              label: this.$q.lang.editor.align,
              icon: this.$q.iconSet.editor.align,
              fixedLabel: true,
              list: "only-icons",
              options: ["left", "center", "right", "justify"],
            },
          ],
          ["bold", "italic", "underline", "subscript"],
          [
            {
              label: this.$q.lang.editor.fontSize,
              icon: this.$q.iconSet.editor.fontSize,
              fixedLabel: true,
              fixedIcon: true,
              list: "no-icons",
              options: [
                "size-1",
                "size-2",
                "size-3",
                "size-4",
                "size-5",
                "size-6",
                "size-7",
              ],
            },
          ],
          ["undo", "redo"],
        ];
      } else {
        // Toolbar options for large screens
        return [
          [
            {
              label: this.$q.lang.editor.align,
              icon: this.$q.iconSet.editor.align,
              fixedLabel: true,
              list: "only-icons",
              options: ["left", "center", "right", "justify"],
            },
          ],
          ["bold", "italic", "underline", "subscript"],
          [
            {
              label: this.$q.lang.editor.fontSize,
              icon: this.$q.iconSet.editor.fontSize,
              fixedLabel: true,
              fixedIcon: true,
              list: "no-icons",
              options: [
                "size-1",
                "size-2",
                "size-3",
                "size-4",
                "size-5",
                "size-6",
                "size-7",
              ],
            },
          ],
          ["undo", "redo"],
        ];
      }
    },
  },
});
</script>

<style scoped>
.chips-input-field {
  border: none;
  outline: none;
  flex-grow: 1;
  min-width: 150px; /* Minimum width for the input */
  padding: 8px;
  margin-left: -8px;
  order: 1; /* Ensure the input comes after the chips */
}

@media only screen and (max-width: 599px) {
  .mobileresponsive {
    margin-top: 10px;
  }

  .mobileresponsive_date_to {
    margin-top: 8px;
  }

  .mobileresponsive_Natureofwork {
    margin-top: 8px;
  }
  .uploadpic_margin {
    margin-left: 13px;
  }
}

@media only screen and (max-width: 1439px) {
  .cardmargin {
    margin-top: 10px;
    margin-right: -15px;
    margin-left: -13px;
  }
}

.tooltip_JobProfile {
  position: absolute;
  left: -270%;
  /*   transform: translateX(-50%); */
  bottom: 20px;
  background-color: rgba(203, 205, 201, 0.922);
  color: red;

  padding: 5px 10px;
  border-radius: 4px;
  font-size: 12px;
  white-space: nowrap;
  z-index: 10;
}

.tooltip_description {
  position: absolute;
  left: 2%;
  /*   transform: translateX(-50%); */
  bottom: 270px;
  background-color: rgba(244, 238, 238, 0);
  color: red;

  padding: 5px 10px;
  border-radius: 4px;
  font-size: 12px;
  white-space: nowrap;
  z-index: 10;
}

.tooltip_jobtitle {
  position: absolute;
  left: 5%;
  /*   transform: translateX(-50%); */
  bottom: 7px;
  background-color: rgb(244, 238, 238);
  color: red;

  padding: 5px 10px;
  border-radius: 4px;
  font-size: 12px;
  white-space: nowrap;
  z-index: 10;
}

.tooltip_placeofwork {
  position: absolute;
  left: 5%;
  /*   transform: translateX(-50%); */
  bottom: 7px;
  background-color: rgb(244, 238, 238);
  color: red;

  padding: 5px 10px;
  border-radius: 4px;
  font-size: 12px;
  white-space: nowrap;
  z-index: 10;
}

.tooltip {
  position: absolute;
  left: 10%;
  /*   transform: translateX(-50%); */
  bottom: 7px;
  background-color: rgb(244, 238, 238);
  color: red;

  padding: 5px 10px;
  border-radius: 4px;
  font-size: 12px;
  white-space: nowrap;
  z-index: 10;
}

.custom_input_button {
  padding-left: 20px; /* Space for the icon */
  border-radius: 12px;
  border: 1px solid rgb(253, 253, 253);
  background: linear-gradient(40deg, #279f27, #5fc331);
  color: white;

  cursor: pointer; /* Changes the cursor to a hand pointer */
}

/* CSS CALENDAR START */
/* RESET FORM ELEMENTS */
.input-container input[type="date"],
.input-container input[type="text"] {
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
  background: transparent;
  border: none;
  outline: none;
  box-shadow: none;
}

/* INPUT CONTAINER  */
.input-container {
  display: flex;
  flex-direction: column;
  width: auto;

  height: 50px;
  padding: 5px 10px 10px 10px;
  background: #fff;
  border-radius: 8px;
  border: 1px solid rgb(113, 126, 126);
  overflow: hidden;
  cursor: pointer;
}

.input-container label {
  position: relative;
  width: 100%;
  font-family: "Segoe UI";
  font-weight: 600;
  font-size: 11px;
  letter-spacing: 0.1em;
  line-height: 20px;
  color: rgb(120, 124, 126);
  margin-left: 2px;
  text-transform: uppercase;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.input-container input {
  position: relative;
  align-items: center;
  width: auto;
  height: auto;

  font-family: "Lekton", Arial, sans-serif;
  margin-bottom: -23px;
  font-size: 14px;
  letter-spacing: 0.05em;
  line-height: 21px;
  text-transform: uppercase;
  margin-left: 0px;
}

/* CSS CALENDAR END */

.card_1 {
  border-top: 4px solid rgba(10, 161, 15, 0.799);
}

.input-icon {
  position: absolute;
  top: 50%;
  left: 10px;
  transform: translateY(-50%);
  font-size: 20px;
  color: gray;
}

.custom-input_button {
  width: 100%;
  height: 40px;
  padding-left: 35px; /* Space for the icon */
  margin-right: 10px;
  border-radius: 12px;
  outline: none;
  box-sizing: border-box;
}

.custom-input_AddTags {
  width: 100%;
  max-height: 100px; /* Set the maximum height for the input container */
  overflow-y: auto; /* Add vertical scroll when content exceeds max height */
  padding-left: 40px; /* Space for the icon */
  border-radius: 12px;
  border: 1px solid rgb(113, 126, 126);
  outline: none;
  box-sizing: border-box;
  overflow-y: auto; /* Add vertical scroll when content exceeds max height */
}

.custom-input {
  width: 100%;
  height: 40px;
  padding-left: 40px; /* Space for the icon */
  border-radius: 12px;
  border: 1px solid rgb(113, 126, 126);
  outline: none;
  box-sizing: border-box;
  overflow-y: auto; /* Add vertical scroll when content exceeds max height */
}

.flex-container {
  display: flex;
  position: relative;
  /* Other flex properties as needed */
}
.inputbai {
  flex: auto;
}

.custom-mx-xxl {
  margin-left: 22px; /* or any desired value */
  margin-right: 38px; /* or any desired value */
}

@media only screen and (max-width: 1904px) {
  .custom-mx-xxl {
    margin-left: 30px; /* or any desired value */
    margin-right: 40px; /* or any desired value */
  }
}

.profile-container {
  border-radius: 12px;
  display: flex;
  align-items: center;
  background: linear-gradient(to bottom, rgb(0, 0, 0) 50%, #ffffff 50%);
  padding: 20px;
}

.profile-avatar {
  flex: 0 0 150px;
  display: flex;
  justify-content: center;
  align-items: center;
  margin-right: 20px;
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
    background: linear-gradient(to bottom, rgb(0, 0, 0) 50%, #ffffff 50%);
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
