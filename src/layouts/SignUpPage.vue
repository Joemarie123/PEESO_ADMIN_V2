<template>
  <q-page>
    <!-- Main Content -->
    <div class="row page flex-center">
      <q-dialog v-model="showResendDialog">
        <q-card>
          <q-card-section>
            <div class="text-h6">Resend OTP</div>
          </q-card-section>

          <q-card-section>
            <p>Your OTP has expired. Would you like to resend a new OTP?</p>
          </q-card-section>

          <q-card-actions align="right">
            <q-btn flat label="No" color="primary" v-close-popup />
            <q-btn flat label="Yes" color="primary" @click="VerifyOtp" />
          </q-card-actions>
        </q-card>
      </q-dialog>

      <q-dialog v-model="showOtpForm" persistent style="margin-top: -50px">
        <q-card style="max-width: 390px; height: 475px; border-radius: 15px">
          <div style="margin-top: -35px">
            <q-card-section>
              <!--    {{ combinedOtp }} -->
            </q-card-section>
            <q-card-section>
              <div class="text-center">
                <q-avatar
                  square=""
                  size="90px"
                  class="hoverimage q-mx-lg q-my-md"
                >
                  <img :src="imageUrl_1" alt="Upload" />
                </q-avatar>
              </div>
              <div class="text-center">
                <p class="text-h5">Please check your email</p>
                <p class="text-muted" style="margin-top: -12px">
                  We've sent a code to
                  <span
                    ><b>{{ txtemail }}</b></span
                  >
                </p>
              </div>
              <!--   {{ txt_otp_verification }} -->
              <div class="q-mt-md text-center" style="margin-top: 25px">
                <input
                  ref="otp1"
                  class="otp-letter-input"
                  @update:model-value="handleInput('otp1', $event, 'otp2')"
                  @keydown="handleKeydown"
                  v-model="otp1"
                  maxlength="1"
                />
                <input
                  ref="otp2"
                  class="otp-letter-input"
                  @update:model-value="handleInput('otp2', $event, 'otp3')"
                  v-model="otp2"
                  maxlength="1"
                  @keydown.backspace="handleBackspace('otp2', 'otp1')"
                  @keydown="handleKeydown"
                />
                <input
                  ref="otp3"
                  class="otp-letter-input"
                  @update:model-value="handleInput('otp3', $event, 'otp4')"
                  v-model="otp3"
                  maxlength="1"
                  @keydown.backspace="handleBackspace('otp3', 'otp2')"
                  @keydown="handleKeydown"
                />
                <input
                  ref="otp4"
                  class="otp-letter-input"
                  v-model="otp4"
                  @update:model-value="handleInput('otp4', $event, 'otp5')"
                  maxlength="1"
                  @keydown.backspace="handleBackspace('otp4', 'otp3')"
                  @keydown="handleKeydown"
                />
                <input
                  ref="otp5"
                  @update:model-value="handleInput('otp5', $event, 'otp6')"
                  class="otp-letter-input"
                  v-model="otp5"
                  maxlength="1"
                  @keydown.backspace="handleBackspace('otp5', 'otp4')"
                  @keydown="handleKeydown"
                />
                <input
                  ref="otp6"
                  class="otp-letter-input"
                  v-model="otp6"
                  maxlength="1"
                  @keydown.backspace="handleBackspace('otp6', 'otp5')"
                  @keydown="handleKeydown"
                />
              </div>
              <div class="text-center q-mt-md">
                <p class="text-muted">
                  Didn't get the code?

                  <button class="resendcolor" @click="VerifyOtp()">
                    Click to resend.
                  </button>
                </p>
              </div>

              <q-card-actions class="q-mt-md q-px-lg justify-end">
                <q-btn
                  label="Verify"
                  class="custom_input_button"
                  @click="Click_Verify_OTP"
                />
              </q-card-actions>
              <div class="text-center" style="font-size: 20px">
                {{ formattedTime }}
              </div>
            </q-card-section>
          </div>
        </q-card>
        <q-card-section style="margin-top: -488px; margin-left: -10px"
          ><button class="button_close" @click="showOtpForm = false">
            <b>X</b>
          </button></q-card-section
        >
      </q-dialog>

      <div
        class="col-11 col-xl-5 col-lg-5 col-md-5 col-sm-5 div_wecanMakeitHappen"
      >
        <q-card class="shadow-24 Cardlogin">
          <q-card-section class="q-mx-md">
            <!--  <div>
              <img
                class="imagebackground"
                src="public/TagumLogo.png"
                alt="Tagum City"
                style="height: 14%; width: 14%"
              />
              <p class="CPEESO_ni">CPEESO SIGN UP</p>
            </div> -->
          </q-card-section>

          <q-card-section class="q-mt-md">
            <div class="row">
              <div class="col-9">
                <q-card-section style="margin-top: -90px">
                  <h4>
                    <b> Create Account </b>
                  </h4>
                </q-card-section>

                <q-card-section style="margin-top: -72px">
                  <p>Please Enter Information Details</p>
                </q-card-section>
              </div>

              <div class="col-3" style="margin-top: -50px">
                <q-avatar
                  size="70px"
                  class="q-ml-sm hoverimage"
                  @click="triggerFileUpload"
                >
                  <img :src="imageUrl" alt="Upload" />
                </q-avatar>
                <p style="margin-left: -10px"><b>Upload Company Profile</b></p>
                <input
                  type="file"
                  ref="fileInput"
                  style="display: none"
                  @change="handleFileUpload"
                  accept="image/*"
                />
              </div>
            </div>

            <q-form class="q-px-md">
              <div class="row">
                <div class="col-12 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                  <div class="custom-input-container">
                    <input
                      v-model="txtCompanyName"
                      @input="sanitizeInput"
                      class="custom-input"
                      placeholder="Company Name"
                      ref="companyNameInput"
                    />
                    <q-icon name="add_business" class="input-icon" />
                    <div
                      data-aos="fade-in"
                      data-aos-duration="1500"
                      v-if="errors.txtCompanyName"
                      class="tooltip"
                    >
                      {{ errors.txtCompanyName }}
                    </div>
                  </div>
                </div>

                <div
                  class="col-12 col-xl-5 col-lg-5 col-md-5 col-sm-12 downmargin"
                >
                  <div class="custom-input-container container_again">
                    <input
                      v-model="txtaddress"
                      placeholder="Company Address"
                      class="custom-input"
                    />
                    <q-icon name="location_on" class="input-icon" />
                    <div
                      data-aos="fade-in"
                      data-aos-duration="1500"
                      v-if="errors.txtaddress"
                      class="tooltip_address"
                    >
                      {{ errors.txtaddress }}
                    </div>
                  </div>
                </div>
              </div>

              <div class="row" style="margin-top: 30px">
                <div class="col-12 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                  <div class="custom-input-container">
                    <input
                      v-model="txtfirstname"
                      placeholder="First Name"
                      class="custom-input"
                    />
                    <q-icon name="people" class="input-icon" />
                    <div
                      data-aos="fade-in"
                      data-aos-duration="1500"
                      v-if="errors.txtfirstname"
                      class="tooltip"
                    >
                      {{ errors.txtfirstname }}
                    </div>
                  </div>
                </div>

                <div
                  class="col-12 col-xl-5 col-lg-5 col-md-5 col-sm-12 downmargin"
                >
                  <div class="custom-input-container container_again">
                    <input
                      v-model="txtlastname"
                      placeholder="Last Name"
                      class="custom-input"
                    />
                    <q-icon name="people" class="input-icon" />
                    <div
                      data-aos="fade-in"
                      data-aos-duration="1500"
                      v-if="errors.txtlastname"
                      class="tooltip_lastname"
                    >
                      {{ errors.txtlastname }}
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-12 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                  <div class="custom-input-container marginforfield">
                    <input
                      v-model="txtmiddlename"
                      class="custom-input"
                      placeholder="Middle Name"
                    />
                    <q-icon name="people" class="input-icon" />
                    <div
                      data-aos="fade-in"
                      data-aos-duration="1500"
                      v-if="errors.txtmiddlename"
                      class="tooltip"
                    >
                      {{ errors.txtmiddlename }}
                    </div>
                  </div>
                </div>

                <div class="col-12 col-xl-5 col-lg-5 col-md-5 col-sm-12">
                  <div
                    class="custom-input-container container_again_1 marginforfield"
                  >
                    <q-icon name="people" class="input-icon" />
                    <select v-model="txtfuffix" class="custom-input">
                      <option disabled value="">
                        <span class="siffixcss">Siffix</span>
                      </option>
                      <!-- Add your options here -->
                      <option value="N/A">N/A</option>
                      <option value="Jr">Jr.</option>
                      <option value="Sr.">Sr.</option>
                      <option value="III">III</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-12 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                  <div class="custom-input-container marginforfield">
                    <input
                      v-model="txtcontact"
                      class="custom-input"
                      placeholder="Contact Number"
                      maxlength="11"
                      @input="validateContact"
                    />
                    <q-icon name="phone" class="input-icon" />
                    <div
                      data-aos="fade-in"
                      data-aos-duration="1500"
                      v-if="errors.txtcontact"
                      class="tooltip"
                    >
                      {{ errors.txtcontact }}
                    </div>
                  </div>
                </div>

                <div class="col-5">
                  <div class="custom-input-container marginforfield">
                    <input
                      @blur="validateEmail"
                      ref="emailInput"
                      v-model="txtemail"
                      class="custom-input"
                      placeholder="Email"
                    />
                    <q-icon name="email" class="input-icon" />
                    <div
                      data-aos="fade-in"
                      data-aos-duration="1500"
                      v-if="errors.txtemail"
                      class="tooltip_email"
                    >
                      {{ errors.txtemail }}
                    </div>

                    <div
                      data-aos="fade-in"
                      data-aos-duration="1500"
                      v-if="errors.txtemail_1"
                      class="tooltip_email_1"
                    >
                      {{ errors.txtemail_1 }}
                    </div>
                  </div>
                </div>
              </div>
              <div class="row" style="margin-left: -10px">
                <q-card-section>
                  <p>Please Enter Login Details</p>
                </q-card-section>
              </div>

              <div class="row">
                <div class="col-5">
                  <div
                    class="custom-input-container-username"
                    style="margin-top: -20px"
                  >
                    <input
                      v-model="txtlogin"
                      class="custom-input"
                      placeholder="User Name"
                      @focus="checkEmailBeforeFocus"
                      ref="nameInput"
                    />
                    <q-icon name="people" class="input-icon" />
                    <div
                      data-aos="fade-in"
                      data-aos-duration="1500"
                      v-if="errors.txtlogin"
                      class="tooltip_UserName"
                    >
                      {{ errors.txtlogin }}
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-12 col-xl-6 col-lg-6 col-md-6 col-sm-6">
                  <div class="custom-input-container marginforfield">
                    <q-icon name="lock" class="input-icon" />
                    <input
                      type="password"
                      v-model="txtpassword"
                      class="custom-input"
                      placeholder="Password"
                      @focus="checkEmailBeforeFocus"
                    />
                    <div
                      data-aos="fade-in"
                      data-aos-duration="1500"
                      v-if="errors.txtpassword_1"
                      class="tooltip"
                    >
                      {{ errors.txtpassword_1 }}
                    </div>
                    <div v-if="passwordError" class="error-message">
                      {{ passwordError }}
                    </div>
                  </div>
                </div>

                <div class="col-12 col-xl-5 col-lg-5 col-md-5 col-sm-12">
                  <div class="custom-input-container marginforfield">
                    <q-icon name="lock" class="input-icon" />
                    <input
                      type="password"
                      v-model="txtconfirmpassword"
                      @focus="checkEmailBeforeFocus"
                      class="custom-input"
                      placeholder="Confirm Password"
                      :disabled="isConfirmPasswordDisabled"
                    />
                    <div
                      data-aos="fade-in"
                      data-aos-duration="1500"
                      v-if="errors.txtconfirmpassword_1"
                      class="tooltip_confirmPassword"
                    >
                      {{ errors.txtconfirmpassword_1 }}
                    </div>

                    <div v-if="confirmPasswordError" class="error-message">
                      <q-icon name="error" class="error-icon" />
                      {{ confirmPasswordError }}
                    </div>
                  </div>
                </div>
              </div>
            </q-form>

            <div class="q-px-lg q-mt-lg marginleft">
              <button class="custom_input_button" @click="validateForm()">
                SIGN UP
              </button>
            </div>
          </q-card-section>
        </q-card>
      </div>
    </div>
  </q-page>
