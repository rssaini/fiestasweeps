<template>
  <div v-if="showApp">
    <h3>Identity verification code here</h3>
  </div>
</template>

<script>
import { addListener as devtoolsListener } from 'devtools-detector';
export default {
  name: 'App',
  data() {
    return {
        showApp: true
    };
  },
  computed: {

  },
  mounted() {
    devtoolsListener((isOpen) => {
      this.showApp = !isOpen;
      if(isOpen){
        setTimeout(() => {
            document.getElementById('mainErrorBlock').style.display = "flex";
        }, 1000);
      }
    });
  }
};
</script>
