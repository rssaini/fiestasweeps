<template>
  <div>
    <div v-if="showError" class="mainErrorBlock">
        <p>Developer Tools Detected. Please close developer tools to continue</p>
    </div>
    <div v-else>
        <div v-if="geolocation">
            <div v-if="locationDisabled">
                <h2>{{ locationMessage }}</h2>
                <p>
                    <button class="cta-button" @click="allowLocation">Click Here</button> to allow location permissions.
                </p>
            </div>
            <div v-else>
                <div v-if="balancePage"></div>
                <div v-if="IdentityPage">
                    <h2 v-if="profileStatus === 1">Your profile is Verified.</h2>
                    <div v-if="profileStatus === 0">
                        <h2 >Your Profile already submitted for verification.</h2>
                        <p>Profile Compliance:</p>
                        <ul>
                            <li style="color: #3ed1ed" v-for="(item, index) in profile.reasons.split(',')" :key="index">{{ item }}</li>
                        </ul>
                    </div>
                    <div v-if="profileStatus === null">
                        <div v-if="!verificationBegin">
                            <h2>Begin Verification</h2>
                            <p>Your identity is currently <strong>not</strong> verified.</p>
                            <p>Identity Verification is only for <strong>US</strong> users.</p>
                            <p>Please <button class="cta-button" @click="this.verificationBegin = true">click here</button> to begin the identity verification process.</p>
                        </div>
                        <div v-else>
                            <h2>Please review your personal details before identity verification.</h2>
                            <div class="form-group">
                                <label>Email Address</label>
                                <input type="email" readonly required v-model="this.profile.email">
                                <span v-if="!profile.email" style="color: #ff8787">Required Field</span>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input type="text" name="name" required v-model="this.profile.fname">
                                    <span v-if="!profile.fname" style="color: #ff8787">Required Field</span>
                                </div>
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" name="lname" required v-model="this.profile.lname">
                                    <span v-if="!profile.lname" style="color: #ff8787">Required Field</span>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input type="tel" name="phone" required v-model="this.profile.phone">
                                    <span v-if="!profile.phone" style="color: #ff8787">Required Field</span>
                                </div>
                                <div class="form-group">
                                    <label>Date of Birth</label>
                                    <input type="date" name="dob" required v-model="this.profile.dob">
                                    <span v-if="!profile.dob" style="color: #ff8787">Required Field</span>
                                </div>
                            </div>
                            <button :disabled="verificationProcess" @click="startVerification" class="cta-button">Update & Verify
                                <span v-if="verificationProcess" class="fa fa-spin fa-spinner"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-else>
            <div v-if="!isLoggedIn">
                <h2>Geo Location Services are Unavailable in this device.</h2>
                <p>Please Scan this QR Code to login or use your credentials from your mobile device.</p>
                <div v-if="qrCode != ''">
                    <img :src="qrCode" alt="QR Code">
                </div>
                <p>{{ qrCodeMessage }}</p>
                <button class="cta-button" @click="generateQR">Generate New QR Code</button>
            </div>
            <div v-else>
                <p>{{ qrCodeMessage }}</p>
            </div>
        </div>
    </div>
  </div>
</template>