</template>

<script>
import AOS from "aos";
import "aos/dist/aos.css";
import { defineComponent, TrackOpTypes } from "vue";
import { useQuasar } from "quasar";
import { Loading } from "quasar";
import { useLoginCheck } from "src/stores/SignUp_Store";

export default defineComponent({
  data() {
    return {
      otp1: "",
      otp2: "",
      otp3: "",
      otp4: "",
      otp5: "",
      otp6: "",

      imageUrl: "/upload.jpg",
      imageUrl_1: "/message.jpg",
      txtCompanyName: "",

      txtlastname: "",
      txtfirstname: "",
      txtmiddlename: "",

      errors: {
        txtCompanyName: "",
        txtaddress: "",
        txtfirstname: "",
        txtlastname: "",
        txtmiddlename: "",
        txtcontact: "",
        txtemail: "",
        txtemail_1: "",
        txtlogin: "",
        txtpassword_1: "",
        txtconfirmpassword_1: "",
        /*  txtpassword: "",
        txtconfirmpassword: "", */
      },

      txtfuffix: "",
      txtemail: "",
      txtlogin: "",
      txtcontact: "",
      txtaddress: "",

      txtpassword: "",
      txtconfirmpassword: "",
      passwordError: "",
      confirmPasswordError: "",

      /*   txt_otp_verification: "", */
      showOtpForm: false,

      startNumber: 0,
      dialog_sched: false,
      duration: 1500, // duration of the animation in milliseconds
      startTime: null,
      displayNumber_TotalJobs: 0,
      displayNumber_Vacancies: 0,
      totalJobs: 453, // Replace with actual data
      totalVacancies: 1500, // Replace with actual data

      check_me: [],
      file: null,
      IpaVerifyOTp: [],
      /*  Company_Image: null, */
      timer: null,
      timeLeft: 120, // 2 minutes in seconds
      timeExceeded: false,
      showResendDialog: false,
      SavemeDatatoDatabase: [],
      expectedOtpLength: 6, // Set the expected OTP length
    };
  },

  setup() {
    const $q = useQuasar();

    return {
      OTPExpired() {
        $q.notify({
          icon: "sms",
          color: "red",
          message: "OTP Expired Please Resend",
          position: "center",
          timeout: "1500",
        });
      },

      showDuplicateEmail() {
        $q.notify({
          icon: "star_half",
          color: "red",
          message: "Duplicate Email",
          position: "center",
          timeout: "1500",
        });
      },

      DuplicateLogin() {
        $q.notify({
          icon: "star_half",
          color: "red",
          message: "Duplicate Login",
          position: "center",
          timeout: "1500",
        });
      },

      DuplicateEmail() {
        $q.notify({
          icon: "star_half",
          color: "red",
          message: "Duplicate Email",
          position: "center",
          timeout: "1500",
        });
      },

      Invalid_Email() {
        $q.notify({
          icon: "email",
          color: "red",
          message: "Invalid Email",
          position: "center",
          timeout: "1500",
        });
      },

      Duplicate_Email_LOGIN() {
        $q.notify({
          icon: "star_half",
          color: "red",
          message: "Duplicate Email And UserName",
          position: "center",
          timeout: "1500",
        });
      },
    };
  },

  computed: {
    isConfirmPasswordDisabled() {
      return (
        this.passwordError === "Password must be at least 8 characters long"
      );
    },

    txt_otp_verification: {
      get() {
        return (
          this.otp1 + this.otp2 + this.otp3 + this.otp4 + this.otp5 + this.otp6
        );
      },
      set(value) {
        this.otp1 = value[0] || "";
        this.otp2 = value[1] || "";
        this.otp3 = value[2] || "";
        this.otp4 = value[3] || "";
        this.otp5 = value[4] || "";
        this.otp6 = value[5] || "";
      },
    },

    formattedTime() {
      const minutes = Math.floor(this.timeLeft / 60);
      const seconds = this.timeLeft % 60;
      return `${minutes}:${seconds < 10 ? "0" : ""}${seconds}`;
    },
  },

  watch: {
    /*    txt_otp_verification(newVal) {
      this.verifyOTP();
    },
 */

    txt_otp_verification(newVal) {
      if (newVal.length == this.expectedOtpLength) {
        this.verifyOtp_Kini();
      }
    },

    txtpassword(newVal) {
      this.validatePassword(newVal);
      if (newVal) {
        this.errors.txtpassword_1 = "";
      }
    },

    txtconfirmpassword(newVal) {
      this.validateConfirmPassword(newVal);

      if (newVal) {
        this.errors.txtconfirmpassword_1 = "";
      }
    },

    txtCompanyName(newVal) {
      if (newVal) {
        this.errors.txtCompanyName = "";
      }
    },

    txtaddress(newVal) {
      if (newVal) {
        this.errors.txtaddress = "";
      }
    },

    txtfirstname(newVal) {
      if (newVal) {
        this.errors.txtfirstname = "";
      }
    },
    txtlastname(newVal) {
      if (newVal) {
        this.errors.txtlastname = "";
      }
    },

    txtmiddlename(newVal) {
      if (newVal) {
        this.errors.txtmiddlename = "";
      }
    },

    txtcontact(newVal) {
      if (newVal) {
        this.errors.txtcontact = "";
      }
    },

    txtemail(value) {
      if (value) {
        this.errors.txtemail = "";
      }
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (emailRegex.test(value)) {
        this.errors.txtemail_1 = "";
      }
    },

    txtlogin(newVal) {
      if (newVal) {
        this.errors.txtlogin = "";
      }
    },
  },

  created() {
    /* this.verifyOTP(); */
  },

  methods: {
   
    handleKeydown(event) {
      const key = event.key;
      if (
        !/^[0-9]$/.test(key) &&
        key !== "Backspace" &&
        key !== "ArrowLeft" &&
        key !== "ArrowRight"
      ) {
        event.preventDefault();
      }
    },

    sanitizeInput() {
      // Define the prohibited characters
      const prohibitedChars = /[\/\\:*?"<>|]/g;
      // Remove prohibited characters
      this.txtCompanyName = this.txtCompanyName.replace(prohibitedChars, "");
    },

    validateEmail() {
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (this.txtemail && !emailRegex.test(this.txtemail)) {
        this.errors.txtemail_1 = "Please enter a valid email address.";
        this.$refs.emailInput.focus();
      } else {
        this.errors.txtemail_1 = "";
      }
    },
    /*  checkEmailBeforeFocus(event) {
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (this.txtemail && !emailRegex.test(this.txtemail)) {
        this.errors.txtemail_1 = "Please enter a valid email address.";
        event.preventDefault();
        this.$refs.emailInput.focus();
      }
    }, */

    validateContact(event) {
      // Remove non-digit characters
      let cleaned = event.target.value.replace(/\D/g, "");
      // Limit to 11 characters
      if (cleaned.length > 11) {
        cleaned = cleaned.substring(0, 11);
      }
      // Set the cleaned value back to the model
      this.txtcontact = cleaned;
    },

    validatePassword(password) {
      if (password === "") {
        this.passwordError = "";
      } else if (password.length < 8) {
        this.passwordError = "Password must be at least 8 characters long";
        /*  this.$nextTick(() => {
          this.$refs.passwordInput.focus();
        }); */
      } else {
        this.passwordError = "";
      }

      // Validate confirm password again in case both fields have been filled
      if (this.txtconfirmpassword !== "") {
        this.validateConfirmPassword(this.txtconfirmpassword);
      }
    },

    validateConfirmPassword(confirmPassword) {
      if (confirmPassword == "") {
        this.confirmPasswordError = "";
      } else if (confirmPassword !== this.txtpassword) {
        this.confirmPasswordError = "Passwords do not match";
      } else {
        this.confirmPasswordError = "";
      }
    },

    handleInput(currentRef, value, nextRef) {
      /*   console.log("df"); */
      // Focus on the next input if the current one has a value
      if (value.length == 1) {
        this.$nextTick(() => {
          const nextInput = this.$refs[nextRef];
          if (nextInput) {
            nextInput.focus();
          }
        });
      }
    },

    handleBackspace(currentRef, previousRef) {
      this.$nextTick(() => {
        if (this[currentRef].length === 0) {
          const previousInput = this.$refs[previousRef];
          if (previousInput) {
            previousInput.focus();
          }
        }
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
        };
        reader.readAsDataURL(file); // read the file as a data URL
      }
    },

    handleClick() {
      // Handle button click
      console.log("Button clicked");
    },

    startOtpProcess() {
      this.showOtpForm = true;
      this.timeLeft = 120; // Reset timer
      this.timeExceeded = false;
      this.startTimer();
    },

    startTimer() {
      if (this.timer) clearInterval(this.timer);
      this.timer = setInterval(() => {
        if (this.timeLeft > 0) {
          this.timeLeft--;
        } else {
          this.timeExceeded = true;
          clearInterval(this.timer);
        }
      }, 1000);
    },

    async SignUp_Save_To_Database() {
      this.showOtpForm = false;

      const store = useLoginCheck();
      let data = new FormData();
      data.append("Company_name", this.txtCompanyName);
      data.append("Company_address", this.txtaddress);
      data.append("LastName", this.txtlastname);
      data.append("FirstName", this.txtfirstname);
      data.append("MiddleName", this.txtmiddlename);
      data.append("Suffix", this.txtfuffix);
      data.append("Email", this.txtemail);
      data.append("Login", this.txtlogin);
      data.append("Password", this.txtpassword);
      data.append("ContactNo", this.txtcontact);

      if (this.file) {
        data.append("file", this.file);
      }

      try {
        await store.SaveToDatabase(data).then((res) => {
          this.SavemeDatatoDatabase = store.SaveData;

          console.log("Save to Database", this.SavemeDatatoDatabase);
        });
      } catch (error) {
        console.error("Error Save to Database", error);
      } finally {
        localStorage.setItem("Login", this.SavemeDatatoDatabase.LoginID);
        this.showLoading();
        setTimeout(() => {
          this.$router.push("/DashBoard");
          this.hideLoading();
        }, 3000); // 3-second delay
      }
    },

    /*    Click_Verify_OTP() {


      if (this.timeExceeded) {

        this.OTPExpired();
      } else {
        if (this.txt_otp_verification == this.IpaVerifyOTp.otp) {
          this.SignUp_Save_To_Database();
          console.log("Correct");

        } else {
          console.log("Wrong");
          this.$q.notify({
            color: "negative",
            position: "center",
            message: "Invalid OTP. Please try again.",
            timeout: "2000",
          });

        }
      }
    }, */

    /*  START  */

    verifyOtp_Kini() {
      // Compare entered OTP with predefined OTP
      if (this.timeExceeded) {
        this.OTPExpired();
      } else {
        if (this.txt_otp_verification === this.IpaVerifyOTp.otp) {
          this.SignUp_Save_To_Database();
          console.log("Correct");
          /*  this.$q.notify({
            color: "positive",
            position: "top",
            message: "OTP Verified Successfully!",
          }); */
        } else {
          console.log("Wrong");
          this.$q.notify({
            color: "negative",
            position: "center",
            message: "Invalid OTP. Please try again.",
            timeout: 1500,
          });
        }
      }
    },
    Click_Verify_OTP() {
      this.verifyOtp_Kini();
    },

    /*  END  */

    showLoading() {
      this.$q.loading.show();
    },
    hideLoading() {
      this.$q.loading.hide();
    },

    async VerifyOtp() {
      this.showLoading();

      const store = useLoginCheck();
      let data = new FormData();

      data.append("Email", this.txtemail);
      try {
        await store.VerifyOtp(data).then((res) => {
          this.IpaVerifyOTp = store.OtpVerify;
          console.log("Kini Verify OTP:", this.IpaVerifyOTp.otp);

          if (this.IpaVerifyOTp.sent == true) {
            this.showOtpForm = true;
            this.startOtpProcess();
            this.showResendDialog = false;
            this.txt_otp_verification = "";

            // Set focus to the otp1 input field
            this.$nextTick(() => {
              this.$refs.otp1.focus();
            });
          } else {
            this.Invalid_Email();
          }
        });
      } catch (error) {
        console.error("Error verifying OTP:", error);
        this.Invalid_Email();
      } finally {
        this.hideLoading();
      }
    },

    onBeforeUnmount() {
      this.hideLoading();
    },

    validateForm() {
      // Validate password and confirm password before proceeding
      this.validatePassword(this.txtpassword);
      this.validateConfirmPassword(this.txtconfirmpassword);

      if (this.passwordError || this.confirmPasswordError) {
        // If there are any errors, do not proceed
        return;
      }

      this.clearErrors();
      let valid = true;

      if (!this.txtCompanyName) {
        this.errors.txtCompanyName = "Please fill up Company Name";
        valid = false;
      }

      if (!this.txtaddress) {
        this.errors.txtaddress = "Please fill up Address";
        valid = false;
      }

      if (!this.txtfirstname) {
        this.errors.txtfirstname = "Please fill up First Name";
        valid = false;
      }

      if (!this.txtlastname) {
        this.errors.txtlastname = "Please fill up Last Name";
        valid = false;
      }
      if (!this.txtmiddlename) {
        this.errors.txtmiddlename = "Please fill up Middle Name";
        valid = false;
      }

      if (!this.txtcontact) {
        this.errors.txtcontact = "Please fill up Contact Number";
        valid = false;
      }
      if (!this.txtemail) {
        this.errors.txtemail = "Please fill up Email";
        valid = false;
      }

      if (!this.txtlogin) {
        this.errors.txtlogin = "Please fill up User Name";
        valid = false;
      }

      if (!this.txtpassword) {
        this.errors.txtpassword_1 = "Please fill up Password";
        valid = false;
      }

      if (!this.txtconfirmpassword) {
        this.errors.txtconfirmpassword_1 = "fill up Confirm Password";
        valid = false;
      }

      if (valid) {
        /*  this.Loading(); */
        this.CheckmeLogin();
      }
    },

    clearErrors() {
      this.errors.txtCompanyName = "";
      this.errors.txtaddress = "";
      this.errors.txtfirstname = "";
      this.errors.txtlastname = "";
      this.errors.txtmiddlename = "";

      this.errors.txtcontact = "";
      this.errors.txtemail = "";
      this.errors.txtlogin = "";
      this.errors.txtpassword = "";
      this.errors.txtconfirmpassword = "";
    },

    async CheckmeLogin() {
      const store = useLoginCheck();
      let data = new FormData();
      data.append("Company_name", this.txtCompanyName);
      data.append("LastName", this.txtlastname);
      data.append("FirstName", this.txtfirstname);
      data.append("MiddleName", this.txtmiddlename);
      data.append("Suffix", this.txtfuffix);
      data.append("Email", this.txtemail);
      data.append("Login", this.txtlogin);

      store.LoginChecking(data).then((res) => {
        console.log("Response from LoginChecking:", res);

        if (res == 1) {
          this.DuplicateLogin();
        } else if (res == 2) {
          this.DuplicateEmail();
        } else if (res == 3) {
          this.Duplicate_Email_LOGIN();
        } else if (res == 4) {
          this.VerifyOtp();
        }
      });
    },

    animateNumber(timestamp) {
      if (!this.startTime) this.startTime = timestamp;
      const progress = timestamp - this.startTime;
      const progressFraction = progress / this.duration;
      this.displayNumber_Vacancies = Math.min(
        Math.floor(
          this.startNumber +
            progressFraction * (this.totalVacancies - this.startNumber)
        ),
        this.totalVacancies
      );
      if (progress < this.duration) {
        requestAnimationFrame(this.animateNumber);
      } else {
        this.displayNumber_Vacancies = this.totalVacancies;
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

  components: {},

  mounted() {
    this.$refs.companyNameInput.focus();
    AOS.init();
    this.startAnimation_TotalJobs();
    this.startAnimation();
  },
});
</script>

<style scoped>
.tooltip_UserName {
  position: absolute;
  left: 25%;
  /*   transform: translateX(-50%); */
  bottom: 7px;
  background-color: rgba(244, 238, 238, 0);
  color: red;

  padding: 5px 10px;
  border-radius: 4px;
  font-size: 12px;
  white-space: nowrap;
  z-index: 10;
}

.tooltip_confirmPassword {
  position: absolute;
  left: 50%;
  /*   transform: translateX(-50%); */
  bottom: 7px;
  background-color: rgba(244, 238, 238, 0);
  color: red;

  padding: 5px 10px;
  border-radius: 4px;
  font-size: 12px;
  white-space: nowrap;
  z-index: 10;
}

.tooltip {
  position: absolute;
  left: 43%;
  /*   transform: translateX(-50%); */
  bottom: 7px;
  background-color: rgba(244, 238, 238, 0);
  color: red;

  padding: 5px 10px;
  border-radius: 4px;
  font-size: 12px;
  white-space: nowrap;
  z-index: 10;
}

.tooltip_email_1 {
  position: absolute;
  left: -0%;
  /*   transform: translateX(-50%); */
  bottom: -27px;
  background-color: rgba(244, 238, 238, 0);
  color: red;

  padding: 5px 10px;
  border-radius: 4px;
  font-size: 12px;
  white-space: nowrap;
  z-index: 10;
}

.tooltip_email {
  position: absolute;
  left: 59%;
  /*   transform: translateX(-50%); */
  bottom: 8px;
  background-color: rgba(244, 238, 238, 0);
  color: red;

  padding: 5px 10px;
  border-radius: 4px;
  font-size: 12px;
  white-space: nowrap;
  z-index: 10;
}

.tooltip_lastname {
  position: absolute;
  left: 50%;
  /*   transform: translateX(-50%); */
  bottom: 7px;
  background-color: rgba(244, 238, 238, 0);
  color: red;

  padding: 5px 10px;
  border-radius: 4px;
  font-size: 12px;
  white-space: nowrap;
  z-index: 10;
}

.tooltip_address {
  position: absolute;
  left: 54%;
  /*   transform: translateX(-50%); */
  bottom: 7px;
  background-color: rgba(244, 238, 238, 0);
  color: red;

  padding: 5px 10px;
  border-radius: 4px;
  font-size: 12px;
  white-space: nowrap;
  z-index: 10;
}

/* .tooltip::before {
  content: "";
  position: absolute;
  top: -5px;
  left: 50%;
  transform: translateX(-50%);
  border-width: 5px;
  border-style: solid;
  border-color: transparent transparent #f00 transparent;
} */

.error-icon {
  margin-right: 0.1rem;
}

.error-message {
  color: red;
  font-size: 0.8rem;
  margin-top: 0.5rem;
}

.resendcolor {
  color: rgb(8, 77, 180);
  border-color: #ffffff00;
  font-size: 16px;
  background-color: #ffffff00; /* Background color of the button */
  cursor: pointer;
}

.resendcolor:active {
  color: rgb(8, 77, 180);
  border-color: #ffffff00;
  font-size: 15px;
  background-color: #ffffff00; /* Background color of the button */
  cursor: pointer;
}

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

.button_close:hover {
  background-color: #0c0c0ce3; /* Darker color on hover */
}

.iconcolor {
  background: linear-gradient(40deg, #279f27, #5fc331);
}

.otp-letter-input {
  max-width: 11%;
  height: 90px;
  margin-left: 10px;
  border: 1px solid #198754;

  border-radius: 10px;
  color: #198754;
  font-size: 40px;
  text-align: center;
  font-weight: bold;
}

.hoverimage:hover {
  cursor: pointer;
}

.hoverimage {
  margin-left: 18px;
}

.avatar-border {
  border: 2px solid #242020; /* Change the color and width as needed */
}

.custom-input-container {
  position: relative;
  width: 320px;
  margin-top: -20px;
}

.custom-input-container-username {
  position: relative;
  width: 650px;
  margin-top: -20px;
}

.imagebackground {
}

.custom_input_button {
  width: 101%;
  height: 40px;
  padding-left: 20px; /* Space for the icon */
  border-radius: 12px;
  border: 1px solid rgb(253, 253, 253);
  background: linear-gradient(40deg, #279f27, #5fc331);
  color: white;

  cursor: pointer; /* Changes the cursor to a hand pointer */
}

.custom_input_button:active {
  background: linear-gradient(
    40deg,
    #343a31,
    /* Darker green for the background when clicked */ #2a3529
      /* Darker shade for the gradient */
  );
  border-color: #064d2c; /* Darker border color when clicked */
}

.marginleft {
  margin-left: -10px;
  margin-right: 7px;
}

.custom-input {
  width: 100%;
  height: 40px;
  padding-left: 40px; /* Space for the icon */
  border-radius: 12px;
  border: 1px solid rgb(113, 126, 126);
  outline: none;
  box-sizing: border-box;
}

.input-icon {
  position: absolute;
  top: 50%;
  left: 10px;
  transform: translateY(-50%);
  font-size: 20px;
  color: gray;
}

.displayNumber {
  font-weight: 500;
}

.imagebackground {
  height: 300px;
  margin-right: 8px;
  border-radius: 12px;
}

.CPEESO_ni {
  margin-bottom: 22px;
  font-size: 20px;
  font-weight: bold;
  color: #585a58;
}

.CPEESO {
  margin-top: 15px;
  font-weight: bold;
  color: #3fb03f;
}

.CPEECO_CONTENT {
  margin-top: 40px;
}

.div_wecanMakeitHappen {
  margin-left: 15px;
  margin-top: 19px;
}

@media only screen and (max-width: 1564px) {
  .div_wecanMakeitHappen {
    margin-left: 10px;
    margin-top: 19px;
  }
}

/* @media only screen and (max-width: 1919px) {
  .div_wecanMakeitHappen {
    margin-left: -19px;
    margin-top: 19px;
  }
} */
.displayNumber_Margin_OverlAllVacancies {
  margin-top: 90px;
}

@media only screen and (max-width: 1432px) {
  .displayNumber_Margin_OverlAllVacancies {
    margin-top: 60px;
  }

  .displayNumber {
    font-weight: 500;
    font-size: 24px;
  }

  .imagebackground {
    height: 250px;
    margin-right: 8px;
    border-radius: 12px;
  }

  .CPEESO {
    margin-top: 10px;
    font-weight: bold;
    color: #3fb03f;
  }

  .CPEECO_CONTENT {
    margin-top: 17px;
  }

  .div_wecanMakeitHappen {
    margin-left: -19px;
    margin-top: 19px;
  }
}

@media only screen and (max-width: 1353px) {
  .div_wecanMakeitHappen {
    margin-left: 20px;

    margin-top: 19px;
  }
}

@media only screen and (max-width: 1223px) {
  .div_wecanMakeitHappen {
    margin-left: 40px;
    margin-top: 19px;
  }

  .displayNumber {
    font-weight: 500;
    font-size: 20px;
  }

  .captionTotalOverAll {
    font-size: 10px;
    margin-top: -48px;
    font-family: sans-serif;
  }
}

@media only screen and (max-width: 1178px) {
  .div_wecanMakeitHappen {
    margin-left: 45px;
    margin-top: 19px;
  }

  .display_Content {
    margin-left: -20px;
  }
}

@media only screen and (max-width: 1144px) {
  .div_wecanMakeitHappen {
    margin-left: 55px;
  }
}

@media only screen and (max-width: 1120px) {
  .div_wecanMakeitHappen {
    margin-left: -400px;
    margin-top: 30px;
  }
}
@media only screen and (max-width: 964px) {
  .div_wecanMakeitHappen {
    margin-right: 500px;
    margin-top: 30px;
  }
}

.captionTotalOverAll {
  font-size: 20px;
  margin-top: -48px;
  font-family: sans-serif;
}

.flex-center1 {
  margin-top: -640px;
  display: flex;
  justify-content: center;
  align-items: flex-start; /* Align items to the top */
  height: 100vh; /* Full height to ensure vertical centering */
}

.flex-center {
  display: flex;
  justify-content: center;
  align-items: flex-start; /* Align items to the top */
  height: 100vh; /* Full height to ensure vertical centering */
}

.page {
  /*  margin-right: 100px;
  margin-left: 90px; */
  margin-top: 80px;
}

@media only screen and (max-width: 1119px) {
  .page {
    margin-right: 40px;
    margin-left: 90px;
    margin-top: 80px;
  }
}

@media only screen and (max-width: 1059px) {
  .page {
    margin-right: 20px;
    margin-left: 20px;
    margin-top: 80px;
  }
}

@media only screen and (max-width: 1023px) {
  .page {
    margin-right: 20px;
    margin-left: 15px;
    margin-top: 80px;
  }

  .CPEECO_CONTENT {
    margin-top: -12px;
  }

  .downmargin {
    margin-top: 30px;
  }

  .custom-input-container-username {
    position: relative;
    width: 320px;
    margin-top: -20px;
  }

  .Cardlogin {
    margin-top: -60px;
    width: 900px;
  }
}

@media only screen and (max-width: 964px) {
  .page {
    margin-right: 20px;
    margin-left: -40px;
    margin-top: 80px;
  }

  .display_Content {
    display: none;
  }

  .div_wecanMakeitHappen {
    margin-left: 120px;
  }
}

.Cardlogin {
  width: 720px;
  height: auto;
  border-radius: 13px;
}

@media only screen and (max-width: 700px) {
  .Cardlogin {
    width: 400px;
    height: auto;
    border-radius: 13px;
    margin-left: -210px;
    margin-top: -50px;
  }

  .downmargin {
    margin-top: 30px;
  }

  .custom-input-container-username {
    position: relative;
    width: 320px;
    margin-top: -20px;
  }

  .div_wecanMakeitHappen {
    margin-left: 150px;
    margin-right: -45px;
  }

  .CPEECO_CONTENT {
    margin-top: -17px;
  }
}
.tagumcity {
  margin-top: -35px;
  color: #48b544;
  font-size: 50px;
  margin-left: 20px;
}

@media only screen and (max-width: 599px) {
  .Cardlogin {
    width: 400px;
    height: auto;
    border-radius: 13px;
    margin-left: 5px;
    margin-top: 350px;
  }
  .imagebackground {
    height: 200px;
    margin-top: -10px;
    margin-left: 15px;
    margin-right: 8px;
    border-radius: 12px;
  }

  .div_wecanMakeitHappen {
    margin-left: 55px;
    margin-top: -370px;
  }

  .custom-input-container-username {
    position: relative;
    width: 320px;
    margin-top: -20px;
  }

  .downmargin {
    margin-top: 30px;
  }

  .custom_input_button {
    width: 50%;
    height: 40px;
    padding-left: 20px; /* Space for the icon */
    border-radius: 12px;
    border: 1px solid rgb(253, 253, 253);
    background: linear-gradient(
      40deg,
      #279f27,
      #5fc331
    ); /* Gradient from green to white */
    color: white;

    cursor: pointer; /* Changes the cursor to a hand pointer */
  }
}

/* @media only screen and (max-width: 700px) {
  .Cardlogin {
    height: auto;
    border-radius: 13px;
    margin-left: -250px;
    margin-top: -15px;
  }
} */

@media only screen and (max-width: 375px) {
  .Cardlogin {
    width: 350px;
    height: auto;
    border-radius: 13px;
    margin-top: -20px;
    margin-left: 3px;
  }

  .imagebackground {
    height: 200px;
    margin-top: -30px;
    margin-left: 15px;
    margin-right: 8px;
    border-radius: 12px;
  }

  .div_wecanMakeitHappen {
    margin-left: 28px;
    /*  margin-right: 10px; */
    margin-top: -10px;
  }

  .custom-input-container {
    position: relative;
    width: 300px;
    margin-top: -20px;
  }

  .downmargin {
    margin-top: 30px;
  }

  .custom-input-container-username {
    position: relative;
    width: 300px;
    margin-top: -20px;
  }

  .custom_input_button {
    width: 110%;
    height: 40px;
    padding-left: 20px; /* Space for the icon */
    border-radius: 12px;
    border: 1px solid rgb(253, 253, 253);
    background: linear-gradient(
      40deg,
      #279f27,
      #5fc331
    ); /* Gradient from green to white */
    color: white;

    cursor: pointer; /* Changes the cursor to a hand pointer */
  }

  .imagebackground {
    margin-top: 20px;
    height: 200px;
    margin-right: 8px;
    border-radius: 12px;
  }
}

.marginforfield {
  margin-top: 15px;
}

.page2 {
  margin-right: 100px;
  margin-left: 120px;
  margin-top: 50px;
}

.page p {
  text-align: justify;
}
</style>
