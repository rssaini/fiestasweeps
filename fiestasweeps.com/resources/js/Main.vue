<template>
  <div>
    <div v-if="geolocation">
        <div v-if="locationDisabled">
            <p>{{ locationMessage }}<br>
                Without Geo Location permission you can verify Identity and add Funds
            </p>
            <p><strong>Geo Location Mandatory for Game Play & entering into any contest.</strong></p>
            <p>Click Button to allow location permissions.</p>
            <button @click="allowLocation">Allow Location</button>
        </div>
        <div v-else>
            <p>Geo location Services are active.</p>
        </div>
    </div>
    <div v-else>
        <p>Geo-Location Services are unavailable in this device.<br>
            Without Geo Location permission you can verify Identity and add Funds
        </p>
        <p><strong>Geo Location Mandatory for Game Play & entering into any contest.</strong></p>
    </div>

    <div v-if="showError" class="mainErrorBlock">
        <p>Developer Tools Detected. Please close developer tools to continue</p>
    </div>
    <div v-else>
        <p>Code here</p>
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
}
  },
  mounted() {
    devtoolsListener((isOpen) => {
      this.showError = isOpen;
    });
    if ('geolocation' in navigator) {
        this.geolocation = true;
        this.allowLocation();
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
