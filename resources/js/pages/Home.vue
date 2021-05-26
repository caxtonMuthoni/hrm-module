<template>
  <div class="container">
    <div class="row mt-5">
      <home-stats-card v-for="(card, index) in cardDetails" :key="index" :card-detail="card" />
    </div>
  </div>
</template>

<script>
import HomeStatsCard from '../components/cards/HomeStatsCard.vue';
export default {
  components: { HomeStatsCard },
  data() {
      return {
          cardDetails: []
      }
  },
  mounted() {
    this.setHomedata()
  },

  methods: {
    setHomedata () {
      this.$Progress.start()
      axios.get('/api/homedata').then((response) => {
         this.cardDetails = [
              {
                  color: 'bg-success',
                  value: response.data.employees,
                  icon: 'fas fa-users',
                  title: 'Employees',
                  route: '/employees'
              },
              {
                  color: 'bg-primary',
                  value: response.data.designations,
                  icon: 'fas fa-list',
                  title: 'Designations',
                  route: '/designation'
              },
              {
                  color: 'bg-warning',
                  value: response.data.smses,
                  icon: 'fas fa-envelope',
                  title: 'Sent SMSes',
                  route: '/sms'
              }
          ]
      })
    }
  },
};
</script>
