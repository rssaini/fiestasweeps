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
                <p>Geo location Services are active.</p>
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
                <p>Scan this QR code with your mobile device to log in</p>
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
    };
  },
  methods: {
    allowLocation() {
        try {
            navigator.geolocation.getCurrentPosition(
                (position) => {
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
    devtoolsListener((isOpen) => {
      this.showError = isOpen;
      setTimeout(()=>{ debugger;}, 100);
    });
    if (!('geolocation' in navigator)) {
        this.geolocation = true;
        this.allowLocation();
    } else {
        this.generateQR();
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