<script>
import { addListener as devtoolsListener } from 'devtools-detector';
export default {
  name: 'Main',
  data() {
    return {
        showError: false,
        geolocation: false,
        locationDisabled: true,
        locationMessage: "Geo Location Services permission Denied",
        currentToken: "",
        qrCode: "",
        qrCodeMessage: "",
        statusInterval: null,
        isLoggedIn: false,
        balancePage: false,
        IdentityPage: true,
        profileStatus: null,
        profile: {
            fname: "",
            lname: "",
            email: "",
            dob: "",
            phone: "",
            location: "",
            reasons:""
        },
        verificationBegin: false,
        verificationProcess: false,
    };
  },
  methods: {
    allowLocation() {
        try {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    this.profile.location = position;
                    this.locationDisabled = false;
                },
                (error) => {
                    this.locationDisabled = true;
                    switch(error.code) {
                        case error.PERMISSION_DENIED:
                            this.locationMessage = "GeoLocation Permission denied.";
                            break;
                        case error.POSITION_UNAVAILABLE:
                            this.locationMessage = "GeoLocation Unavailable.";
                            break;
                        case error.TIMEOUT:
                            this.locationMessage = "GeoLocation Service Timeout.";
                            break;
                        default:
                            this.locationMessage = "Error occurred when trying to fetch geolocation service.";
                            break;
                    }
                },
                {
                    enableHighAccuracy: false,
                    timeout: 10000,
                    maximumAge: 60000
                }
            );
        } catch (error) {
            this.locationDisabled = true;
            this.locationMessage = "GeoLocation Permission denied.";
        }
    },
    async startVerification(){
        if(!(this.profile.email && this.profile.fname && this.profile.lname && this.profile.dob && this.profile.phone)){
            return;
        }
        this.verificationProcess = true;
        this.allowLocation();
        try{
            const response = await fetch("/gidx-customer-registration", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(this.profile)
            });
            const data = await response.json();
            await this.getprofileStatus();
            this.verificationProcess = false;
        }catch(err){
            console.log(err);
            this.verificationProcess = false;
        }
    },
    async getprofileStatus(){
        try {
            const response = await fetch(`/user/profile`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            const data = await response.json();

            if (data.verified === null) {
                this.profileStatus = null;
            }
            if (data.verified === 0) {
                this.profileStatus = 0;
            }
            if (data.verified === 1) {
                this.profileStatus = 1;
            }
            this.profile.dob = data.dob;
            this.profile.fname = data.fname;
            this.profile.lname = data.lname;
            this.profile.email = data.email;
            this.profile.phone = data.phone;
            this.profile.reasons = data.reasons;
        } catch (error) {
            console.error('Error generating QR code:', error);
        }
    },
    async generateQR() {
        this.qrCodeMessage = "";
        try {
            const response = await fetch(`/qr-auth/generate?page=${encodeURIComponent(window.location.pathname)}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            const data = await response.json();

            if (data.qr_code) {
                this.qrCode = `data:image/svg+xml;base64,${data.qr_code}`;
                this.currentToken = data.token;
                this.startStatusChecking();
            }
        } catch (error) {
            console.error('Error generating QR code:', error);
        }
    },
    startStatusChecking() {
        if (this.statusInterval) {
            clearInterval(this.statusInterval);
        }

        this.statusInterval = setInterval(async () => {
            if (!this.currentToken) return;

            try {
                const response = await fetch(`/qr-auth/status/${this.currentToken}`);
                const data = await response.json();

                if (data.status === 'used') {
                    clearInterval(this.statusInterval);
                    this.qrCodeMessage = '✅ Successfully logged in on mobile device!';
                    this.isLoggedIn = true;
                } else if (data.status === 'expired' || data.status === 'invalid') {
                    clearInterval(this.statusInterval);
                    this.qrCodeMessage ='❌ QR code expired. Please generate a new one.';
                }
            } catch (error) {
                console.error('Error checking status:', error);
            }
        }, 5000); // Check every 2 seconds
    },
  },
  mounted() {
    this.getprofileStatus();
    devtoolsListener((isOpen) => {
      this.showError = isOpen;
      setTimeout(()=>{ debugger;}, 100);
    });
    if ('geolocation' in navigator) {
        this.geolocation = true;
        this.allowLocation();
    } else {
        this.generateQR();
    }
    if(window.location.href.includes("customer-balance")){
        this.balancePage = true;
        this.IdentityPage = false;
    }
  }
};
</script>
<style scoped>
    .mainErrorBlock{
        width: 100%;
        height: 100%;
        position: fixed;
        top: 0;
        left: 0;
        display: flex;
        flex-direction: column;
        justify-content: center;
        background: #b22234;
        align-items: center;
        color: #fff;
        z-index: 99999;
    }
    .mainErrorBlock p{
        color: #fff;
        font-size: 1.1rem;
    }
</style>
